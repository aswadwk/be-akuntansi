<?php

namespace App\Http\Controllers;

use App\Services\AccountTypeService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $AccountTypesservice;

    public function __construct(
        AccountTypeService $AccountTypesservice
    ) {
        $this->AccountTypesservice = $AccountTypesservice;
    }

    public function index()
    {
    }

    public function AccountTypes()
    {
        $accountTypes = $this->AccountTypesservice->search([]);

        return inertia('Account/Type', [
            'accountTypes' => $accountTypes
        ]);
    }
}
