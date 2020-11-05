<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', 'App\ViewComposer\ViewComposer');
    }
}

// view()->composer('*', function ($view) {
//     $view->with('dashboard_composer', \App\Models\Dashboard::first());
// });
