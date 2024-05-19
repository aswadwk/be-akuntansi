<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\ProfitLossRequest;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\SettingReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingReportController extends Controller
{
    public function profitLoss()
    {
        $settings = SettingReport::where('report_type', SettingReport::TYPE_PROFIT_LOSS)
            ->orderBy('order', 'asc')
            ->get();

        return inertia('Setting/Report/ProfitLoss', [
            'accounts' => Account::all(),
            'settings' => $settings->each(function ($setting) {
                $setting->accounts = explode(',', $setting->account_ids);
                $setting->section = (int) $setting->order;
            }),
        ]);
    }

    public function storeProfitLoss(ProfitLossRequest $request)
    {
        try {
            DB::beginTransaction();

            SettingReport::where('report_type', SettingReport::TYPE_PROFIT_LOSS)->delete();

            foreach ($request->settings as $setting) {

                SettingReport::create([
                    'report_type' => SettingReport::TYPE_PROFIT_LOSS,
                    'title' => $setting['title'],
                    'type' => $setting['type'],
                    'sub_title' => $setting['sub_title'] ?? null,
                    'order' => $setting['section'],
                    // array to string
                    'account_ids' => implode(',', $setting['accounts']),
                    'created_by' => auth('web')->id()
                ]);
            }

            DB::commit();

            return redirect()->route('web.setting-report.profit-loss');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', $th->getMessage());
        }
    }

    public function balanceSheet(Request $request)
    {
        $settings = SettingReport::where('report_type', SettingReport::TYPE_BALANCE_SHEET)
            ->orderBy('order', 'asc')
            ->get();

        return inertia('Setting/Report/BalanceSheet', [
            'accounts' => Account::all(),
            'settings' => $settings->each(function ($setting) {
                $setting->accounts = explode(',', $setting->account_ids);
                $setting->section = (int) $setting->order;
            }),
        ]);
    }

    public function storeBalanceSheet(ProfitLossRequest $request)
    {
        try {
            DB::beginTransaction();

            SettingReport::where('report_type', SettingReport::TYPE_BALANCE_SHEET)->delete();

            foreach ($request->settings as $setting) {

                SettingReport::create([
                    'report_type' => SettingReport::TYPE_BALANCE_SHEET,
                    'title' => $setting['title'],
                    'type' => $setting['type'],
                    'sub_title' => $setting['sub_title'] ?? null,
                    'order' => $setting['section'],
                    // array to string
                    'account_ids' => implode(',', $setting['accounts']),
                    'created_by' => auth('web')->id()
                ]);
            }

            DB::commit();

            return redirect()->route('web.setting-report.balance-sheet');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', $th->getMessage());
        }
    }
}
