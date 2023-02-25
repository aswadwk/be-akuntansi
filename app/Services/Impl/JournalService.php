<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantError;
use App\Models\Account;
use App\Models\Journal;
use App\Services\JournalServiceInterface;

class JournalService implements JournalServiceInterface
{
    public function store($attrs)
    {
        //check all account_id must already exist in one query
        $accountIds = array_column($attrs['journals'], 'account_id');
        $accountIds = array_unique($accountIds);
        $accountIds = array_values($accountIds);

        $accountExists = Account::whereIn('id', $accountIds)->count();

        if ($accountExists != count($accountIds)) {
            throw new InvariantError('account not found');
        }

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
        foreach ($attrs['journals'] as $attr) {
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

    public function getJournalByTransactionId($transactionId)
    {
        $journals = Journal::where('transaction_id', $transactionId)->get();

        return $journals;
    }

    public function getJournals($params){
        $journals = Journal::where('user_id', auth()->user()->id);

        if (isset($params['start_date'])) {
            $journals->where('date', '>=', $params['start_date']);
        }

        if (isset($params['end_date'])) {
            $journals->where('date', '<=', $params['end_date']);
        }

        if (isset($params['account_id'])) {
            $journals->where('account_id', $params['account_id']);
        }

        if (isset($params['division_id'])) {
            $journals->where('division_id', $params['division_id']);
        }

        if (isset($params['partner_id'])) {
            $journals->where('partner_id', $params['partner_id']);
        }

        if (isset($params['amount'])) {
            $journals->where('amount', $params['amount']);
        }

        if (isset($params['code'])) {
            $journals->where('code', 'like', '%' . $params['code'] . '%');
        }

        $journals = $journals->paginate(10);

        return $journals;
    }
};
