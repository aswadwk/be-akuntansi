<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\AccountTypeService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $service;
    private $accountTypesService;


    public function __construct(
        AccountService $service,
        AccountTypeService $accountTypesService
    ) {
        $this->service = $service;
        $this->accountTypesService = $accountTypesService;
    }

    public function index()
    {
        $accounts = $this->service->search([]);

        return inertia('Account/Index', [
            'accounts' => $accounts
        ]);
    }

    public function AccountTypes()
    {
        $accountTypes = $this->accountTypesService->search([]);

        return inertia('Account/Type', [
            'accountTypes' => $accountTypes
        ]);
    }
}
