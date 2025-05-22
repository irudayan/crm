<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;
use App\Models\Leads;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {

    // $user = auth()->user();
    // $assignedName = User::select('id', 'name')->get();
    // $leads = Leads::with('products', 'user','assign')->get();
    // $products = Products::all();
    // $selectedProducts = [];
    // $assignedName = User::select('id', 'name')->distinct()->get();

    //     return view('admin.reports.index', compact('leads','products','selectedProducts','assignedName'));
    // }
    public function index(Request $request)
{
    $query = Leads::with(['products', 'user', 'assign']);

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('assigned_by')) {
        $query->where('assigned_by_id', $request->assigned_by);
    }

    if ($request->filled('assigned_user')) {
        $query->where('assigned_name', $request->assigned_user);
    }

    if ($request->filled('product')) {
        $query->whereHas('products', function ($q) use ($request) {
            $q->where('products.id', $request->product);
        });
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            Carbon\Carbon::parse($request->start_date)->startOfDay(),
            Carbon\Carbon::parse($request->end_date)->endOfDay()
        ]);
    }

    $leads = $query->get();

    $products = Products::all();
    $assignedName = User::select('id', 'name')->distinct()->get();
     // Load assigned_by users
     $assignedByUsers = User::whereIn('id', Leads::select('assigned_by_id')->distinct()->pluck('assigned_by_id'))->get();

    return view('admin.reports.index', compact('leads', 'products', 'assignedName','assignedByUsers'));
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
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }

    public function exportinreports(Request $request)
    {
        $filters = [
            'status' => $request->get('status'),
            'assigned_by' => $request->get('assigned_by'),
            'assigned_user' => $request->get('assigned_user'),
            'product' => $request->get('product'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
        ];

        return Excel::download(new ReportsExport($filters), 'leads_' . now()->format('Ymd_His') . '.xlsx');
    }
}
