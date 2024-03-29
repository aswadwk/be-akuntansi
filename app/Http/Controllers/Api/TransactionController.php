<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $service;

    public function __construct(
        TransactionService $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        return ResponseFormatter::success(
            $this->service->getAllTransactions(),
            'success get all transactions',
        );
    }

    public function update(JournalRequest $request, $transactionId)
    {
        return ResponseFormatter::success(
            $this->service->update($request->validated(), $transactionId),
            'transaction success updated.'
        );
    }

    public function show($transactionId)
    {
        return ResponseFormatter::success(
            $this->service->getTransactionById($transactionId),
            'success get transaction by id.'
        );
    }
}
