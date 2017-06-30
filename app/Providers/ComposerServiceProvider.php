<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // view()->composer('layouts/admin', function ($view) {
        //     $view->with('siteName','222');
        // });
        // View::composer(
        //     'admin.common.*', 'App\Http\ViewComposers\AdminComposer'
        // );
        View::composer(
            '*', 'App\Http\Controllers\Admin\MainController'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
