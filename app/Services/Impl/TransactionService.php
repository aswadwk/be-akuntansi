<?php

namespace App\Services\Impl;

use App\Exceptions\ClientError;
use App\Exceptions\NotFoundError;
use App\Models\Journal;
use App\Models\Transaction;
use App\Services\TransactionServiceInterface;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    public function getAllTransactions()
    {
        $transactions = Transaction::with(['journals'])->get();

        return $transactions;
    }

    public function store($attrs)
    {
        $transaction = Transaction::create($attrs);

        return $transaction;
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);

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
                            throw new NotFoundError('journal not found');
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

            throw new NotFoundError('transaction not found');
        } catch (\Exception $e) {
            if ($e instanceof ClientError) {
                throw new NotFoundError($e->getMessage());
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
