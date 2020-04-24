<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Category;
use App\Brand;

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
        View::composer('front-end.includes.header', function ($view) {
            $view->with('categories', Category::where('publication_status', 1)->get());
        });
        
        View::composer('front-end.includes.footer', function ($view) {
            $view->with('brandlists', Brand::where('publication_status',1)->take(5)->get()); 
        });
    }
}
