<?php

namespace App\Http\Controllers\Admin;

use App\Models\Qualified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Exports\QualifiedExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;

class QualifiedController extends Controller
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
            $leads = Leads::with('products', 'user','assign')->where('status', 'Qualified')
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } elseif (auth()->id() == 2) {
              // Admin sees leads assigned to them
                // $leads = Leads::with('products', 'user','assign')
                // ->where('assigned_name', $user->id)
                // ->where('status', 'Qualified')
                // ->orderBy('is_pinned', 'DESC') // Pinned first
                // ->orderBy('created_at', 'DESC')
                // ->get();
                 $leads = Leads::with('products', 'user','assign')->where('status', 'Qualified')
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } else {
              // Regular users see only leads they created
                $leads = Leads::with('products', 'user','assign')
                ->where('user_id', $user->id)
                ->where('status', 'Qualified')
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();

        }

        $products = Products::all();
        $selectedProducts = [];

        $assignedName = User::select('id', 'name')->distinct()->get();

        return view('admin.qualified.index', compact('leads', 'products', 'selectedProducts','assignedName'))
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
     * @param  \App\Models\Qualified  $qualified
     * @return \Illuminate\Http\Response
     */
    public function show(Qualified $qualified)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qualified  $qualified
     * @return \Illuminate\Http\Response
     */
    public function edit(Qualified $qualified)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qualified  $qualified
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Leads $lead )
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required|string',
            'source' => 'nullable|string',
            'assigned_name' => 'nullable|exists:users,id', // Ensure assigned_name exists
            'product_ids' => 'required|array', // Ensure product_ids is an array
            'product_ids.*' => 'exists:products,id', // Ensure each product_id exists in the products table
            'remarks' => 'nullable|string',
        ]);

       // Ensure the assigned_name is updated properly

    $validatedData['user_id'] = $request->assigned_name;

      // ✅ Set last updated user
      $validatedData['last_updated_by'] = auth()->id();
        // Update the lead with validated data
        $lead->update($validatedData);



        // Sync the products (many-to-many relationship)
        $lead->products()->sync($request->input('product_ids', []));
        // Sync many-to-many relation


        return redirect()->route('admin.qualified.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qualified  $qualified
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualified $qualified)
    {
        //
    }

    // export
public function exportinQualified(Request $request)
{
    $user = auth()->user();

    if ($user->id == 1) {
        $leads = Leads::with('products', 'user', 'assign')->where('status', 'Qualified')->get();
    } elseif ($user->id == 2) {
        // $leads = Leads::with('products', 'user', 'assign')
        //     ->where('assigned_name', $user->id)
        //     ->where('status', 'Qualified')->get();
        $leads = Leads::with('products', 'user', 'assign')->where('status', 'Qualified')->get();
    } else {
        $leads = Leads::with('products', 'user', 'assign')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_name', $user->id);
            })
            ->where('status', 'Qualified')->get();
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

    return Excel::download(new QualifiedExport($data), 'Qualified_' . now()->format('Ymd_His') . '.xlsx');
}
}
