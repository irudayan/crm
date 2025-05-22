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
    public function index()
    {
        $user = auth()->user();
// $roles = $user->roles->pluck('name')->toArray();
// dd($roles);
            $user = auth()->user();
            $assignedName = User::select('id', 'name')->distinct()->get();
            //   $assignedName = User::select('id', 'name')->get();
            $today = Carbon::today();

            $today = Carbon::today(); // today 00:00:00
            $endOfDay = Carbon::today()->endOfDay(); // today 23:59:59

             // New count: Leads assigned by current user
            $assignedLeadsCount = Leads::where('assigned_by_id', $user->id)->count();
// dd($assignedLeadsCount);


             // Default null values
            $userCount = null;
            $userLeadsCount = [];

            // if (auth()->id() == 1) {
            if (in_array(auth()->id(), [1, 2])) {
                $userCount = User::count();

                // Get all users and their total leads count
                // $userLeadsCount = DB::table('users')
                //     ->leftJoin('leads', 'users.id', '=', 'leads.assigned_by_id')
                //     ->select('users.id', 'users.name', DB::raw('COUNT(leads.id) as total_leads'))
                //     ->groupBy('users.id', 'users.name')
                //     ->get();

                $userLeadsCount = DB::table('users')
                ->leftJoin('leads', 'users.id', '=', 'leads.assigned_by_id')
                ->select(
                    'users.id',
                    'users.name',
                    DB::raw('COUNT(leads.id) as total_leads'),
                    DB::raw('SUM(CASE WHEN DATE(leads.created_at) = "' . Carbon::today()->format('Y-m-d') . '" THEN 1 ELSE 0 END) as today_leads')
                )
                ->groupBy('users.id', 'users.name')
                ->get();
            }

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
            // $openedLeads = Leads::whereNotNull('opened_at')->count();
            // $openedLeads = Leads::whereDate('opened_at')->count();
            // dd('ijnn');
            // $openedLeads = Leads::whereDate('opened_at', Carbon::today())->count();
            // today
            // $openedLeads = Leads::with('products', 'user')->whereNull('opened_at')->count();

            $openedLeadsNull = Leads::with('products', 'user')->whereNull('opened_at')->count();
            // dd($openedLeadsNull);
            $openedLeadsNotNull = Leads::with('products', 'user')->whereNotNull('opened_at')->count();


            $todayLeads = Leads::whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::with('products', 'user')->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayFlowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();


        } elseif (auth()->id() == 2) {

            // followup
            // $followupLeads = Leads::with('products', 'user')
            // ->whereRaw("TIMESTAMP(follow_date, follow_time) BETWEEN ? AND ?", [$today, $endOfDay])
            // ->get();
            // // dd($followupLeads);
            // // Admin: Get only leads assigned to them
            // $leads = Leads::with('products', 'user')
            // ->where('assigned_name', $user->id)
            // ->whereDate('created_at', Carbon::today())
            // ->get();
            // $totalLeads = Leads::with('products', 'user')->where('user_id', $user->id)->count();
            // $todayLeads = Leads::where('user_id', $user->id)->whereDate('created_at', $today)->count();
            // $newLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'New')->count();
            // $demoLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->count();
            // $quotationLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Quotation / Ready To Buy')->count();

            // $qualifiedLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Qualified')->count();
            // $flowupLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Follow Up')->count();
            // $closedorwonLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Closed or Won')->count();
            // $cancelLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Dropped or Cancel')->count(); // Fixed Typo
            // // $openedLeads = Leads::whereDate('opened_at', Carbon::today())->count();
            // // $openedLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereNull('opened_at')->count();

            // $openedLeadsNull = Leads::with('products', 'user')->where('user_id', $user->id)->whereNull('opened_at')->count();
            // // dd($openedLeadsNull);
            // $openedLeadsNotNull = Leads::with('products', 'user')->where('user_id', $user->id)->whereNotNull('opened_at')->count();
            // $todayNewLeads =  Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'New')->whereDate('created_at', $today)->count();


            // $todayFlowupLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            // $todayDemoLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            // $todayClosedorwonLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();

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
            // $openedLeads = Leads::whereNotNull('opened_at')->count();
            // $openedLeads = Leads::whereDate('opened_at')->count();
            // dd('ijnn');
            // $openedLeads = Leads::whereDate('opened_at', Carbon::today())->count();
            // today
            // $openedLeads = Leads::with('products', 'user')->whereNull('opened_at')->count();

            $openedLeadsNull = Leads::with('products', 'user')->whereNull('opened_at')->count();
            // dd($openedLeadsNull);
            $openedLeadsNotNull = Leads::with('products', 'user')->whereNotNull('opened_at')->count();


            $todayLeads = Leads::whereDate('created_at', $today)->count();
            $todayNewLeads = Leads::with('products', 'user')->where('status', 'New')->whereDate('created_at', $today)->count();
            $todayFlowupLeads = Leads::with('products', 'user')->where('status', 'Follow Up')->whereDate('created_at', $today)->count();
            $todayDemoLeads = Leads::with('products', 'user')->whereIn('status', ['Online Demo', 'Offline Demo', 'Onsite Visit'])->whereDate('created_at', $today)->count();
            $todayClosedorwonLeads = Leads::with('products', 'user')->where('status', 'Closed or Won')->whereDate('created_at', $today)->count();

        } else {
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
            $cancelLeads = Leads::with('products', 'user')->where('user_id', $user->id)->where('status', 'Dropped or Cancel')->count(); // Fixed TypoFixed Typo
            // $openedLeads = Leads::whereDate('opened_at', Carbon::today())->count();
            // $openedLeads = Leads::with('products', 'user')->where('user_id', $user->id)->whereNull('opened_at')->count();

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

    return view('admin.home', compact(
        'totalLeads','followupLeads','todayLeads', 'newLeads','qualifiedLeads','flowupLeads', 'demoLeads', 'quotationLeads','closedorwonLeads', 'cancelLeads', 'leads', 'products','assignedLeadsCount','userCount','userLeadsCount','todayFlowupLeads','todayDemoLeads','todayClosedorwonLeads','openedLeadsNull','openedLeadsNotNull','todayNewLeads'));

    }
}
