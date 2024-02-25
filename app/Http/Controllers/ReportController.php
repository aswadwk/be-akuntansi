<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountHelper;
use App\Models\Journal;
use App\Services\AccountService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $accountService;

    public function __construct(
        AccountService $accountService,
    ) {
        $this->accountService = $accountService;
    }


    public function generalLedger(Request $request, $id = null)
    {
        if (!$id) {
            return inertia('Reports/GeneralLedger', [
                'generalLedger' => [],
                'accounts' => $this->accountService->search(['all' => true]),
                'from' => $request->from,
                'filters' => [
                    'from' => $request->from,
                    'to' => $request->to,
                    'account_id' => $id ?? '',
                ],
                'to' => $request->to,
            ]);
        }

        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $account = Account::find($id);

        if (!$account) {
            return [];
        }

        $queryGeneralBalance = Journal::with(['account.accountType'])
            ->select('id', 'account_id', 'date', 'description', 'type', 'amount')
            ->where('account_id', $id)
            ->whereDate('date', '<=', $request->to)
            ->orderBy('date', 'asc')
            ->get();

        $generalBalance = [];
        $generalBalance[] = collect([
            'account_id' => $account->id,
            'balance' => $account->balance,
            'debit' => $account->position_normal === 'D' ? $account->balance : 0,
            'credit' => $account->position_normal === 'C' ? $account->balance : 0,
            'type' => $account->position_normal,
            'date' => $account->created_at,
            'description' => 'Saldo Awal',
            'name' => $account->name ?? null,
        ]);

        $balance = $account->balance;
        foreach ($queryGeneralBalance as $journal) {
            $journal->debit = $journal->type === 'D' ? $journal->amount : 0;
            $journal->credit = $journal->type === 'C' ? $journal->amount : 0;

            $balance += $journal->account->accountType->position_normal === 'D'
                ? $journal->debit - $journal->credit
                : $journal->credit - $journal->debit;

            $journal->balance = $balance;
            $journal->name = $account->name ?? null;

            $generalBalance[] = $journal;
        }

        if ($queryGeneralBalance) {
            return inertia('Reports/GeneralLedger', [
                'generalLedger' => $generalBalance,
                'accounts' => $this->accountService->search(['all' => true]),
                'filters' => [
                    'from' => $request->from,
                    'to' => $request->to,
                    'account_id' => $id ?? '',
                ],
            ]);
        } else {
            return inertia('Reports/GeneralLedger', [
                'generalLedger' => [],
                'accounts' => $this->accountService->search(['all' => true]),
                'filters' => [
                    'from' => $request->from,
                    'to' => $request->to,
                    'account_id' => $id ?? '',
                ],
            ]);
        }
    }

    public function accountHelper(Request $request, $accountHelperId = null)
    {
        $accounts = AccountHelper::all();

        if (!$accountHelperId) {
            return inertia('Reports/AccountHelper', [
                'accounts' => $accounts,
                'journals' => [],
            ]);
        }

        $journalWithAccountHelper = Journal::with(['accountHelper'])
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('date', '<=', $request->end_date);
            })
            ->where('account_helper_id', $accountHelperId)
            ->orderBy('date', 'asc')
            ->get();

        $balance = 0;

        $journalWithAccountHelper->each(function ($journal) use (&$balance) {
            $journal->debit = $journal->type === 'D' ? $journal->amount : 0;
            $journal->credit = $journal->type === 'C' ? $journal->amount : 0;

            $balance += $journal->type === 'D' ? $journal->amount : -$journal->amount;
            $journal->balance = $balance;
        });

        return inertia('Reports/AccountHelper', [
            'accounts' => $accounts,
            'journals' => $journalWithAccountHelper,
        ]);
    }

    public function worksheet(Request $request)
    {
        $accounts = Account::with(['journals'])
            ->get();

        $debit = 0;
        $credit = 0;

        $accounts->each(function ($account) use (&$debit, &$credit) {
            $account->journals->each(function ($journal) use (&$debit, &$credit) {
                $journal->debit = $journal->type === 'D' ? $journal->amount : 0;
                $journal->credit = $journal->type === 'C' ? $journal->amount : 0;

                $debit += $journal->debit;
                $credit += $journal->credit;
            });

            $account->debit = $debit;
            $account->credit = $credit;
        });

        return inertia('Reports/Worksheet', [
            "accounts" => $accounts,
        ]);
    }
}
