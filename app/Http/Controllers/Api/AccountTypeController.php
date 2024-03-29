<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountTypeRequest;
use App\Http\Requests\AccountTypeSearchRequest;
use App\Http\Requests\updateAccountTypeRequest;
use App\Services\AccountTypeService;

class AccountTypeController extends Controller
{
    protected $service;

    public function __construct(
        AccountTypeService $service
    ) {
        $this->service = $service;
    }

    public function index(AccountTypeSearchRequest $request, $id = null)
    {
        return  ResponseFormatter::success(
            $this->service->search($request->validated(), $id),
            'Berhasil'
        );
    }

    public function store(AccountTypeRequest $request)
    {
        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Berhasil'
        );
    }

    public function update(updateAccountTypeRequest $request, $id)
    {
        return  ResponseFormatter::success(
            $this->service->update($id, $request->validated()),
            'Berhasil. Data di Update'
        );
    }

    public function delete($id)
    {
        return  ResponseFormatter::success(
            $this->service->delete($id),
            'Berhasil.'
        );
    }

    public function getProfitLossAccounts()
    {
        return  ResponseFormatter::success(
            $this->service->getProfitLossAccounts(),
            'Berhasil.'
        );
    }

    public function storeProfitLossAccount($accountTypeId)
    {
        return  ResponseFormatter::success(
            $this->service->addProfitLossAccount($accountTypeId),
            'Berhasil.'
        );
    }

    public function deleteProfitLossAccount($id)
    {
        return  ResponseFormatter::success(
            $this->service->removeProfitLossAccount($id),
            'Berhasil.'
        );
    }
}
