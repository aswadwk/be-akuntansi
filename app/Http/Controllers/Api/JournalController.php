<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddJournalRequest;
use App\Http\Requests\GetJournalRequest;
use App\Http\Requests\JournalRequest;

class JournalController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = app('JournalService');
    }

    public function index(GetJournalRequest $request)
    {
        return ResponseFormatter::success(
            $this->service->getJournals($request->validated()),
            'Data jurnal berhasil diambil'
        );
    }

    public function store(AddJournalRequest $request)
    {
        return ResponseFormatter::success(
            $this->service->store($request->validated()),
            'journal berhasil dibuat'
        );
    }
}
