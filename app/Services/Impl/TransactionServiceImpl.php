<?php

namespace App\Services\Impl;

use App\Models\Journal;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TransactionServiceImpl implements TransactionService
{
    public function getAllTransactions()
    {
        return Transaction::with([
            'journals',
            'journals.account',
            'journals.division',
            'journals.accountHelper',
        ])
            ->get();
    }

    public function store($attrs)
    {
        return Transaction::create($attrs);
    }

    public function getTransactionById($id)
    {
        $transaction = Transaction::with([
            'journals',
            'journals.account',
            'journals.division',
            'journals.accountHelper',
        ])->find($id);

        return $transaction;
    }

    public function update($attrs, $id)
    {
        try {
            $transaction = Transaction::find($id);

            if ($transaction) {
                DB::transaction(function () use ($transaction, $attrs) {
                    // check journal is exist
                    foreach ($attrs as $attr) {
                        $journalIsExist = Journal::find($attr['journal_id']);

                        if ($journalIsExist === null) {
                            throw new NotFoundHttpException('journal not found');
                        }
                    }

                    // update journal
                    foreach ($attrs as $attr) {
                        $journal = Journal::find($attr['journal_id']);

                        unset($attr['journal_id']);
                        $journal->update($attr);
                    }
                });

                return $transaction;
            }

            throw new NotFoundHttpException('transaction not found');
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw new NotFoundHttpException($e->getMessage());
            }

            abort(500);
        }
    }

    public function generateTransactionCode(): string
    {
        return 'TRX-' . now()->format('ymd') . '-' . $this->countDay();
    }

    public function countDay(): int
    {
        $count = Transaction::whereDate('created_at', now()->format('Y-m-d'))->count();

        return $count;
    }
};
