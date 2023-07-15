<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetPartnerRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Services\PartnerService;

class PartnerController extends Controller
{
    protected $service;

    public function __construct(
        PartnerService $service,
    ) {
        $this->service = $service;
    }

    public function index(GetPartnerRequest $request, $parnerId = null)
    {
        return  ResponseFormatter::success(
            $this->service->search($parnerId, $request->validated()),
            'Berhasil'
        );
    }

    public function store(PartnerRequest $request)
    {
        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Partner berhasil ditambahkan.'
        );
    }

    public function update(UpdatePartnerRequest $request)
    {
        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Partner berhasil diubah.'
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
