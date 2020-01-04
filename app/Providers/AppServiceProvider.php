<?php

namespace App\Providers;

use App\Aerolinea;
use App\Lugar;
use App\User;
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
            $user_count = User::count('id');
            $user = User::with('roles')->where('id',Auth::user()->id)->first();
            $role_name ='';
            foreach($user->roles as $role)
            {
                $role_name = $role->name;
            }
            $view->with('aerolinea_count',Aerolinea::count('id'))
                ->with('user_count',$user_count)
                ->with('role_name',$role_name);
        });

        View()->composer('layouts.partials.sidebar',function($view){
            $user = User::with('roles')->where('id',Auth::user()->id)->first();
            $role_name ='';
            foreach($user->roles as $role)
            {
                $role_name = $role->name;
            }
            $view->with('role_name',$role_name);
        });
    }
}
