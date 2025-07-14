<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
            $user = auth()->user();
            $assignedName = User::select('id', 'name')->distinct()->get();
            $today = Carbon::today();

            $today = Carbon::today(); // today 00:00:00
            $endOfDay = Carbon::today()->endOfDay(); // today 23:59:59

              $assignedLeadsCount = Leads::where('assigned_by_id', $user->id)->count();

               //      // Default null values
            $userCount = null;
            $userLeadsCount = [];

            // if (auth()->id() == 1) {
            if (in_array(auth()->id(), [1, 2])) {
                $userCount = User::count();


$userLeadsCount = DB::table('users')
    ->leftJoin('leads', 'users.id', '=', 'leads.assigned_by_id')
    ->select(
        'users.id',
        'users.name',
        DB::raw('COUNT(leads.id) as total_leads'),
        DB::raw('SUM(CASE WHEN DATE(leads.created_at) = "' . Carbon::today()->format('Y-m-d') . '" THEN 1 ELSE 0 END) as today_leads'),
        DB::raw('SUM(CASE WHEN leads.status = "Qualified" THEN 1 ELSE 0 END) as qualified'),
        DB::raw('SUM(CASE WHEN leads.status = "Follow Up" THEN 1 ELSE 0 END) as follow_up'),
        DB::raw('SUM(CASE WHEN leads.status = "appointments" THEN 1 ELSE 0 END) as appointments'),
        DB::raw('SUM(CASE WHEN leads.status = "quotation" THEN 1 ELSE 0 END) as quotation'),
        DB::raw('SUM(CASE WHEN leads.status = "Closed or Won" THEN 1 ELSE 0 END) as closed_or_won'),
        DB::raw('SUM(CASE WHEN leads.status = "Dropped or Cancel" THEN 1 ELSE 0 END) as dropped_or_cancel')
    )
    ->groupBy('users.id', 'users.name')
    ->get();


    $totals = [
    'total_leads' => $userLeadsCount->sum('total_leads'),
    'today_leads' => $userLeadsCount->sum('today_leads'),
    'qualified' => $userLeadsCount->sum('qualified'),
    'follow_up' => $userLeadsCount->sum('follow_up'),
    'appointments' => $userLeadsCount->sum('appointments'),
    'quotation' => $userLeadsCount->sum('quotation'),
    'closed_or_won' => $userLeadsCount->sum('closed_or_won'),
    'dropped_or_cancel' => $userLeadsCount->sum('dropped_or_cancel'),
];


         $dateFilter = $request->input('date_filter');
    $startDate = null;
    $endDate = Carbon::now()->endOfDay();

    // Handle dropdown filter
    switch ($dateFilter) {
        case 'today':
            $startDate = Carbon::today();
            break;
        case 'yesterday':
            $startDate = Carbon::yesterday()->startOfDay();
            $endDate = Carbon::yesterday()->endOfDay();
            break;
        case 'last_3_days':
            $startDate = Carbon::now()->subDays(2)->startOfDay();
            break;
        case 'last_7_days':
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            break;
        case 'last_15_days':
            $startDate = Carbon::now()->subDays(14)->startOfDay();
            break;
        case 'last_30_days':
            $startDate = Carbon::now()->subDays(29)->startOfDay();
            break;
        case 'this_week':
            $startDate = Carbon::now()->startOfWeek();
            break;
        case 'last_week':
            $startDate = Carbon::now()->subWeek()->startOfWeek();
            $endDate = Carbon::now()->subWeek()->endOfWeek();
            break;
        case 'this_month':
            $startDate = Carbon::now()->startOfMonth();
            break;
        case 'last_month':
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            $endDate = Carbon::now()->subMonth()->endOfMonth();
            break;
        case 'last_month_onwards':
            $startDate = Carbon::now()->subMonth()->startOfMonth();
            break;
        default:
            $startDate = Carbon::today();
            break;
    }

    // Handle custom date range input
    if ($request->filled('from_date') && $request->filled('to_date')) {
        $startDate = Carbon::parse($request->from_date)->startOfDay();
        $endDate = Carbon::parse($request->to_date)->endOfDay();
    }

    // Filter leads by date range
    $leadsQuery = Leads::with('products', 'user')->whereBetween('created_at', [$startDate, $endDate]);
    $leads = $leadsQuery->get();

    // Stats
    $totalLeads = $leads->count();
    $newLeads = $leads->where('status', 'New')->count();
    $qualifiedLeads = $leads->where('status', 'Qualified')->count();
    $flowupLeads = $leads->where('status', 'Follow Up')->count();
    $demoLeads = $leads->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
    $quotationLeads = $leads->where('status', 'Quotation / Ready To Buy')->count();
    $closedorwonLeads = $leads->where('status', 'Closed or Won')->count();
    $cancelLeads = $leads->where('status', 'Dropped or Cancel')->count();

        if (auth()->id() == 1) {
            // $leads = Leads::with('products', 'user')->latest()->take(7)->get();
            $leads = Leads::with('products', 'user')
            ->whereDate('created_at', Carbon::today())
            ->get();

            // followup
            $followupLeads = Leads::with('products', 'user')
            ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
            ->get();
            // dd($followupLeads);
            $totalLeads = Leads::with('products', 'user')->count();
            $newLeads = Leads::with('products', 'user')->where('status', 'New')->count();
            $qualifiedLeads = Leads::with('products', 'user')->where('status', 'Qualified')->count();
            $flowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->count();
            $demoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
            $quotationLeads = Leads::with('products', 'user')->where('status', 'Quotation / Ready To Buy')->count();
            $closedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->count();
            $cancelLeads = Leads::with('products', 'user')->where('status', 'Dropped or Cancel')->count(); // Fixed Typo


            $openedLeadsNull = Leads::with('products', 'user')->whereNull('opened_at')->count();
            // dd($openedLeadsNull);
            $openedLeadsNotNull = Leads::with('products', 'user')->whereNotNull('opened_at')->count();


            $todayLeads = Leads::whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::with('products', 'user')->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayFlowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();


        } elseif (auth()->id() == 2) {

             $leads = Leads::with('products', 'user')
            ->whereDate('created_at', Carbon::today())
            ->get();

            // followup
            $followupLeads = Leads::with('products', 'user')
            ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
            ->get();
            // dd($followupLeads);
            $totalLeads = Leads::with('products', 'user')->count();
            $newLeads = Leads::with('products', 'user')->where('status', 'New')->count();
            $qualifiedLeads = Leads::with('products', 'user')->where('status', 'Qualified')->count();
            $flowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->count();
            $demoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
            $quotationLeads = Leads::with('products', 'user')->where('status', 'Quotation / Ready To Buy')->count();
            $closedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->count();
            $cancelLeads = Leads::with('products', 'user')->where('status', 'Dropped or Cancel')->count(); // Fixed Typo

            $openedLeadsNull = Leads::with('products', 'user')->whereNull('opened_at')->count();
            // dd($openedLeadsNull);
            $openedLeadsNotNull = Leads::with('products', 'user')->whereNotNull('opened_at')->count();


            $todayLeads = Leads::whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::with('products', 'user')->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayFlowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();

        } else {
dd(auth()->id());
            // followup
            $followupLeads = Leads::with('products', 'user','assign')
            ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
            ->where('user_id', $user->id)
            ->get();
            // dd($followupLeads);

            $totalLeads = Leads::with('products', 'user')->where('user_id', $user->id)->count();
            // $todayLeads = Leads::where('user_id', $user->id)->whereDate('created_at', $today)->count();
            $todayLeads = Leads::where('user_id', $user->id)
            ->where('assigned_name', $user->name)
            ->whereDate('created_at', $today)
            ->count();
            // dd($todayLeads);
            $newLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'New')->count();
            $demoLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
            $quotationLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Quotation / Ready To Buy')->count();

            $qualifiedLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Qualified')->count();
            $flowupLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Follow Up')->count();
            $closedorwonLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Closed or Won')->count();
            $cancelLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Dropped or Cancel')->count(); // Fixed

            $openedLeadsNull = Leads::with('products', 'user')->where('user_id', $user->id)->whereNull('opened_at')->count();
            // dd($openedLeadsNull);
            $openedLeadsNotNull = Leads::with('products', 'user')->where('user_id', $user->id)->whereNotNull('opened_at')->count();


            $todayFlowupLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayNewLeads =  Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();



            // Regular users: Get only leads they created
            $leads = Leads::with('products', 'user')
            ->where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->get();

        }



         // Count leads based on status
            // Fetch all products
            $products = Products::all();

            // Get authenticated user and their role
            $user = auth()->user();
            $role = $user->role; // Assuming the role is stored in the users table

            $userLeads = $userLeadsCount;

            // Calculate totals for each user (like in filterDashboard)


    return view('admin.home', compact(
        'totalLeads','followupLeads','todayLeads', 'newLeads','qualifiedLeads','flowupLeads', 'demoLeads', 'quotationLeads','closedorwonLeads', 'cancelLeads', 'leads', 'products','assignedLeadsCount','userCount','userLeadsCount','todayFlowupLeads','todayDemoLeads','todayClosedorwonLeads','openedLeadsNull','openedLeadsNotNull','todayNewLeads','assignedName','role','today','userLeads','totals'));

    }
}

    public function filterDashboard(Request $request)
{
    $filter = $request->filter;
    $startDate = $request->start;
    $endDate = $request->end;

    // Apply your filtering logic here
    $userLeads = DB::table('leads') // your query here
        ->select(DB::raw('...'))
        ->get();

    $totals = [/* calculate totals */];

    $html = view('admin.partials.lead_stats_table', compact('userLeads', 'totals'))->render();

    return response()->json(['html' => $html]);
}

}