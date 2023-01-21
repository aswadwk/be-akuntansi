<?php

namespace App\Providers;

use App\Services\DivisionServiceInterface;
use App\Services\Impl\DivisionService;
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
        $this->app->bind('DevisionService', function (){
            return new DivisionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
