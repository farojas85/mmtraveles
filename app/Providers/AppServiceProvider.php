<?php

namespace App\Providers;

use App\Aerolinea;
use App\Lugar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        View()->composer('home',function($view){
            $view->with('aerolinea_count',Aerolinea::count('id'));
        });

    }
}
