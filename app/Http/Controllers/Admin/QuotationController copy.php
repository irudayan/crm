<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Products;
use PDF;
use Mail;
use App\Mail\QuotationMail;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Http; // For WhatsApp API (Interakt)
use Illuminate\Support\Facades\Storage;
use App\Exports\QuotationExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $assignedName = User::select('id', 'name')->distinct()->get();

        if (auth()->id() == 1) {
            $leads = Leads::with('products', 'user','assign')->where('status', 'Quotation / Ready To Buy')->get();
        } elseif (auth()->id() == 2) {
              // Admin sees leads assigned to them
                $leads = Leads::with('products', 'user','assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Quotation / Ready To Buy')
                ->get();
        } else {
              // Regular users see only leads they created
                $leads = Leads::with('products', 'user','assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Quotation / Ready To Buy')
                ->get();

        }

        $products = Products::all();
        $selectedProducts = [];

        return view('admin.quotations.index', compact('leads', 'products', 'selectedProducts'))
        ->with('message', $leads->isEmpty() ? 'No leads found.' : null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quotations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     PRODUCT_ID => 'required|integer',
        // ]);
        Leads::create($request->all());
        return redirect()->route('admin.quotations.index')->with('success', 'Quotation created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //
    }

public function sendQuotationEmail($leadId)
    {
        // dd($leadId);
        $lead = Leads::findOrFail($leadId);

         // Only selected products from product_ids


         $products = Products::whereIn('id', $lead->product_ids ?? [])->get();

        $user = Auth::user();

        $senderEmail = $user->email;
        $senderName = $user->name;

        // Generate PDF
        $pdf = PDF::loadView('admin.quotations.quotation', compact('lead', 'products'));
        $pdfPath = storage_path("app/public/quotation_{$lead->id}.pdf");
        $pdf->save($pdfPath);

        // Send Email
        Mail::to($lead->email)->send(new QuotationMail($lead, $pdfPath, $senderEmail, $senderName));

        // Send WhatsApp Message via Interakt
        $this->sendWhatsappQuotation($lead, $pdfPath); // ✅ fixed method call

        // Update lead status
        $lead->update([
            'mail_status' => 1,
            'last_updated_by' => auth()->id(), // ✅ correctly added inside array
        ]);

        // return $pdf->stream("quotation_{$lead->id}.pdf");
        return back()->with('success', 'Quotation email sent successfully.');
    }



    public function sendWhatsappQuotation($lead, $pdfPath)
    {
        $accessToken = env('INTERAKT_API_KEY');
        $phoneNumber = $lead->mobile;

        if (!str_starts_with($phoneNumber, '+')) {
            $phoneNumber = '+91' . ltrim($phoneNumber, '0');
        }

        $publicPath = "public/quotation_{$lead->id}.pdf";
        if (!Storage::exists($publicPath)) {
            Storage::put($publicPath, file_get_contents($pdfPath));
        }

        $fileUrl = asset("storage/quotation_{$lead->id}.pdf");

        // Send API request to use Template message
        $response = Http::withHeaders([
            'Authorization' => "Basic {$accessToken}",
            'Content-Type' => 'application/json',
        ])->post('https://api.interakt.ai/v1/public/message/', [
            "fullPhoneNumber" => $phoneNumber,
            "type" => "Template",
            "template" => [
                "name" => "quotation_pdf",           // Ensure this matches the approved template name
                "languageCode" => "en_US",              // Ensure this matches the approved language
                "headerValues" => [
                    [
                        "type" => "document",
                        "media" => [
                            "url" => $fileUrl,
                            "filename" => "Quotation.pdf"
                        ]
                    ]
                ],
                "bodyValues" => [$lead->name]        // Matches {{1}} in the template body
            ],
            "callbackData" => "Quotation_Sent"
        ]);

        dd($response->status(), $response->body()); // For debugging
    }


        // export
    public function exportinquotations(Request $request)
    {
        $user = auth()->user();

        if ($user->id == 1) {
            $leads = Leads::with('products', 'user', 'assign')->where('status', 'Quotation / Ready To Buy')->get();
        } elseif ($user->id == 2) {
            $leads = Leads::with('products', 'user', 'assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Quotation / Ready To Buy')->get();
        } else {
            $leads = Leads::with('products', 'user', 'assign')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('assigned_name', $user->id);
                })
                ->where('status', 'Quotation / Ready To Buy')->get();
        }

        $data = $leads->map(function ($lead) {
            return [
                'id' => $lead->id,
                // 'user' => optional($lead->user)->name,
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
                // 'demo_date' => $lead->demo_date,
                // 'demo_time' => $lead->demo_time,
                // 'follow_date' => $lead->follow_date,
                // 'follow_time' => $lead->follow_time,
                'created_at' => optional($lead->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($lead->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return Excel::download(new QuotationExport($data), 'Quotation_' . now()->format('Ymd_His') . '.xlsx');
    }
}
