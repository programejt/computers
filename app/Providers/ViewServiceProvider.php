<?php

namespace App\Providers;

// use App\Http\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        //View::composer('profile', ProfileComposer::class);

        // Using closure based composers...
        // View::share('user', Auth::user());
        View::composer('*', function ($view) {
          $view->with('authUser', Auth::user());
        });
    }
}