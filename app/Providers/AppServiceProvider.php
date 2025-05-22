<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Leads;
use App\Models\User;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Assigned Users List
                $assignedName = User::select('id', 'name')->get();
                if ($user->id == 1 || $user->id == 2 || $user->id == 17) {
                    $totalLeads = Leads::count();
                    $todayLeads = Leads::whereDate('created_at', Carbon::today())->count();

                    $openedLeadsNull = Leads::whereNull('opened_at')->count();
                    $openedLeadsNotNull = Leads::whereNotNull('opened_at')->count();
                } else {
                    $totalLeads = Leads::where('user_id', $user->id)->count();
                    $todayLeads = Leads::where('user_id', $user->id)
                                       ->whereDate('created_at', Carbon::today())
                                       ->count();

                    $openedLeadsNull = Leads::where('user_id', $user->id)
                                            ->whereNull('opened_at')
                                            ->count();
                                            // dd($openedLeadsNull);
                    $openedLeadsNotNull = Leads::where('user_id', $user->id)
                                               ->whereNotNull('opened_at')
                                               ->count();


                }

                $view->with([
                    'totalLeads' => $totalLeads,
                    'todayLeads' => $todayLeads,
                    'openedLeadsNull' => $openedLeadsNull,
                    'openedLeadsNotNull' => $openedLeadsNotNull,
                    'assignedName' => $assignedName,
                ]);
            }
        });
    }
}
