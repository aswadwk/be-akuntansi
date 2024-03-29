<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $service;

    public function __construct(
        AccountService $service
    ) {
        $this->service = $service;
    }

    public function index(Request $request, $id = null)
    {
        return  ResponseFormatter::success(
            $this->service->search($request->all(), $id),
            'Berhasil'
        );
    }

    public function store(AccountRequest $request)
    {
        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Berhasil'
        );
    }

    public function update(UpdateAccountRequest $request, $id)
    {
        return  ResponseFormatter::success(
            $this->service->update($id, $request->validated()),
            'Akun berhasil di update'
        );
    }

    public function delete($id)
    {
        return  ResponseFormatter::success(
            $this->service->delete($id),
            'Berhasil'
        );
    }
}
