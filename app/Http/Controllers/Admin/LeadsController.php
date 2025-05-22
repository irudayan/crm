<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Exports\LeadsExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $user = auth()->user();
    $baseQuery = Leads::with('products', 'user','assign','assignedBy')
        ->where('status', 'New')
        ->orderBy('is_pinned', 'DESC') // Pinned first
        ->orderBy('created_at', 'DESC');

    if (auth()->id() == 1) {
        $leads = $baseQuery->get();
    } elseif (auth()->id() == 2) {
        $leads = $baseQuery->where('assigned_name', $user->id)->get();
    } else {
        $leads = $baseQuery->where('user_id', $user->id)->get();
    }


    $products = Products::all();
    $selectedProducts = [];
    $assignedName = User::select('id', 'name')->distinct()->get();

     // Load assigned
     // _by users
     $assignedByUsers = User::whereIn('id', Leads::select('assigned_by_id')->distinct()->pluck('assigned_by_id'))->get();


        return view('admin.leads.index', compact('leads','products','selectedProducts','assignedName','assignedByUsers'));
    }

    public function togglePin(Leads $lead)
    {
        abort_if(Gate::denies('lead_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lead->update(['is_pinned' => !$lead->is_pinned]);

        return back()->with('success', 'Lead pin status updated successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'superadmin')->get(); // Exclude superadmin
        $products = Products::all();


        return view('admin.leads.create', compact('products', 'assignedName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // // Validate the request

    $request->validate([
        'name' => 'required|string|max:255',
        'mobile' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:1000',
        'industry' => 'nullable|string|max:100',
        'status' => 'required|in:New,Qualified,Follow Up,Online Demo,Offline Demo,Onsite Visit,Quotation / Ready To Buy,Closed or Won,Dropped or Cancel',
        'source' => 'required|string|max:255',
       'assigned_name' => 'nullable|exists:users,id', // Ensure assigned_name exists in users table
       'follow_date' => 'nullable|date',
       'follow_time' => 'nullable',
        'purpose' => 'nullable|string',
        'remarks' => 'nullable|string',
        'assigned_to_remarks' => 'nullable|string',
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id',
    ]);


     // if ($validator->fails()) {
     //        return response()->json([
     //            'success' => false,
     //            'message' => 'Validation errors',
     //            'errors' => $validator->errors()
     //        ], 422);
     //    }


     // Check for duplicates
    $existingLeads = Leads::where('name', $request->name)
        ->where('mobile', $request->mobile)
        ->where(function ($query) use ($request) {
            $query->whereNull('email')->orWhere('email', $request->email);
        })
        ->get();

    foreach ($existingLeads as $existingLead) {
        $existingProductIds = $existingLead->products()->pluck('products.id')->sort()->values()->toArray();
        $newProductIds = collect($request->product_ids)->sort()->values()->toArray();

        if ($existingProductIds == $newProductIds) {
            return redirect()->back()->withInput()->withErrors([
                'duplicate' => 'A lead with the same name, mobile, email, and products already exists.'
            ]);
        }
    }

    // Create the lead
    $lead = Leads::create([
        // 'user_id' => auth()->id(),
        'assigned_by_id' => auth()->id(),
        'user_id' => $request->assigned_name,
        'name' => $request->name,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'address' => $request->address,
        'industry' => $request->industry,
        'status' => $request->status,
        'source' => $request->source,
        'assigned_name' => $request->assigned_name, // Save assigned_name
        'product_ids'  => $request->product_ids,
        'follow_date' => $request->follow_date,
        'follow_time' => $request->follow_time,
        'purpose' => $request->purpose,
        'remarks' => $request->remarks,
        'assigned_to_remarks' => $request->assigned_to_remarks,
        'last_updated_by' => auth()->id(), 

    ]);




    // Attach products to the lead
    $lead->products()->sync($request->input('product_ids', []));

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leads $lead)
    {
        $products = $lead->products()->select('name', 'pivot.price')->get();
        // dd('in');
        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leads $lead)
    {
        $products = Products::all();
        $selectedProducts = $lead->products->pluck('id')->toArray();
        $assignedName = User::select('id', 'name')->distinct()->get();

    return view('admin.leads.edit', compact('lead', 'products', 'selectedProducts', 'assignedName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leads $lead )
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
            'assigned_to_remarks' => 'nullable|string',
            'purpose' => 'nullable|string',
            // 'opened_at' => 'nullable|date|after:now', // Optional: only allow future dates
        ]);


        // 🔍 Duplicate check (excluding current lead ID)
    $duplicateLeads = Leads::where('name', $request->name)
        ->where('mobile', $request->mobile)
        ->when($request->email, function ($query) use ($request) {
            return $query->where('email', $request->email);
        }, function ($query) {
            return $query->whereNull('email');
        })
        ->where('id', '!=', $lead->id) // ⛔ exclude the current lead
        ->get();

    foreach ($duplicateLeads as $existingLead) {
        $existingProductIds = $existingLead->products()->pluck('products.id')->sort()->values()->toArray();
        $newProductIds = collect($request->product_ids)->sort()->values()->toArray();

        if ($existingProductIds === $newProductIds) {
            return redirect()->back()->withInput()->withErrors([
                'duplicate' => 'A lead with the same name, mobile, email, and products already exists.'
            ]);
        }
    }


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


        // return redirect()->route('admin.leads.index')->with('success', 'Lead updated successfully.');
         return back()->with('success', 'Lead updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leads $lead)
    {
        $lead->forceDelete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted successfully.');
    }


public function getLeadProducts($id)
{
    $lead = Leads::with('products')->findOrFail($id);

    return response()->json([
        'success' => true,
        'products' => $lead->products->pluck('id') // Get only product IDs
    ]);
}

// export
public function exportIntoExcel(Request $request)
{
    $user = auth()->user();

    if ($user->id == 1) {
        $leads = Leads::with('products', 'user', 'assign')->get();
    } elseif ($user->id == 2) {
        $leads = Leads::with('products', 'user', 'assign')
            ->where('assigned_name', $user->id)
            ->get();
    } else {
        $leads = Leads::with('products', 'user', 'assign')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_name', $user->id);
            })
            ->get();
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
            'follow_date' => $lead->follow_date,
            'follow_time' => $lead->follow_time,
            'created_at' => optional($lead->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => optional($lead->updated_at)->format('Y-m-d H:i:s'),
        ];
    });

    return Excel::download(new LeadsExport($data), 'leads_' . now()->format('Ymd_His') . '.xlsx');
}
}