<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apponitments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use App\Models\Products;
use Mail;
use App\Mail\DemoMail;
use App\Models\User;
use App\Exports\AppointmentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;



class ApponitmentsController extends Controller
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
            $leads = Leads::with('products', 'user','assign')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } elseif (auth()->id() == 2) {
              // Admin sees leads assigned to them
                // $leads = Leads::with('products', 'user','assign')
                // ->where('assigned_name', $user->id)
                // ->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])
                // ->orderBy('is_pinned', 'DESC') // Pinned first
                // ->orderBy('created_at', 'DESC')
                // ->get();
                 $leads = Leads::with('products', 'user','assign')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } else {
              // Regular users see only leads they created
                $leads = Leads::with('products', 'user','assign')
                ->where('user_id', $user->id)
                ->whereIn('status', ['Online Demo', 'Offline Demo','Onsite Visit'])
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();

        }



        // $leads = Leads::where('status', 'Online Demo')->get();
        $products = Products::all();
        $selectedProducts = [];
        return view('admin.appointments.index', compact('leads', 'products', 'selectedProducts'))
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apponitments  $apponitments
     * @return \Illuminate\Http\Response
     */
    public function show(Apponitments $apponitments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apponitments  $apponitments
     * @return \Illuminate\Http\Response
     */
    public function edit(Apponitments $apponitments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apponitments  $apponitments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apponitments $apponitments )
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'status' => 'required|string',
            'follow_date' => 'nullable|date',
            'follow_time' => 'nullable',
            'source' => 'nullable|string',
            'assigned_name' => 'required|exists:users,id', // Ensure assigned_name exists
            'product_ids' => 'required|array', // Ensure product_ids is an array
            'product_ids.*' => 'exists:products,id', // Ensure each product_id exists in the products table
            'remarks' => 'nullable|string',
            'purpose' => 'nullable|string',
            // 'opened_at' => 'nullable|date|after:now', // Optional: only allow future dates
        ]);


       // Ensure the assigned_name is updated properly

        $validatedData['user_id'] = $request->assigned_name;

        // Convert empty follow_date/time to null explicitly
        $validatedData['follow_date'] = $request->filled('follow_date') ? $request->follow_date : null;
        $validatedData['follow_time'] = $request->filled('follow_time') ? $request->follow_time : null;

        // Handle opened_at manually
        if ($request->has('edit_opened_at')) {
            $validatedData['opened_at'] = now(); // Save current timestamp
        } else {
            $validatedData['opened_at'] = null; // Save null if not checked
        }


          // ✅ Set last updated user
        $validatedData['last_updated_by'] = auth()->id();

        // Update the lead with validated data
        $lead->update($validatedData);

        // Sync the products (many-to-many relationship)
        $lead->products()->sync($request->input('product_ids', []));
        // Sync many-to-many relation


        return redirect()->route('admin.appointments.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apponitments  $apponitments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apponitments $apponitments)
    {
        //
    }


    // public function sendDemoEmail(Request $request, $leadId)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'demo_date' => 'required|date',
    //         'demo_time' => 'required',
    //     ]);

    //     // Find the lead
    //     $lead = Leads::findOrFail($leadId);
    //     if (!$lead) {
    //         return back()->with('error', 'Lead not found.');
    //     }

    //     // Update the lead with the selected date and time
    //     $lead->update([
    //         'demo_date' => $request->input('demo_date'),
    //         'demo_time' => $request->input('demo_time'),
    //         'demo_mail_status' => 1, // Mark email as sent
    //         'opened_at' => now(), // Save current server timestamp
    //         'last_updated_by' => auth()->id(), // ✅ Add this line
    //     ]);

    //     // Get products (if needed)
    //     $products = Products::all();

    //     // Send email with date and time
    //     Mail::to($lead->email)->send(new DemoMail($lead, $products));

    //     return back()->with('success', 'Demo email sent successfully.');
    // }

    public function sendDemoEmail(Request $request, $leadId)
        {
            // Validate inputs
            $request->validate([
                'demo_date' => 'required|date',
                'demo_time' => 'required',
                'action' => 'required|in:save,send',
            ]);

            // Find the lead
            $lead = Leads::findOrFail($leadId);

            // Update lead details
            $lead->update([
                'demo_date' => $request->input('demo_date'),
                'demo_time' => $request->input('demo_time'),
                'last_updated_by' => auth()->id(),
                'opened_at' => now(),
                'demo_mail_status' => $request->action === 'send' ? 1 : 0,
            ]);

            // If the action is 'send', then send the email
            if ($request->action === 'send') {
                $products = Products::all();
                Mail::to($lead->email)->send(new DemoMail($lead, $products));

                return back()->with('success', 'Demo email sent successfully.');
            }

            return back()->with('success', 'Demo date and time saved successfully.');
        }


    public function exportinappointments(Request $request)
{
    $user = auth()->user();

    if ($user->id == 1) {
        $leads = Leads::with('products', 'user', 'assign')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->get();
    } elseif ($user->id == 2) {
        // $leads = Leads::with('products', 'user', 'assign')
        //     ->where('assigned_name', $user->id)
        //     ->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->get();
         $leads = Leads::with('products', 'user', 'assign')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->get();
    } else {
        $leads = Leads::with('products', 'user', 'assign')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_name', $user->id);
            })
            ->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->get();
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
            'demo_date' => $lead->demo_date,
            'demo_time' => $lead->demo_time,
            // 'follow_date' => $lead->follow_date,
            // 'follow_time' => $lead->follow_time,
            'created_at' => optional($lead->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => optional($lead->updated_at)->format('Y-m-d H:i:s'),
        ];
    });

    return Excel::download(new AppointmentsExport($data), 'appointments_' . now()->format('Ymd_His') . '.xlsx');
}
}