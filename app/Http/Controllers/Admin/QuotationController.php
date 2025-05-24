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
