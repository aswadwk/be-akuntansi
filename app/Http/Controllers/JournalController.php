<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddJournalRequest;
use App\Http\Requests\GetJournalRequest;
use App\Services\AccountService;
use App\Services\JournalService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    private $service;
    private $accountService;
    private $transactionService;

    public function __construct(
        JournalService $service,
        AccountService $accountService,
        TransactionService $transactionService
    ) {
        $this->service = $service;
        $this->accountService = $accountService;
        $this->transactionService = $transactionService;
    }

    public function index(GetJournalRequest $request)
    {
        return inertia('Journal/Index', [
            'journals' => $this->service->getJournals($request->validated()),
            'filters' => $request->validated(),
        ]);
    }

    public function create()
    {
        return inertia('Journal/Create', [
            'accounts' => $this->accountService->search(['all' => true]),
        ]);
    }

    public function store(AddJournalRequest $request)
    {
        $this->service->store($request->validated());

        return redirect('journals');
    }

    public function edit($transactionId)
    {
        return inertia('Journal/Edit', [
            'journals' => $this->transactionService->getTransactionById($transactionId),
            'accounts' => $this->accountService->search(['all' => true]),
        ]);
    }

    public function updateJournal(AddJournalRequest $request, $transactionId)
    {
        $this->service->updateJournal($request->validated(), $transactionId);

        return redirect('journals');
    }

    public function delete($transactionId)
    {
        // $this->service->deleteJournal($transactionId);

        return redirect('journals');
    }
}
