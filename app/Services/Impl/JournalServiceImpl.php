<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantError;
use App\Models\Account;
use App\Models\AccountHelper;
use App\Models\Journal;
use App\Models\Transaction;
use App\Services\JournalService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalServiceImpl implements JournalService
{
    public function store($attrs)
    {
        //check all account_id must already exist in one query
        $accountIds = array_column($attrs['journals'], 'account_id');
        $accountIds = array_unique($accountIds);
        $accountIds = array_values($accountIds);

        $accountExists = Account::whereIn('id', $accountIds)->count();

        if ($accountExists != count($accountIds)) {
            throw new BadRequestHttpException('account not found');
        }

        // check account helper
        if (isset($attrs['account_helper_id'])) {
            $accountHelper = AccountHelper::where('id', $attrs['account_helper_id'])->first();
            if (!$accountHelper) {
                throw new NotFoundHttpException('Account helper not found.');
            }
        }
        // $accountHelper = AccountHelper::where('id', $attrs['account_helper_id'])->first();
        // dd($attrs);
        // if (!$accountHelper) {
        //     throw new NotFoundHttpException('Account helper not found.');
        // }

        try {
            DB::beginTransaction();
            // Generate transaction code
            $transactionCode = app(TransactionService::class)->generateTransactionCode();

            // insert transaction
            $attrTransaction = [
                'code'    => $transactionCode,
                'user_id' => auth()->user()->id,
            ];

            $transaction = app(TransactionService::class)->store($attrTransaction);

            // Loop through journal attributes
            $journalCount = 1;
            $amountDebet = 0;
            $amountCredit = 0;
            foreach ($attrs['journals'] as $attr) {
                // Create journal array
                if (isset($attrs['date']) && $attr['amount'] && $attr['account_id'] && $attr['type']) {
                    $journal = [
                        'code'           => $this->generateJournalCode($journalCount),
                        'date'           => $attrs['date'],
                        'amount'         => $attr['amount'],
                        'account_id'     => $attr['account_id'],
                        'transaction_id' => $transaction->id,
                        'description'    => $attrs['description'] ?? null,
                        'type'           => $attr['type'],
                        'user_id'        => auth()->user()->id,
                    ];

                    // Check for division_id
                    if (isset($attrs['division_id'])) {
                        $journal['division_id'] = $attrs['division_id'];
                    }

                    // Check for account_helper_id
                    if (isset($attrs['account_helper_id'])) {
                        $journal['account_helper_id'] = $attrs['account_helper_id'];
                    }

                    // Create journal
                    Journal::create($journal);

                    $journalCount++;
                    $amountCredit += $attr['type'] === Journal::TYPE_CREDIT ? $attr['amount'] : 0;
                    $amountDebet += $attr['type'] === Journal::TYPE_DEBIT ? $attr['amount'] : 0;
                }
            }

            if ($amountCredit !== $amountDebet) {
                throw new BadRequestHttpException('amount debit and credit must be same');
            }

            DB::commit();

            return $transaction;
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());

            throw $err;
        }
    }

    public function generateJournalCode($num)
    {
        $code = 'JRNL-' . date('Ymd') . '-' . $num . '-' . rand(100, 999);

        return $code;
    }

    public function getJournalByTransactionId($transactionId)
    {
        $journals = Journal::where('transaction_id', $transactionId)->get();

        return $journals;
    }

    public function getJournals($params)
    {
        $journals = Journal::with(['account', 'accountHelper'])->orderBy('created_at', 'desc');

        if (isset($params['start_date'])) {
            $journals->whereDate('date', '>=', $params['start_date']);
        }

        if (isset($params['end_date'])) {
            $journals->whereDate('date', '<=', $params['end_date']);
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

    public function updateJournal($params, $transactionId)
    {
        $transaction = Transaction::where('id', $transactionId)->first();

        if (!$transaction) {
            throw new NotFoundHttpException('transaction tidak ditemukan');
        }

        //check all account_id must already exist in one query
        $accountIds = array_column($params['journals'], 'account_id');
        $accountIds = array_unique($accountIds);
        $accountIds = array_values($accountIds);

        $accountExists = Account::whereIn('id', $accountIds)->count();

        if ($accountExists != count($accountIds)) {
            throw new BadRequestHttpException('account not found');
        }

        try {
            DB::beginTransaction();

            // delete all journal
            Journal::where('transaction_id', $transactionId)->delete();

            // Loop through journal attributes
            $journalCount = 1;
            $amountDebit = 0;
            $amountCredit = 0;

            foreach ($params['journals'] as $param) {
                // Create journal array
                if (isset($params['date']) && $param['amount'] && $param['account_id'] && $param['type']) {
                    $journal = [
                        'code'           => $this->generateJournalCode($journalCount),
                        'date'           => $params['date'],
                        'amount'         => $param['amount'],
                        'account_id'     => $param['account_id'],
                        'transaction_id' => $transaction->id,
                        'description'    => $params['description'] ?? null,
                        'type'           => $param['type'],
                        'user_id'        => auth()->user()->id,
                    ];

                    // Check for division_id
                    if (isset($param['division_id'])) {
                        $journal['division_id'] = $param['division_id'];
                    }

                    // Check for account_helper_id
                    if (isset($params['account_helper_id'])) {
                        $journal['account_helper_id'] = $params['account_helper_id'];
                    }

                    Journal::create($journal);

                    $journalCount++;
                    $amountCredit += $param['type'] === Journal::TYPE_CREDIT ? $param['amount'] : 0;
                    $amountDebit += $param['type'] === Journal::TYPE_DEBIT ? $param['amount'] : 0;
                }
            }

            if ($amountCredit !== $amountDebit) {
                throw new BadRequestHttpException('amount debit and credit must be same');
            }

            DB::commit();

            return $transaction;
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());

            if ($err instanceof BadRequestHttpException) {
                throw $err;
            }

            throw new BadRequestHttpException('failed to create journal');
        }
    }
};
