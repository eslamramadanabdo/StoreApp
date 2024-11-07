<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Validator;

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
        Validator::extend('filter' , function($attribute , $value , $params){
            return ! in_array(strtolower($value) , $params );
        } , "This :attribute is prohippted");

        Paginator::useBootstrapFive();
    }
}
