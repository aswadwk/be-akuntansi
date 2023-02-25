<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountTypeRequest;
use App\Http\Requests\AccountTypeSearchRequest;
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
            $this->service->search($id, $request->validated()),
            'Berhasil'
        );
    }

    public function store(AccountTypeRequest $request)
    {
        // dd($request->all());
        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Berhasil'
        );
    }

    public function update(AccountTypeRequest $request, $id)
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
            'Berhasil. Data di delete'
        );
    }
}
