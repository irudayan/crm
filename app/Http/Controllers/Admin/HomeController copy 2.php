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
        $endOfDay = Carbon::today()->endOfDay();

        $assignedLeadsCount = Leads::where('assigned_by_id', $user->id)->count();
        $userCount = null;
        $userLeadsCount = [];

        if (in_array(auth()->id(), [1, 2])) {
            $userCount = User::count();

            $userLeadsCount = DB::table('users')
                ->leftJoin('leads', 'users.id', '=', 'leads.assigned_by_id')
                ->select(
                    'users.id',
                    'users.name',
                    DB::raw('COUNT(leads.id) as total_leads'),
                    DB::raw('SUM(CASE WHEN DATE(leads.created_at) = "' . Carbon::today()->format('Y-m-d') . '" THEN 1 ELSE 0 END) as today_leads'),
                    DB::raw('SUM(CASE WHEN leads.status = "New" THEN 1 ELSE 0 END) as new'),
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
                'new' => $userLeadsCount->sum('new'),
                'qualified' => $userLeadsCount->sum('qualified'),
                'follow_up' => $userLeadsCount->sum('follow_up'),
                'appointments' => $userLeadsCount->sum('appointments'),
                'quotation' => $userLeadsCount->sum('quotation'),
                'closed_or_won' => $userLeadsCount->sum('closed_or_won'),
                'dropped_or_cancel' => $userLeadsCount->sum('dropped_or_cancel'),
            ];
        } else {
            $totals = null;
        }

        // Date filter logic
        $dateFilter = $request->input('date_filter');
        $startDate = null;
        $endDate = Carbon::now()->endOfDay();

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

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $endDate = Carbon::parse($request->to_date)->endOfDay();
        }

        $leadsQuery = Leads::with('products', 'user')->whereBetween('created_at', [$startDate, $endDate]);
        $leads = $leadsQuery->get();

        $totalLeads = $leads->count();
        $newLeads = $leads->where('status', 'New')->count();
        $qualifiedLeads = $leads->where('status', 'Qualified')->count();
        $flowupLeads = $leads->where('status', 'Follow Up')->count();
        $demoLeads = $leads->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
        $quotationLeads = $leads->where('status', 'Quotation / Ready To Buy')->count();
        $closedorwonLeads = $leads->where('status', 'Closed or Won')->count();
        $cancelLeads = $leads->where('status', 'Dropped or Cancel')->count();

        // Role based logic
        if (auth()->id() == 1 || auth()->id() == 2) {
            $leads = Leads::with('products', 'user')
                ->whereDate('created_at', $today)
                ->get();

            $followupLeads = Leads::with('products', 'user')
                ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
                ->get();

            $openedLeadsNull = Leads::with('products', 'user')->whereNull('opened_at')->count();
            $openedLeadsNotNull = Leads::with('products', 'user')->whereNotNull('opened_at')->count();

            $todayLeads = Leads::whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::where('status', 'New')->whereDate('created_at', $today)->count();
            $todayFlowupLeads = Leads::where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::where('status', 'Closed or Won')->whereDate('created_at', $today)->count();
        } else {
            $followupLeads = Leads::with('products', 'user', 'assign')
                ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
                ->where('user_id', $user->id)
                ->get();

            $totalLeads = Leads::where('user_id', $user->id)->count();
            $todayLeads = Leads::where('user_id', $user->id)->where('assigned_name', $user->name)->whereDate('created_at', $today)->count();
            $newLeads = Leads::where('user_id', $user->id)->where('status', 'New')->count();
            $qualifiedLeads = Leads::where('user_id', $user->id)->where('status', 'Qualified')->count();
            $flowupLeads = Leads::where('user_id', $user->id)->where('status', 'Follow Up')->count();
            $demoLeads = Leads::where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
            $quotationLeads = Leads::where('user_id', $user->id)->where('status', 'Quotation / Ready To Buy')->count();
            $closedorwonLeads = Leads::where('user_id', $user->id)->where('status', 'Closed or Won')->count();
            $cancelLeads = Leads::where('user_id', $user->id)->where('status', 'Dropped or Cancel')->count();

            $openedLeadsNull = Leads::where('user_id', $user->id)->whereNull('opened_at')->count();
            $openedLeadsNotNull = Leads::where('user_id', $user->id)->whereNotNull('opened_at')->count();

            $todayFlowupLeads = Leads::where('user_id', $user->id)->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::where('user_id', $user->id)->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::where('user_id', $user->id)->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();

            $leads = Leads::where('user_id', $user->id)->whereDate('created_at', $today)->get();
        }

        $products = Products::all();
        $role = $user->role ?? null;
        $userLeads = $userLeadsCount;

        return view('admin.home', compact(
            'totalLeads', 'followupLeads', 'todayLeads', 'newLeads', 'qualifiedLeads',
            'flowupLeads', 'demoLeads', 'quotationLeads', 'closedorwonLeads', 'cancelLeads',
            'leads', 'products', 'assignedLeadsCount', 'userCount', 'userLeadsCount',
            'todayFlowupLeads', 'todayDemoLeads', 'todayClosedorwonLeads',
            'openedLeadsNull', 'openedLeadsNotNull', 'todayNewLeads',
            'assignedName', 'role', 'today', 'userLeads', 'totals'
        ));
    }



    // public function filter(Request $request)
    // {
    //     $filter = $request->filter;
    //     $start = $request->start;
    //     $end = $request->end;

    //     $query = Leads::query();

    //     if ($filter !== 'total') {
    //         if ($filter === 'custom' && $start && $end) {
    //             $query->whereBetween('created_at', [
    //                 Carbon::parse($start)->startOfDay(),
    //                 Carbon::parse($end)->endOfDay()
    //             ]);
    //         } else {
    //             switch ($filter) {
    //                 case 'today':
    //                     $query->whereDate('created_at', Carbon::today());
    //                     break;
    //                 case 'yesterday':
    //                     $query->whereDate('created_at', Carbon::yesterday());
    //                     break;
    //                 case 'last_3_days':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subDays(2)->startOfDay(),
    //                         Carbon::now()->endOfDay()
    //                     ]);
    //                     break;
    //                 case 'last_7_days':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subDays(6)->startOfDay(),
    //                         Carbon::now()->endOfDay()
    //                     ]);
    //                     break;
    //                 case 'last_15_days':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subDays(14)->startOfDay(),
    //                         Carbon::now()->endOfDay()
    //                     ]);
    //                     break;
    //                 case 'last_30_days':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subDays(29)->startOfDay(),
    //                         Carbon::now()->endOfDay()
    //                     ]);
    //                     break;
    //                 case 'this_week':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->startOfWeek(),
    //                         Carbon::now()->endOfWeek()
    //                     ]);
    //                     break;
    //                 case 'last_week':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subWeek()->startOfWeek(),
    //                         Carbon::now()->subWeek()->endOfWeek()
    //                     ]);
    //                     break;
    //                 case 'this_month':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->startOfMonth(),
    //                         Carbon::now()->endOfMonth()
    //                     ]);
    //                     break;
    //                 case 'last_month':
    //                     $query->whereBetween('created_at', [
    //                         Carbon::now()->subMonth()->startOfMonth(),
    //                         Carbon::now()->subMonth()->endOfMonth()
    //                     ]);
    //                     break;
    //                 case 'from_last_month':
    //                     $query->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth());
    //                     break;
    //             }
    //         }
    //     }

    //     $userLeads = $query
    //         ->join('users', 'users.id', '=', 'leads.assigned_by_id')
    //         ->selectRaw('users.name,
    //             COUNT(leads.id) as total,
    //             SUM(CASE WHEN leads.status = "New" THEN 1 ELSE 0 END) as new,
    //             SUM(CASE WHEN leads.status = "Qualified" THEN 1 ELSE 0 END) as qualified,
    //             SUM(CASE WHEN leads.status = "Follow Up" THEN 1 ELSE 0 END) as follow_up,
    //             SUM(CASE WHEN leads.status = "appointments" THEN 1 ELSE 0 END) as appointments,
    //             SUM(CASE WHEN leads.status = "quotation" THEN 1 ELSE 0 END) as quotation,
    //             SUM(CASE WHEN leads.status = "Closed or Won" THEN 1 ELSE 0 END) as won,
    //             SUM(CASE WHEN leads.status = "Dropped or Cancel" THEN 1 ELSE 0 END) as cancel
    //         ')
    //         ->groupBy('users.name')
    //         ->get();

    //     $totals = [
    //         'total' => $userLeads->sum('total'),
    //         'new' => $userLeads->sum('new'),
    //         'qualified' => $userLeads->sum('qualified'),
    //         'follow_up' => $userLeads->sum('follow_up'),
    //         'appointments' => $userLeads->sum('appointments'),
    //         'quotation' => $userLeads->sum('quotation'),
    //         'won' => $userLeads->sum('won'),
    //         'cancel' => $userLeads->sum('cancel'),
    //     ];

    //     $html = view('admin.partials.lead_stats_table', compact('userLeads', 'totals'))->render();

    //     return response()->json(['html' => $html]);
    // }


// public function filter(Request $request)
//     {
//         $filter = $request->input('filter', 'today');
//         $startDate = $request->input('start');
//         $endDate = $request->input('end');

//         $query = Leads::query()->with('user');

//         // Apply date filters
//         if ($filter !== 'total') {
//             if ($filter === 'custom') {
//                 if (!$startDate || !$endDate) {
//                     return response()->json(['error' => 'Both start and end dates are required for custom range'], 400);
//                 }

//                 $start = Carbon::parse($startDate)->startOfDay();
//                 $end = Carbon::parse($endDate)->endOfDay();
//                 $query->whereBetween('created_at', [$start, $end]);
//             } else {
//                 $query->where(function($q) use ($filter) {
//                     switch ($filter) {
//                         case 'today':
//                             $q->whereDate('created_at', Carbon::today());
//                             break;
//                         case 'yesterday':
//                             $q->whereDate('created_at', Carbon::yesterday());
//                             break;
//                         case 'last_3_days':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subDays(2)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_7_days':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subDays(6)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_15_days':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subDays(14)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_30_days':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subDays(29)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'this_week':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->startOfWeek(),
//                                 Carbon::now()->endOfWeek()
//                             ]);
//                             break;
//                         case 'last_week':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subWeek()->startOfWeek(),
//                                 Carbon::now()->subWeek()->endOfWeek()
//                             ]);
//                             break;
//                         case 'this_month':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->startOfMonth(),
//                                 Carbon::now()->endOfMonth()
//                             ]);
//                             break;
//                         case 'last_month':
//                             $q->whereBetween('created_at', [
//                                 Carbon::now()->subMonth()->startOfMonth(),
//                                 Carbon::now()->subMonth()->endOfMonth()
//                             ]);
//                             break;
//                         case 'from_last_month':
//                             $q->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth());
//                             break;
//                         default:
//                             $q->whereDate('created_at', Carbon::today());
//                     }
//                 });
//             }
//         }

//         // Get lead statistics grouped by user
//         $userLeads = $query
//             ->select([
//                 'assigned_by_id',
//                 DB::raw('COUNT(*) as total'),
//                 DB::raw('SUM(CASE WHEN status = "New" THEN 1 ELSE 0 END) as new'),
//                 DB::raw('SUM(CASE WHEN status = "Qualified" THEN 1 ELSE 0 END) as qualified'),
//                 DB::raw('SUM(CASE WHEN status = "Follow Up" THEN 1 ELSE 0 END) as follow_up'),
//                 DB::raw('SUM(CASE WHEN status IN ("Online Demo", "Offline Demo", "Onsite Visit") THEN 1 ELSE 0 END) as appointments'),
//                 DB::raw('SUM(CASE WHEN status = "Quotation / Ready To Buy" THEN 1 ELSE 0 END) as quotation'),
//                 DB::raw('SUM(CASE WHEN status = "Closed or Won" THEN 1 ELSE 0 END) as won'),
//                 DB::raw('SUM(CASE WHEN status = "Dropped or Cancel" THEN 1 ELSE 0 END) as cancel')
//             ])
//             ->groupBy('assigned_by_id')
//             ->get();

//         // Get user names for the leads
//         $userIds = $userLeads->pluck('assigned_by_id')->unique();
//         $users = User::whereIn('id', $userIds)->pluck('name', 'id');

//         // Format the data with user names
//         $formattedLeads = $userLeads->map(function($item) use ($users) {
//             return [
//                 'name' => $users[$item->assigned_by_id] ?? 'Unknown',
//                 'total' => $item->total,
//                 'new' => $item->new,
//                 'qualified' => $item->qualified,
//                 'follow_up' => $item->follow_up,
//                 'appointments' => $item->appointments,
//                 'quotation' => $item->quotation,
//                 'won' => $item->won,
//                 'cancel' => $item->cancel
//             ];
//         });

//         // Calculate totals
//         $totals = [
//             'total' => $formattedLeads->sum('total'),
//             'new' => $formattedLeads->sum('new'),
//             'qualified' => $formattedLeads->sum('qualified'),
//             'follow_up' => $formattedLeads->sum('follow_up'),
//             'appointments' => $formattedLeads->sum('appointments'),
//             'quotation' => $formattedLeads->sum('quotation'),
//             'won' => $formattedLeads->sum('won'),
//             'cancel' => $formattedLeads->sum('cancel'),
//         ];

//         // Return JSON response with HTML
//         $html = view('admin.home', [
//             'userLeads' => $formattedLeads,
//             'totals' => $totals
//         ])->render();

//         return response()->json(['html' => $html]);
//     }

//  public function filter(Request $request)
//     {
//         try {
//             $filter = $request->input('filter', 'today');
//             $startDate = $request->input('start');
//             $endDate = $request->input('end');

//             $query = Leads::query()->with('user');

//             // Apply date filters
//             if ($filter !== 'total') {
//                 if ($filter === 'custom') {
//                     if (!$startDate || !$endDate) {
//                         return response()->json([
//                             'error' => 'Both start and end dates are required for custom range'
//                         ], 400);
//                     }

//                     $start = Carbon::parse($startDate)->startOfDay();
//                     $end = Carbon::parse($endDate)->endOfDay();
//                     $query->whereBetween('created_at', [$start, $end]);
//                 } else {
//                     switch ($filter) {
//                         case 'today':
//                             $query->whereDate('created_at', Carbon::today());
//                             break;
//                         case 'yesterday':
//                             $query->whereDate('created_at', Carbon::yesterday());
//                             break;
//                         case 'last_3_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(2)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_7_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(6)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_15_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(14)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_30_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(29)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'this_week':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->startOfWeek(),
//                                 Carbon::now()->endOfWeek()
//                             ]);
//                             break;
//                         case 'last_week':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subWeek()->startOfWeek(),
//                                 Carbon::now()->subWeek()->endOfWeek()
//                             ]);
//                             break;
//                         case 'this_month':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->startOfMonth(),
//                                 Carbon::now()->endOfMonth()
//                             ]);
//                             break;
//                         case 'last_month':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subMonth()->startOfMonth(),
//                                 Carbon::now()->subMonth()->endOfMonth()
//                             ]);
//                             break;
//                         case 'from_last_month':
//                             $query->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth());
//                             break;
//                         default:
//                             $query->whereDate('created_at', Carbon::today());
//                     }
//                 }
//             }

//             // Get lead statistics grouped by user
//             $userLeads = $query
//                 ->select([
//                     'assigned_by_id',
//                     DB::raw('COUNT(*) as total'),
//                     DB::raw('SUM(CASE WHEN status = "New" THEN 1 ELSE 0 END) as new'),
//                     DB::raw('SUM(CASE WHEN status = "Qualified" THEN 1 ELSE 0 END) as qualified'),
//                     DB::raw('SUM(CASE WHEN status = "Follow Up" THEN 1 ELSE 0 END) as follow_up'),
//                     DB::raw('SUM(CASE WHEN status IN ("Online Demo", "Offline Demo", "Onsite Visit") THEN 1 ELSE 0 END) as appointments'),
//                     DB::raw('SUM(CASE WHEN status = "Quotation / Ready To Buy" THEN 1 ELSE 0 END) as quotation'),
//                     DB::raw('SUM(CASE WHEN status = "Closed or Won" THEN 1 ELSE 0 END) as won'),
//                     DB::raw('SUM(CASE WHEN status = "Dropped or Cancel" THEN 1 ELSE 0 END) as cancel')
//                 ])
//                 ->groupBy('assigned_by_id')
//                 ->get();

//             // Get user names for the leads
//             $userIds = $userLeads->pluck('assigned_by_id')->unique();
//             $users = User::whereIn('id', $userIds)->pluck('name', 'id');

//             // Format the data with user names
//             $formattedLeads = $userLeads->map(function($item) use ($users) {
//                 return [
//                     'name' => $users[$item->assigned_by_id] ?? 'Unknown',
//                     'total' => $item->total,
//                     'new' => $item->new,
//                     'qualified' => $item->qualified,
//                     'follow_up' => $item->follow_up,
//                     'appointments' => $item->appointments,
//                     'quotation' => $item->quotation,
//                     'won' => $item->won,
//                     'cancel' => $item->cancel
//                 ];
//             });

//             // Calculate totals
//             $totals = [
//                 'total' => $formattedLeads->sum('total'),
//                 'new' => $formattedLeads->sum('new'),
//                 'qualified' => $formattedLeads->sum('qualified'),
//                 'follow_up' => $formattedLeads->sum('follow_up'),
//                 'appointments' => $formattedLeads->sum('appointments'),
//                 'quotation' => $formattedLeads->sum('quotation'),
//                 'won' => $formattedLeads->sum('won'),
//                 'cancel' => $formattedLeads->sum('cancel'),
//             ];

//             return response()->json([
//                 'html' => view('admin.partials.lead_stats_table', [
//                     'userLeads' => $formattedLeads,
//                     'totals' => $totals
//                 ])->render()
//             ]);

//         } catch (\Exception $e) {
//             \Log::error('Filter error: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Server error: ' . $e->getMessage()
//             ], 500);
//         }
//     }


// public function filter(Request $request)
//     {
//         try {
//             $filter = $request->input('filter', 'today');
//             $startDate = $request->input('start');
//             $endDate = $request->input('end');

//             $query = Leads::query()->with('user');

//             // Apply date filters
//             if ($filter !== 'total') {
//                 if ($filter === 'custom') {
//                     if (!$startDate || !$endDate) {
//                         return response()->json([
//                             'error' => 'Both start and end dates are required for custom range'
//                         ], 400);
//                     }

//                     $start = Carbon::parse($startDate)->startOfDay();
//                     $end = Carbon::parse($endDate)->endOfDay();
//                     $query->whereBetween('created_at', [$start, $end]);
//                 } else {
//                     switch ($filter) {
//                         case 'today':
//                             $query->whereDate('created_at', Carbon::today());
//                             break;
//                         case 'yesterday':
//                             $query->whereDate('created_at', Carbon::yesterday());
//                             break;
//                         case 'last_3_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(2)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_7_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(6)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_15_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(14)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'last_30_days':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subDays(29)->startOfDay(),
//                                 Carbon::now()->endOfDay()
//                             ]);
//                             break;
//                         case 'this_week':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->startOfWeek(),
//                                 Carbon::now()->endOfWeek()
//                             ]);
//                             break;
//                         case 'last_week':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subWeek()->startOfWeek(),
//                                 Carbon::now()->subWeek()->endOfWeek()
//                             ]);
//                             break;
//                         case 'this_month':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->startOfMonth(),
//                                 Carbon::now()->endOfMonth()
//                             ]);
//                             break;
//                         case 'last_month':
//                             $query->whereBetween('created_at', [
//                                 Carbon::now()->subMonth()->startOfMonth(),
//                                 Carbon::now()->subMonth()->endOfMonth()
//                             ]);
//                             break;
//                         case 'from_last_month':
//                             $query->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth());
//                             break;
//                         default:
//                             $query->whereDate('created_at', Carbon::today());
//                     }
//                 }
//             }

//             // Get lead statistics grouped by user
//             $userLeads = $query
//                 ->select([
//                     'assigned_by_id',
//                     DB::raw('COUNT(*) as total'),
//                     DB::raw('SUM(CASE WHEN status = "New" THEN 1 ELSE 0 END) as new'),
//                     DB::raw('SUM(CASE WHEN status = "Qualified" THEN 1 ELSE 0 END) as qualified'),
//                     DB::raw('SUM(CASE WHEN status = "Follow Up" THEN 1 ELSE 0 END) as follow_up'),
//                     DB::raw('SUM(CASE WHEN status IN ("Online Demo", "Offline Demo", "Onsite Visit") THEN 1 ELSE 0 END) as appointments'),
//                     DB::raw('SUM(CASE WHEN status = "Quotation / Ready To Buy" THEN 1 ELSE 0 END) as quotation'),
//                     DB::raw('SUM(CASE WHEN status = "Closed or Won" THEN 1 ELSE 0 END) as won'),
//                     DB::raw('SUM(CASE WHEN status = "Dropped or Cancel" THEN 1 ELSE 0 END) as cancel')
//                 ])
//                 ->groupBy('assigned_by_id')
//                 ->get();

//             // Get user names for the leads
//             $userIds = $userLeads->pluck('assigned_by_id')->unique();
//             $users = User::whereIn('id', $userIds)->pluck('name', 'id');

//             // Format the data with user names
//             $formattedLeads = $userLeads->map(function($item) use ($users) {
//                 return [
//                     'name' => $users[$item->assigned_by_id] ?? 'Unknown',
//                     'total' => $item->total,
//                     'new' => $item->new,
//                     'qualified' => $item->qualified,
//                     'follow_up' => $item->follow_up,
//                     'appointments' => $item->appointments,
//                     'quotation' => $item->quotation,
//                     'won' => $item->won,
//                     'cancel' => $item->cancel
//                 ];
//             });

//             // Calculate totals
//             $totals = [
//                 'total' => $formattedLeads->sum('total'),
//                 'new' => $formattedLeads->sum('new'),
//                 'qualified' => $formattedLeads->sum('qualified'),
//                 'follow_up' => $formattedLeads->sum('follow_up'),
//                 'appointments' => $formattedLeads->sum('appointments'),
//                 'quotation' => $formattedLeads->sum('quotation'),
//                 'won' => $formattedLeads->sum('won'),
//                 'cancel' => $formattedLeads->sum('cancel'),
//             ];

//             return response()->json([
//                 'html' => view('admin.partials.lead_stats_table', [
//                     'userLeads' => $formattedLeads,
//                     'totals' => $totals
//                 ])->render()
//             ]);

//         } catch (\Exception $e) {
//             \Log::error('Filter error: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Server error: ' . $e->getMessage()
//             ], 500);
//         }
//     }

// public function filter(Request $request)
//     {
//         try {
//             $filter = $request->input('filter', 'today');
//             $startDate = $request->input('start');
//             $endDate = $request->input('end');
//             $nameFilter = $request->input('name');

//             $query = Leads::query()->with('user');

//             // Apply name filter if provided
//             if ($nameFilter && $nameFilter !== 'all') {
//                 $query->whereHas('user', function($q) use ($nameFilter) {
//                     $q->where('name', 'like', '%'.$nameFilter.'%');
//                 });
//             }

//             // Apply date filters
//             if ($filter !== 'total') {
//                 if ($filter === 'custom') {
//                     if (!$startDate || !$endDate) {
//                         return response()->json([
//                             'error' => 'Both start and end dates are required for custom range'
//                         ], 400);
//                     }

//                     $start = Carbon::parse($startDate)->startOfDay();
//                     $end = Carbon::parse($endDate)->endOfDay();
//                     $query->whereBetween('created_at', [$start, $end]);
//                 } else {
//                     switch ($filter) {
//                         case 'today':
//                             $query->whereDate('created_at', Carbon::today());
//                             break;
//                         // ... other date filter cases ...
//                     }
//                 }
//             }

//             // Get lead statistics grouped by user
//             $userLeads = $query
//                 ->select([
//                     'assigned_by_id',
//                     DB::raw('COUNT(*) as total'),
//                     DB::raw('SUM(CASE WHEN status = "New" THEN 1 ELSE 0 END) as new'),
//                     // ... other status counts ...
//                 ])
//                 ->groupBy('assigned_by_id')
//                 ->get();

//             // Get user names for the leads
//             $userIds = $userLeads->pluck('assigned_by_id')->unique();
//             $users = User::whereIn('id', $userIds)->pluck('name', 'id');

//             // Format the data with user names
//             $formattedLeads = $userLeads->map(function($item) use ($users) {
//                 return [
//                     'name' => $users[$item->assigned_by_id] ?? 'Unknown',
//                     'total' => $item->total,
//                     'new' => $item->new,
//                     // ... other fields ...
//                 ];
//             });

//             // Calculate totals
//             $totals = [
//                 'total' => $formattedLeads->sum('total'),
//                 'new' => $formattedLeads->sum('new'),
//                 // ... other totals ...
//             ];

//             return response()->json([
//                 'html' => view('admin.partials.lead_stats_table', [
//                     'userLeads' => $formattedLeads,
//                     'totals' => $totals
//                 ])->render()
//             ]);

//         } catch (\Exception $e) {
//             \Log::error('Filter error: ' . $e->getMessage());
//             return response()->json([
//                 'error' => 'Server error: ' . $e->getMessage()
//             ], 500);
//         }
//     }

 public function filter(Request $request)
    {
        try {
            $filter = $request->input('filter', 'today');
            $startDate = $request->input('start');
            $endDate = $request->input('end');
            $nameFilter = $request->input('name', 'all');

            $query = Leads::query()->with('user');

            // Apply name filter if not 'all'
            if ($nameFilter !== 'all') {
                $query->whereHas('user', function($q) use ($nameFilter) {
                    $q->where('name', $nameFilter);
                });
            }

            // Apply date filters
            if ($filter !== 'total') {
                if ($filter === 'custom') {
                    if (!$startDate || !$endDate) {
                        return response()->json([
                            'error' => 'Both start and end dates are required for custom range'
                        ], 400);
                    }

                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
                    $query->whereBetween('created_at', [$start, $end]);
                } else {
                    switch ($filter) {
                        case 'today':
                            $query->whereDate('created_at', Carbon::today());
                            break;
                        case 'yesterday':
                            $query->whereDate('created_at', Carbon::yesterday());
                            break;
                        case 'last_3_days':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subDays(2)->startOfDay(),
                                Carbon::now()->endOfDay()
                            ]);
                            break;
                        case 'last_7_days':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subDays(6)->startOfDay(),
                                Carbon::now()->endOfDay()
                            ]);
                            break;
                        case 'last_15_days':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subDays(14)->startOfDay(),
                                Carbon::now()->endOfDay()
                            ]);
                            break;
                        case 'last_30_days':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subDays(29)->startOfDay(),
                                Carbon::now()->endOfDay()
                            ]);
                            break;
                        case 'this_week':
                            $query->whereBetween('created_at', [
                                Carbon::now()->startOfWeek(),
                                Carbon::now()->endOfWeek()
                            ]);
                            break;
                        case 'last_week':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subWeek()->startOfWeek(),
                                Carbon::now()->subWeek()->endOfWeek()
                            ]);
                            break;
                        case 'this_month':
                            $query->whereBetween('created_at', [
                                Carbon::now()->startOfMonth(),
                                Carbon::now()->endOfMonth()
                            ]);
                            break;
                        case 'last_month':
                            $query->whereBetween('created_at', [
                                Carbon::now()->subMonth()->startOfMonth(),
                                Carbon::now()->subMonth()->endOfMonth()
                            ]);
                            break;
                        case 'from_last_month':
                            $query->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth());
                            break;
                        default:
                            $query->whereDate('created_at', Carbon::today());
                    }
                }
            }

            // Get lead statistics grouped by user
            $userLeads = $query
                ->select([
                    'assigned_by_id',
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status = "New" THEN 1 ELSE 0 END) as new'),
                    DB::raw('SUM(CASE WHEN status = "Qualified" THEN 1 ELSE 0 END) as qualified'),
                    DB::raw('SUM(CASE WHEN status = "Follow Up" THEN 1 ELSE 0 END) as follow_up'),
                    DB::raw('SUM(CASE WHEN status IN ("Online Demo", "Offline Demo", "Onsite Visit") THEN 1 ELSE 0 END) as appointments'),
                    DB::raw('SUM(CASE WHEN status = "Quotation / Ready To Buy" THEN 1 ELSE 0 END) as quotation'),
                    DB::raw('SUM(CASE WHEN status = "Closed or Won" THEN 1 ELSE 0 END) as won'),
                    DB::raw('SUM(CASE WHEN status = "Dropped or Cancel" THEN 1 ELSE 0 END) as cancel')
                ])
                ->groupBy('assigned_by_id')
                ->get();

            // Get user names for the leads
            $userIds = $userLeads->pluck('assigned_by_id')->unique();
            $users = User::whereIn('id', $userIds)->pluck('name', 'id');

            // Format the data with user names
            $formattedLeads = $userLeads->map(function($item) use ($users) {
                return [
                    'name' => $users[$item->assigned_by_id] ?? 'Unknown',
                    'new' => $item->new,
                    'qualified' => $item->qualified,
                    'follow_up' => $item->follow_up,
                    'appointments' => $item->appointments,
                    'quotation' => $item->quotation,
                    'won' => $item->won,
                    'cancel' => $item->cancel,
                    'total' => $item->total
                ];
            });

            // Calculate totals
            $totals = [
                'total' => $formattedLeads->sum('total'),
                'new' => $formattedLeads->sum('new'),
                'qualified' => $formattedLeads->sum('qualified'),
                'follow_up' => $formattedLeads->sum('follow_up'),
                'appointments' => $formattedLeads->sum('appointments'),
                'quotation' => $formattedLeads->sum('quotation'),
                'won' => $formattedLeads->sum('won'),
                'cancel' => $formattedLeads->sum('cancel'),
            ];

            return response()->json([
                'html' => view('admin.partials.lead_stats_table', [
                    'userLeads' => $formattedLeads,
                    'totals' => $totals
                ])->render()
            ]);

        } catch (\Exception $e) {
            \Log::error('Filter error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

}