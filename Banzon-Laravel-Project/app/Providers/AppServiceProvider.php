<?php


namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        $customerId = session('customer_id');

        $navCustomer = $customerId
            ? DB::table('customer')
                ->select('customer_id', 'name', 'profile_image')
                ->where('customer_id', $customerId)
                ->first()
            : null;

        $view->with('navCustomer', $navCustomer);

        Paginator::useBootstrapFive();
    });
    }
}
