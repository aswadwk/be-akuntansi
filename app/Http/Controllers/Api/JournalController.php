<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = app('JournalService');
    }

    public function index(){

    }

    public function store(JournalRequest $request){
        // dd($request->validated());

        return ResponseFormatter::success(
            $this->service->store($request->validated()),
            'journal berhasil dibuat'
        );
    }
}
