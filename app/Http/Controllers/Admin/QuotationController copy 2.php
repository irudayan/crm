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
use Carbon\Carbon;

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
            $leads = Leads::with('products', 'user','assign')->where('status', 'Quotation / Ready To Buy')
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } elseif (auth()->id() == 2) {
              // Admin sees leads assigned to them
                $leads = Leads::with('products', 'user','assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Quotation / Ready To Buy')
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
              // Regular users see only leads they created
                $leads = Leads::with('products', 'user','assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Quotation / Ready To Buy')
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();

        }

        $products = Products::all();
        $selectedProducts = [];

        return view('admin.quotations.index', compact('leads', 'products', 'selectedProducts'))
        ->with('message', $leads->isEmpty() ? 'No leads found.' : null);
    }


    public function togglePin(Leads $lead)
    {
        abort_if(Gate::denies('lead_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lead->update(['is_pinned' => !$lead->is_pinned]);

        return back()->with('success', 'Lead pin status updated successfully');
    }



// public function updateQuotation(Request $request, $id)
// {

//     dd($id);
//     $request->validate([
//         'name' => 'required|max:30',
//         'mobile' => 'required|digits:10',
//         'email' => 'nullable|email|max:100',
//         'address' => 'nullable|max:300',
//         'industry' => 'nullable|max:100',
//         'purpose' => 'nullable',
//         'product_ids' => 'required|array',
//         'product_ids.*' => 'exists:products,id',
//         'quotation_amount' => 'nullable|numeric|min:0',
//         'quotation_tax' => 'nullable|numeric|min:0|max:100',
//         'quotation_reference' => 'nullable',
//         'quotation_validity' => 'nullable|integer|min:1',
//         'quotation_expiry_date' => 'nullable|date',
//         'terms' => 'nullable|array',
//         'additional_terms' => 'nullable',
//         'quotation_notes' => 'nullable',
//         'about_us' => 'nullable',
//         'quotation_opened_at' => 'required|accepted',
//         'product_details_json' => 'nullable|json'
//     ]);

//     $lead = Leads::findOrFail($id);

//     // Calculate expiry date if validity days is provided
//     $expiryDate = null;
//     if ($request->quotation_validity) {
//         $expiryDate = Carbon::now()->addDays($request->quotation_validity)->format('Y-m-d');
//     }

//     // Combine standard and custom terms
//     $terms = [];
//     if ($request->terms) {
//         $terms = $request->terms;
//     }
//     if ($request->additional_terms) {
//         $terms[] = $request->additional_terms;
//     }

//     $data = [
//         'name' => $request->name,
//         'mobile' => $request->mobile,
//         'email' => $request->email,
//         'address' => $request->address,
//         'industry' => $request->industry,
//         'purpose' => $request->purpose,
//         'product_ids' => $request->product_ids,
//         'quotation_amount' => $request->quotation_amount,
//         'quotation_tax' => $request->quotation_tax,
//         'quotation_reference' => $request->quotation_reference,
//         'quotation_validity' => $request->quotation_validity,
//         'quotation_expiry_date' => $request->quotation_expiry_date ?: $expiryDate,
//         'quotation_terms' => $terms,
//         'quotation_notes' => $request->quotation_notes,
//         'about_us' => $request->about_us,
//         'last_updated_by' => auth()->id(),
//     ];

//     if ($request->quotation_opened_at) {
//         $data['opened_at'] = now();
//     }

//     $lead->update($data);

//     // Sync products with pivot data (price and tax)
//     $products = [];
//     $productDetails = json_decode($request->product_details_json, true) ?? [];

//     foreach ($productDetails as $product) {
//         $products[$product['id']] = [
//             'price' => $product['price'],
//             'tax' => $product['tax']
//         ];
//     }
//     // $lead->products()->sync($products);
//     $lead->products()->sync($request->input('product_ids', []));

//     // If this is an AJAX request (PDF generation), return the PDF URL
//     if ($request->ajax()) {
//         $pdf = $this->generateQuotationPdf($lead);

//         // Save PDF to storage
//         $filename = 'quotation_'.$lead->id.'_'.time().'.pdf';
//         Storage::put('public/quotations/'.$filename, $pdf->output());

//         // Update lead with PDF path
//         $lead->update([
//             'quotation_pdf_path' => 'quotations/'.$filename
//         ]);

//         return response()->json([
//             'pdf_url' => asset('storage/quotations/'.$filename)
//         ]);
//     }

//     return redirect()->route('admin.quotations.index')
//         ->with('success', 'Quotation updated successfully.');
// }

// public function updateQuotation(Request $request, $id)
// {
//     $request->validate([
//         'name' => 'required|max:30',
//         'mobile' => 'required|digits:10',
//         'email' => 'nullable|email|max:100',
//         'address' => 'nullable|max:300',
//         'industry' => 'nullable|max:100',
//         'purpose' => 'nullable',
//         'product_ids' => 'required|array',
//         'product_ids.*' => 'exists:products,id',
//         'quotation_amount' => 'required|numeric|min:0',
//         'quotation_tax' => 'required|numeric|min:0|max:100',
//         'quotation_reference' => 'nullable',
//         'quotation_validity' => 'nullable|integer|min:1',
//         'quotation_expiry_date' => 'nullable|date',
//         'terms' => 'nullable|array',
//         'additional_terms' => 'nullable',
//         'quotation_notes' => 'nullable',
//         'about_us' => 'nullable',
//         'quotation_opened_at' => 'required|accepted',
//         'product_details_json' => 'required|json'
//     ]);

//     $lead = Leads::findOrFail($id);

//     // Calculate expiry date if validity days is provided
//     $expiryDate = null;
//     if ($request->quotation_validity) {
//         $expiryDate = Carbon::now()->addDays($request->quotation_validity)->format('Y-m-d');
//     }

//     // Combine standard and custom terms
//     $terms = [];
//     if ($request->terms) {
//         $terms = $request->terms;
//     }
//     if ($request->additional_terms) {
//         $terms[] = $request->additional_terms;
//     }

//     $data = [
//         'name' => $request->name,
//         'mobile' => $request->mobile,
//         'email' => $request->email,
//         'address' => $request->address,
//         'industry' => $request->industry,
//         'purpose' => $request->purpose,
//         'quotation_amount' => $request->quotation_amount,
//         'quotation_tax' => $request->quotation_tax,
//         'quotation_reference' => $request->quotation_reference,
//         'quotation_validity' => $request->quotation_validity,
//         'quotation_expiry_date' => $request->quotation_expiry_date ?: $expiryDate,
//         'quotation_terms' => $terms,
//         'quotation_notes' => $request->quotation_notes,
//         'about_us' => $request->about_us,
//         'last_updated_by' => auth()->id(),
//     ];

//     if ($request->quotation_opened_at) {
//         $data['opened_at'] = now();
//     }

//     $lead->update($data);

//     // Sync products with pivot data (price and tax)
//     $products = [];
//     $productDetails = json_decode($request->product_details_json, true) ?? [];

//     foreach ($productDetails as $product) {
//         $products[$product['id']] = [
//             'price' => $product['price'],
//             'tax' => $product['tax']
//         ];
//     }

//     $lead->products()->sync($products);

//     // If this is an AJAX request (PDF generation), return the PDF URL
//     if ($request->ajax()) {
//         $pdf = $this->generateQuotationPdf($lead);

//         // Save PDF to storage
//         $filename = 'quotation_'.$lead->id.'_'.time().'.pdf';
//         Storage::put('public/quotations/'.$filename, $pdf->output());

//         // Update lead with PDF path
//         $lead->update([
//             'quotation_pdf_path' => 'quotations/'.$filename
//         ]);

//         return response()->json([
//             'pdf_url' => asset('storage/quotations/'.$filename)
//         ]);
//     }

//     return redirect()->route('admin.quotations.index')
//         ->with('success', 'Quotation updated successfully.');
// }

public function updateQuotation(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:30',
        'mobile' => 'required|digits:10',
        'email' => 'nullable|email|max:100',
        'address' => 'nullable|max:300',
        'industry' => 'nullable|max:100',
        'purpose' => 'nullable',
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id',
        'quotation_amount' => 'required|numeric|min:0',
        'quotation_tax' => 'required|numeric|min:0|max:100',
        'quotation_reference' => 'nullable',
        'quotation_validity' => 'nullable|integer|min:1',
        'quotation_expiry_date' => 'nullable|date',
        'terms' => 'nullable|array',
        'additional_terms' => 'nullable',
        'quotation_notes' => 'nullable',
        'about_us' => 'nullable',
        'quotation_opened_at' => 'required|accepted',
        'product_details_json' => 'required|json'
    ]);

    $lead = Leads::findOrFail($id);

    // Calculate expiry date if validity days is provided
    $expiryDate = null;
    if ($request->quotation_validity) {
        $expiryDate = Carbon::now()->addDays($request->quotation_validity)->format('Y-m-d');
    }

    // Combine standard and custom terms
    $terms = $request->terms ?? [];
    if ($request->additional_terms) {
        $additionalTerms = array_filter(array_map('trim', explode("\n", $request->additional_terms)));
        $terms = array_merge($terms, $additionalTerms);
    }

    $data = [
        'name' => $request->name,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'address' => $request->address,
        'industry' => $request->industry,
        'purpose' => $request->purpose,
        'quotation_amount' => $request->quotation_amount,
        'quotation_tax' => $request->quotation_tax,
        'quotation_reference' => $request->quotation_reference,
        'quotation_validity' => $request->quotation_validity,
        'quotation_expiry_date' => $request->quotation_expiry_date ?: $expiryDate,
        'quotation_terms' => $terms,
        'quotation_notes' => $request->quotation_notes,
        'about_us' => $request->about_us,
        'last_updated_by' => auth()->id(),
    ];

    if ($request->quotation_opened_at) {
        $data['opened_at'] = now();
    }

    $lead->update($data);

    // Sync products with pivot data (price and tax)
    $products = [];
    $productDetails = json_decode($request->product_details_json, true) ?? [];

    foreach ($productDetails as $product) {
        $products[$product['id']] = [
            'price' => $product['price'],
            'tax' => $product['tax']
        ];
    }

    // $lead->products()->sync($products);
        $lead->products()->sync($request->input('product_ids', []));

    // If this is an AJAX request (PDF generation), return the PDF URL
    if ($request->ajax()) {
        $pdf = $this->generateQuotationPdf($lead);

        // Save PDF to storage
        $filename = 'quotation_'.$lead->id.'_'.time().'.pdf';
        Storage::put('public/quotations/'.$filename, $pdf->output());

        // Update lead with PDF path
        $lead->update([
            'quotation_pdf_path' => 'quotations/'.$filename
        ]);

        return response()->json([
            'pdf_url' => asset('storage/quotations/'.$filename)
        ]);
    }


           $lead->update($data);

        // Sync the products (many-to-many relationship)
    

    return redirect()->route('admin.quotations.index')
        ->with('success', 'Quotation updated successfully.');
}

private function generateQuotationPdf($lead)
{
    $products = $lead->products;
    $terms = $lead->quotation_terms ?? [];

    $data = [
        'lead' => $lead,
        'products' => $products,
        'tax_rate' => $lead->quotation_tax,
        'quotation_reference' => $lead->quotation_reference,
        'validity_days' => $lead->quotation_validity,
        'notes' => $lead->quotation_notes,
        'terms' => is_array($terms) ? $terms : json_decode($terms, true),
        'additional_terms' => null // Already included in terms
    ];

    return PDF::loadView('admin.quotations.quotation', $data);
}

public function generatePdf(Request $request)
{
    try {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|exists:leads,id',
            'name' => 'required',
            'product_ids' => 'required|array',
            'quotation_amount' => 'required|numeric',
            'quotation_tax' => 'required|numeric',
        ]);

        // Get lead data
        $lead = Leads::findOrFail($request->id);

        // Get products with their details
        $products = [];
        foreach ($request->product_ids as $productId) {
            $product = Products::find($productId);
            if ($product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'tax_rate' => $product->tax_rate
                ];
            }
        }

        // Prepare data for PDF
        $data = [
            'lead' => $lead,
            'products' => $products,
            'tax_rate' => $request->quotation_tax,
            'quotation_reference' => $request->quotation_reference,
            'validity_days' => $request->quotation_validity,
            'notes' => $request->quotation_notes,
            'terms' => $request->terms ?: [],
            'additional_terms' => $request->additional_terms,
        ];

        // Generate PDF
        $pdf = PDF::loadView('admin.quotations.quotation', $data);

        // Ensure storage directory exists
        if (!Storage::exists('public/quotations')) {
            Storage::makeDirectory('public/quotations');
        }

        // Save PDF to storage
        $filename = 'quotation_'.$lead->id.'_'.time().'.pdf';
        Storage::put('public/quotations/'.$filename, $pdf->output());

        // Update lead with PDF path
        $lead->update([
            'quotation_pdf_path' => 'quotations/'.$filename,
            'quotation_amount' => $request->quotation_amount,
            'quotation_tax' => $request->quotation_tax,
            'quotation_reference' => $request->quotation_reference,
            'quotation_validity' => $request->quotation_validity,
            'quotation_expiry_date' => $request->quotation_expiry_date,
            'quotation_notes' => $request->quotation_notes,
            'quotation_terms' => json_encode(array_merge(
                $request->terms ?? [],
                $request->additional_terms ? [$request->additional_terms] : []
            )),
        ]);

        return $pdf->download($filename);

    } catch (\Exception $e) {
        \Log::error('PDF Generation Error: '.$e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function previewPdf($id)
{
    $lead = Leads::findOrFail($id);

    if (!$lead->quotation_pdf_path) {
        abort(404, 'Quotation PDF not found');
    }


    Storage::put('public/quotations/'.$filename, $pdf->output());
    return response()->file($path);
}

// public function sendQuotationEmail(Request $request)
// {
//     $validated = $request->validate([
//         'lead_id' => 'required|exists:leads,id',
//         'email' => 'required|email',
//     ]);

//     $lead = Lead::findOrFail($request->lead_id);

//     if (!$lead->quotation_pdf_path) {
//         return back()->with('error', 'Please generate the PDF first before sending.');
//     }

//     $pdfPath = storage_path('app/public/'.$lead->quotation_pdf_path);

//     Mail::to($request->email)->send(new QuotationEmail($lead, $pdfPath));

//     // Update lead status
//     $lead->update([
//         'quotation_sent_at' => now(),
//         'status' => 'quotation_sent'
//     ]);

//     return back()->with('success', 'Quotation email sent successfully!');
// }


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



        // public function sendQuotationEmail($leadId)
        // {
        //     // dd($leadId);
        //     $lead = Leads::findOrFail($leadId);

        //         // Only selected products from product_ids
        //         $products = Products::whereIn('id', $lead->product_ids ?? [])->get();

        //     $user = Auth::user();

        //     $senderEmail = $user->email;
        //     $senderName = $user->name;

        //     // Generate PDF
        //     $pdf = PDF::loadView('admin.quotations.quotation', compact('lead', 'products'));
        //     $pdfPath = storage_path("app/public/quotation_{$lead->id}.pdf");
        //     $pdf->save($pdfPath);

        //     // Send Email
        //     Mail::to($lead->email)->send(new QuotationMail($lead, $pdfPath, $senderEmail, $senderName));

        //     // Send WhatsApp Message via Interakt
        //     $this->sendWhatsappQuotation($lead, $pdfPath); // ✅ fixed method call

        //     // Update lead status
        //     $lead->update([
        //         'mail_status' => 1,
        //         'last_updated_by' => auth()->id(), // ✅ correctly added inside array
        //     ]);

        //     // return $pdf->stream("quotation_{$lead->id}.pdf");
        //     return back()->with('success', 'Quotation email sent successfully.');
        // }




        // public function sendWhatsappQuotation($lead, $pdfPath)
        // {
        //     $accessToken = env('INTERAKT_API_KEY');

        //     // Format phone number
        //     $phoneNumber = $lead->mobile;
        //     if (!str_starts_with($phoneNumber, '+')) {
        //         $phoneNumber = ltrim($phoneNumber, '0'); // Remove leading zero
        //     }

        //     // Store PDF in public folder if not exists
        //     $publicPath = "public/quotation_{$lead->id}.pdf";
        //     if (!Storage::exists($publicPath)) {
        //         Storage::put($publicPath, file_get_contents($pdfPath));
        //     }

        //     $fileUrl = asset("storage/quotation_{$lead->id}.pdf");

        //     // Compose message
        //     $message = "Hello {$lead->name} ({$lead->email}),\nPlease find the attached quotation.";

        //     // Payload for Interakt API
        // $payload = [
        //     "countryCode" => "91",
        //     "phoneNumber" => $phoneNumber,
        //     "callbackData" => "Quotation_Sent",
        //     "type" => "Document", // Must be capital "D"
        //     "data" => [
        //         "url" => $fileUrl,
        //         "mediaUrl" => $fileUrl,
        //         "caption" => $message,
        //         "fileName" => "Quotation_{$lead->id}.pdf"
        //     ]
        // ];

        //     // Send the request
        //     $response = Http::withHeaders([
        //         'Authorization' => "Basic {$accessToken}",
        //         'Content-Type' => 'application/json',
        //     ])->post('https://api.interakt.ai/v1/public/message/', $payload);

        //     // Optional: log or check result
        //     if ($response->successful()) {
        //         \Log::info('WhatsApp message sent for lead ID: ' . $lead->id);
        //     } else {
        //         \Log::error('Failed to send WhatsApp message: ' . $response->body());
        //     }

        //     dd($response->status(), $response->body()); // Debugging

        //     return $response->json();
        // }

        public function sendWhatsappQuotation($lead, $pdfPath)
        {
            $accessToken = env('INTERAKT_API_KEY');

            // Format phone number (remove leading zero, no +)
            $phoneNumber = ltrim($lead->mobile, '0');

            // Store the PDF publicly (if not already)
            $publicPath = "public/quotation_{$lead->id}.pdf";
            if (!Storage::exists($publicPath)) {
                Storage::put($publicPath, file_get_contents($pdfPath));
            }

            // Public URL to file
            $fileUrl = asset("storage/quotation_{$lead->id}.pdf");

            // Compose message
            $message = "Hello {$lead->name} ({$lead->email}),\nPlease find the attached quotation.";

            // Prepare payload
            $payload = [
                "countryCode" => "91",
                "phoneNumber" => $phoneNumber,
                "callbackData" => "Quotation_Sent",
                "type" => "Document", // Capital "D" is important
                "data" => [
                    "url" => $fileUrl,                     // Required public URL
                    "mediaUrl" => $fileUrl,               // Required again as per Interakt spec
                    "caption" => $message,                // Optional message
                    "fileName" => "Quotation_{$lead->id}.pdf"  // Optional file name
                ]
            ];

            // Send the request to Interakt
            $response = Http::withHeaders([
                'Authorization' => "Basic {$accessToken}",
                'Content-Type' => 'application/json',
            ])->post('https://api.interakt.ai/v1/public/message/', $payload);

            // Handle response
            if ($response->successful()) {
                \Log::info("✅ WhatsApp quotation sent to {$lead->mobile} (Lead ID: {$lead->id})");
            } else {
                \Log::error("❌ WhatsApp send failed: " . $response->body());
            }

            // Debug only: remove in production
            dd($response->status(), $response->body());

            // Optionally return response
            // return $response->json();
        }



        //     public function sendWhatsappQuotation($lead, $pdfPath)
        // {
        //     $accessToken = env('INTERAKT_API_KEY');
        //     $phoneNumber = $lead->mobile;

        //     // Format phone number
        //     if (!str_starts_with($phoneNumber, '+')) {
        //         $phoneNumber = '+91' . ltrim($phoneNumber, '0');
        //     }

        //     // Save file to public storage if it doesn't exist
        //     $publicPath = "public/quotation_{$lead->id}.pdf";
        //     if (!Storage::exists($publicPath)) {
        //         Storage::put($publicPath, file_get_contents($pdfPath));
        //     }

        //     $fileUrl = asset("storage/quotation_{$lead->id}.pdf");

        //     // Build the payload for Interakt document message
        //     $payload = [
        //         "countryCode" => "91",
        //         "phoneNumber" => ltrim($lead->mobile, '0'),
        //         "callbackData" => "Quotation_Sent",
        //         "type" => "document",
        //         "data" => [
        //             "url" => $fileUrl,
        //             "mediaUrl" => "quotation_{$lead->id}.pdf",
        //             "caption" => "Please find the quotation attached for your reference."
        //         ]
        //     ];

        //     // Send request
        //     $response = Http::withHeaders([
        //         'Authorization' => "Basic {$accessToken}",
        //         'Content-Type' => 'application/json',
        //     ])->post('https://api.interakt.ai/v1/public/message/', $payload);

        //     dd($response->status(), $response->body()); // Debugging

        //     return response()->json(['success' => 'WhatsApp message sent']);
        // }


        // export
    public function exportinquotations(Request $request)
    {
        $user = auth()->user();

        if ($user->id == 1) {
            $leads = Leads::with('products', 'user', 'assign')->where('status', 'Quotation / Ready To Buy')->get();
        } elseif ($user->id == 2) {
            // $leads = Leads::with('products', 'user', 'assign')
            //     ->where('assigned_name', $user->id)
            //     ->where('status', 'Quotation / Ready To Buy')->get();
            $leads = Leads::with('products', 'user', 'assign')->where('status', 'Quotation / Ready To Buy')->get();
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