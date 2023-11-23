<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\UpdateAccountRequest;
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

    public function create()
    {
        return inertia('Account/Create', [
            'accountTypes' => $this->accountTypesService->search(['all' => true])
        ]);
    }

    public function store(AccountRequest $request)
    {
        $this->service->store($request->validated());

        return redirect('accounts');
    }

    public function edit($accountId)
    {
        $account = $this->service->search([], $accountId);

        return inertia('Account/Edit', [
            'account' => $account,
            'accountTypes' => $this->accountTypesService->search(['all' => true])
        ]);
    }

    public function update(UpdateAccountRequest $request, $accountId)
    {
        $this->service->update($accountId, $request->validated());

        return redirect('accounts');
    }

    public function delete($accountId)
    {
        $this->service->delete($accountId);

        return redirect('accounts');
    }
}
