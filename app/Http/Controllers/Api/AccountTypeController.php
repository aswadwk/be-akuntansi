<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountTypeRequest;
use App\Http\Requests\AccountTypeSearchRequest;
use App\Http\Requests\updateAccountTypeRequest;
use App\Services\Impl\AccountTypeService;

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
            $this->service->search($request->validated()),
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
            $this->service->update($id, $request->validated(), $id),
            'Berhasil. Data di Update'
        );
    }

    public function delete($id)
    {
        return  ResponseFormatter::success(
            $this->service->delete($id),
            'Berhasil. Data di delete'
        );
    }
}
