<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountTypeRequest;
use App\Http\Requests\updateAccountTypeRequest;
use App\Models\AccountType;
use App\Services\AccountTypeService;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    private $service;

    public function __construct(
        AccountTypeService $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        $accountTypes = $this->service->search([]);
        return inertia('AccountType/Index', [
            'accountTypes' => $accountTypes
        ]);
    }

    public function create()
    {
        return inertia('AccountType/Create');
    }

    public function store(AccountTypeRequest $request)
    {
        $this->service->store(
            $request->validated()
        );

        return $this->index();
    }

    public function show($accountTypeId)
    {
    }

    public function edit($accountTypeId)
    {
        $accountType = $this->service->search([], $accountTypeId);

        return inertia('AccountType/Edit', [
            'accountType' => $accountType
        ]);
    }

    public function update(updateAccountTypeRequest $request, $accountTypeId)
    {
        $this->service->update($accountTypeId, $request->validated());

        return $this->index();
    }

    public function delete($accountTypeId)
    {
        $this->service->delete($accountTypeId);

        return $this->index();
    }
}
