<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Mail\QuotationMail;
use App\Exports\QuotationExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Leads::with(['products', 'user', 'assign'])
            ->where('status', 'Quotation / Ready To Buy')
            ->orderBy('is_pinned', 'DESC')
            ->orderBy('created_at', 'DESC');
// dd($query);
        if ($user->id == 1) {
            // Super admin sees all leads
            $leads = $query->get();

        } elseif ($user->id == 2) {
            // Admin sees leads assigned to them
            $leads = $query->where('assigned_name', $user->id)->get();
        } else {
            // Regular users see only leads they created or are assigned to
            $leads = $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('assigned_name', $user->id);
            })->get();
        }

        $products = Products::all();
        return view('admin.quotations.index', [
            'leads' => $leads,
            'products' => $products,
            'message' => $leads->isEmpty() ? 'No leads found.' : null
        ]);
    }

    public function togglePin(Leads $lead)
    {
        abort_if(Gate::denies('lead_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lead->update(['is_pinned' => !$lead->is_pinned]);

        return back()->with('success', 'Lead pin status updated successfully');
    }

public function updateQuotation(Request $request, $id)
{
    try {
        $validated = $this->validateQuotationRequest($request);
        $lead = Leads::findOrFail($id); // Will throw 404 if not found

        $this->updateLeadData($lead, $validated, $request);
        $this->syncProducts($lead, $request->product_details_json);

        if ($request->has('send_email')) {
            $pdfPath = $this->generateQuotationPdf($lead); // Make sure this method exists
            $user = auth()->user();
            $this->sendEmail($lead, $pdfPath, $user); // Define this too

            $lead->update([
                'mail_status' => 1,
                'last_updated_by' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quotation updated and email sent successfully.',
                'pdf_url' => asset('storage/quotations/' . basename($pdfPath)),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Quotation updated successfully',
        ]);

    } catch (\Exception $e) {
        \Log::error('Failed to update/send email: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to update/send email: ' . $e->getMessage()
        ], 500);
    }
}



    // public function updateQuotation(Request $request, $id)
    // {

    //     $validated = $this->validateQuotationRequest($request);
    //     $lead = Leads::findOrFail($id);

    //     $this->updateLeadData($lead, $validated, $request);
    //     $this->syncProducts($lead, $request->product_details_json);
    //     if ($request->has('send_email')) {
    //         return $this->sendQuotationEmail($lead->id);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Quotation updated successfully'
    //     ]);
    // }

//    public function sendQuotationEmail($leadId)
// {
//     try {
//         $lead = Leads::with('products')->findOrFail($leadId);
//         $user = auth()->user();

//         $pdfPath = $this->generateQuotationPdf($lead); // You should define this method
//         $this->sendEmail($lead, $pdfPath, $user);      // You should define this method

//         $lead->update([
//             'mail_status' => 1,
//             'last_updated_by' => $user->id
//         ]);

//         return response()->json([
//             'success' => true,
//             'message' => 'Quotation email sent successfully',
//             'pdf_url' => asset('storage/quotations/' . basename($pdfPath))
//         ]);

//     } catch (\Exception $e) {
//         \Log::error('Quotation Email Error: ' . $e->getMessage());
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to send quotation email: ' . $e->getMessage()
//         ], 500);
//     }
// }




    public function getLeadProducts($leadId)
    {
        try {
            $lead = Leads::with('products')->findOrFail($leadId);

            $productDetails = $lead->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->pivot->price,
                    'discount' => $product->pivot->discount,
                    'description' => $product->pivot->description,
                    'tax' => $product->pivot->tax_percentage,
                    'price_after_discount' => $product->pivot->price_after_discount,
                    'tax_amount' => $product->pivot->tax_amount,
                    'total' => $product->pivot->total_amount
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $lead->products->pluck('id')->toArray(),
                'product_details' => $productDetails
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching products: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $user = auth()->user();
        $query = Leads::with(['products', 'user', 'assign'])
            ->where('status', 'Quotation / Ready To Buy');

        if ($user->id == 1) {
            // Super admin exports all
        } elseif ($user->id == 2) {
            // Admin exports all (same as super admin in your code)
        } else {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('assigned_name', $user->id);
            });
        }

        $data = $query->get()->map(function ($lead) {
            return [
                'id' => $lead->id,
                'assigned_By' => optional($lead->assignedBy)->name,
                'assigned_to' => optional($lead->assign)->name,
                'name' => $lead->name,
                'mobile' => $lead->mobile,
                'email' => $lead->email,
                'address' => $lead->address,
                'industry' => $lead->industry,
                'purpose' => $lead->purpose,
                'status' => $lead->status,
                'source' => $lead->source,
                'product_names' => $lead->products->pluck('name')->implode(', '),
                'remarks' => $lead->remarks,
                'created_at' => optional($lead->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($lead->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return Excel::download(new QuotationExport($data), 'Quotation_' . now()->format('Ymd_His') . '.xlsx');
    }

    protected function validateQuotationRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:30',
            'mobile' => 'required|digits:10',
            'email' => 'required|email|max:100',
            'address' => 'nullable|max:300',
            'industry' => 'nullable|max:100',
            'purpose' => 'nullable',
            'product_details_json' => 'required|json',
            'quotation_amount' => 'required|numeric|min:0|max:9999999999.99',
            'quotation_discount' => 'required|numeric|min:0|max:9999999999.99',
            'quotation_tax' => 'required|numeric|min:0|max:9999999999.99',
            'quotation_total' => 'required|numeric|min:0|max:9999999999.99',
            'quotation_reference' => 'nullable',
            'quotation_validity' => 'nullable|integer|min:1',
            'quotation_expiry_date' => 'nullable|date',
            'terms' => 'nullable|array',
            'additional_terms' => 'nullable',
            'quotation_notes' => 'nullable',
            'about_us' => 'nullable',
            'quotation_opened_at' => 'nullable'
        ]);
    }

    protected function updateLeadData(Leads $lead, array $validated, Request $request)
    {
        $data = [
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'purpose' => $validated['purpose'],
            'about_us' => $validated['about_us'],
            'quotation_amount' => $validated['quotation_amount'],
            'quotation_discount' => $validated['quotation_discount'],
            'quotation_tax' => $validated['quotation_tax'],
            'quotation_total' => $validated['quotation_total'],
            'quotation_reference' => $validated['quotation_reference'],
            'quotation_validity' => $validated['quotation_validity'],
            'quotation_expiry_date' => $validated['quotation_expiry_date'] ??
                Carbon::now()->addDays($validated['quotation_validity'])->format('Y-m-d'),
            'quotation_terms' => json_encode(array_merge(
                $validated['terms'] ?? [],
                !empty($validated['additional_terms']) ? [$validated['additional_terms']] : []
            )),
            'quotation_notes' => $validated['quotation_notes'],
            'last_updated_by' => auth()->id()
        ];

        if ($request->has('quotation_opened_at')) {
            $data['opened_at'] = Carbon::now();
        }

        $lead->update($data);
    }

    protected function syncProducts(Leads $lead, string $productDetailsJson)
    {
        $productsData = [];
        $productDetails = json_decode($productDetailsJson, true);

        foreach ($productDetails as $product) {
            $productsData[$product['id']] = [
                'price' => $product['price'],
                'discount' => $product['discount'],
                'tax_percentage' => $product['tax'],
                'price_after_discount' => $product['price_after_discount'],
                'tax_amount' => $product['tax_amount'],
                'total_amount' => $product['total']
            ];
        }

        $lead->products()->sync($productsData);
    }

    protected function generateQuotationPdf(Leads $lead)
    {
        $pdfDir = storage_path('app/public/quotations');
        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0755, true);
        }

        $filename = 'quotation_' . $lead->id . '_' . now()->format('YmdHis') . '.pdf';
        $pdfPath = $pdfDir . '/' . $filename;

        PDF::loadView('admin.quotations.quotation', [
            'lead' => $lead,
            'products' => $lead->products,
            'terms' => json_decode($lead->quotation_terms, true),
            'date' => now()->format('d/m/Y'),
            'expiry_date' => Carbon::parse($lead->quotation_expiry_date)->format('d M, Y'),
        ])->setPaper('a4')
          ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
          ->save($pdfPath);

        return $pdfPath;
    }

    protected function sendEmail(Leads $lead, string $pdfPath, User $user)
    {
        Mail::to($lead->email)->send(new QuotationMail(
            $lead,
            $pdfPath,
            $user->email,
            $user->name
        ));
    }
}
