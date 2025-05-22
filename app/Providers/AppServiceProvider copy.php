<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Leads;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    // public function boot()
    // {
    //     //
    // }
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();

                if ($user->id == 1) {

                    $totalLeads = Leads::count();
                    $todayLeads = Leads::whereDate('created_at', Carbon::today())->count();
                    $openedLeads = Leads::whereNull('opened_at')
                    ->count();


dd($openedLeads);
                } else {
                    $totalLeads = Leads::where('user_id', $user->id)->count();
                    $todayLeads = Leads::where('user_id', $user->id)
                                       ->whereDate('created_at', Carbon::today())
                                       ->count();
                $openedLeads = Leads::where('user_id', $user->id)
                                       ->where('opened_at','NULL')
                                       ->count();
dd($openedLeads);
                }

                $view->with([
                    'totalLeads' => $totalLeads,
                    'todayLeads' => $todayLeads,
                    'openedLeads' => $openedLeads,
                ]);
            }
        });
    }
}