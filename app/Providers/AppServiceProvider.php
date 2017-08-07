<?php

namespace app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use app\Models\System;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sharing Data With All Views
        $system = System::first();
        view::share('system',$system);
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
