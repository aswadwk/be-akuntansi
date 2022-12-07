<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Services\Impl\PartnerService;

class PartnerController extends Controller
{
    protected $service;

    public function __construct(
        PartnerService $service,
    ){
        $this->service = $service;
    }

    public function index(){

        return  ResponseFormatter::success(
            $this->service->get(),
            'Berhasil'
        );
    }

    public function show($id){

    }

    public function store(PartnerRequest $request){

        return  ResponseFormatter::success(
            $this->service->store($request->validated()),
            'Berhasil'
        );
    }

    public function update(){

    }

    public function delete($id){

        return  ResponseFormatter::success(
            $this->service->delete($id),
            'Berhasil'
        );
    }

}
