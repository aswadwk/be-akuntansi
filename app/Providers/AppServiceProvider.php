<?php

namespace App\Providers;

use App\Services\AccountHelperService;
use App\Services\AccountService;
use App\Services\AccountTypeService;
use App\Services\AuthService;
use App\Services\DivisionService;
use App\Services\Impl\AccountHelperServiceImpl;
use App\Services\Impl\AccountServiceImpl;
use App\Services\Impl\AccountTypeServiceImpl;
use App\Services\Impl\AuthServiceImpl;
use App\Services\Impl\DivisionServiceImpl;
use App\Services\Impl\JournalServiceImpl;
use App\Services\Impl\TransactionServiceImpl;
use App\Services\JournalService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(
            AuthService::class,
            AuthServiceImpl::class,
        );

        $this->app->bind(
            AccountTypeService::class,
            AccountTypeServiceImpl::class,
        );

        $this->app->bind(
            AccountService::class,
            AccountServiceImpl::class,
        );

        $this->app->bind(
            DivisionService::class,
            DivisionServiceImpl::class,
        );

        $this->app->bind(
            TransactionService::class,
            TransactionServiceImpl::class,
        );

        $this->app->bind(
            JournalService::class,
            JournalServiceImpl::class,
        );

        $this->app->bind(
            AccountHelperService::class,
            AccountHelperServiceImpl::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
