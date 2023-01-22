<?php

namespace App\Providers;

use App\Services\DivisionServiceInterface;
use App\Services\Impl\DivisionService;
use App\Services\Impl\JournalService;
use App\Services\Impl\TransactionService;
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
        $this->app->bind('DevisionService', function () {
            return new DivisionService();
        });

        $this->app->bind('JournalService', function () {
            return new JournalService();
        });

        $this->app->bind('TransactionService', function () {
            return new TransactionService();
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
