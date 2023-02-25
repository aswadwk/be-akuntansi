<?php

namespace App\Services\Impl;

use App\Models\Journal;
use App\Services\JournalServiceInterface;

class JournalService implements JournalServiceInterface
{
    public function store($attrs)
    {
        // Generate transaction code
        $transactionCode = app('TransactionService')->generateTransactionCode();

        // insert transaction
        $attrTransaction = [
            'code'    => $transactionCode,
            'user_id' => auth()->user()->id,
        ];

        $transaction = app('TransactionService')->store($attrTransaction);

        // Loop through journal attributes
        $journalCount = 1;
        foreach ($attrs as $attr) {
            // Create journal array
            $journal = [
                'code'           => $this->generateJournalCode($journalCount),
                'date'           => $attr['date'],
                'amount'         => $attr['amount'],
                'account_id'     => $attr['account_id'],
                'transaction_id' => $transaction->id,
                'description'    => $attr['description'],
                'type'           => $attr['type'],
                'user_id'        => auth()->user()->id,
            ];

            // Check for division_id
            if (isset($attr['division_id'])) {
                $journal['division_id'] = $attr['division_id'];
            }

            // Check for partner_id
            if (isset($attr['partner_id'])) {
                $journal['partner_id'] = $attr['partner_id'];
            }

            // Create journal
            Journal::create($journal);
            $journalCount++;
        }

        return $transaction;
    }

    public function generateJournalCode($num)
    {
        $code = 'JRNL-' . date('Ymd') . '-' . $num;

        return $code;
    }
};
