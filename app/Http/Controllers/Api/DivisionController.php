<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DivisionRequest;
use App\Http\Requests\GetDivisionRequest;
use App\Services\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    protected $service;

    public function __construct(
        DivisionService $service
    ) {
        $this->service = $service;
    }

    public function index(GetDivisionRequest $request, $id = null)
    {
        return ResponseFormatter::success(
            $this->service->search($id, $request->validated()),
            'success get all division'
        );
    }

    public function store(DivisionRequest $request)
    {
        return ResponseFormatter::success(
            $this->service->store($request->validated()),
            'success create division'
        );
    }

    public function update(DivisionRequest $request, $id)
    {
        return ResponseFormatter::success(
            $this->service->update($id, $request->validated()),
            'success update division'
        );
    }

    public function delete($parnerId)
    {
        return ResponseFormatter::success(
            $this->service->delete($parnerId),
            'success delete division'
        );
    }
}
