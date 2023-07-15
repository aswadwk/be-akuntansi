<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddJournalRequest;
use App\Http\Requests\GetJournalRequest;
use App\Services\JournalService;

class JournalController extends Controller
{
    protected $service;

    public function __construct(
        JournalService $service
    ) {
        $this->service = $service;
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

    public function updateJournal(AddJournalRequest $request, $transactionId)
    {
        return ResponseFormatter::success(
            $this->service->updateJournal($request->validated(), $transactionId),
            'journal berhasil diupdate'
        );
    }
}
