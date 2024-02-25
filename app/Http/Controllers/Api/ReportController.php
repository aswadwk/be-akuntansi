<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report\GeneralLedgerResource;
use App\Models\Account;
use App\Models\Journal;
use App\Models\ProfitLossAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function bukuBesar(Request $request, $id)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $account = Account::find($id);

        if (!$account) {
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
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
            return ResponseFormatter::success($generalBalance, 'Data Buku Besar!!!');
        } else {
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
        }
    }

    public function neraca_lajur(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $_neraca_lajur =  DB::select("SELECT a.id, a.name, a.code, a.balance, j.type, j.amount,
        SUM(
            CASE WHEN j.type = 'D' THEN j.amount ELSE 0
        END
        ) AS DEBET,
        SUM(
            CASE WHEN j.type = 'C' THEN j.amount ELSE 0
        END
        ) AS CREDIT,
        CASE WHEN j.account_id IN(
            SELECT id FROM accounts WHERE code >= '400' AND code <= '599'
                -- OR account_type_id = '500000'
                -- OR account_type_id = '610000'
                -- OR account_type_id = '630000'
                -- account_type_id = '610000'
                -- OR account_type_id = '400000'
                -- OR account_type_id = '500000'
                -- OR account_type_id = '610000'
                -- OR account_type_id = '630000'
        ) THEN 1 ELSE 0
        END AS laba_rugi
        FROM
            accounts AS a
        INNER JOIN journals AS j
        ON
            a.id = j.account_id WHERE j.deleted_at IS NULL AND j.date <= '$request->to'
        GROUP BY
            a.id ORDER BY a.code ASC");

        $_sa = 0;

        foreach ($_neraca_lajur as $a) {
            $a->sa_debet = 0;
            $a->sa_credit = 0;
            $a->_lb_debet = 0;
            $a->_lb_credit = 0;
            $a->_n_debet = 0;
            $a->_n_credit = 0;

            $a->DEBET += 0;
            $a->CREDIT += 0;
            $a->amount += 0;

            if ($a->amount) {
                $a->value = true;
                $_sa = $a->DEBET - $a->CREDIT;

                if ($_sa > 0) {
                    $a->sa_debet = $_sa;

                    $a->_n_credit = 0;

                    if ($a->laba_rugi) {
                        $a->_lb_debet = $_sa;
                    } else {
                        $a->_n_debet = $_sa;
                    }
                } else {
                    $a->_lb_debet = 0;
                    $a->_n_credit = 0;
                    $a->sa_credit = abs($_sa);
                    if ($a->laba_rugi) {
                        $a->_lb_credit = abs($_sa);
                    } else {
                        $a->_n_credit = abs($_sa);
                    }
                }
            } else {
                $a->value = false;
            }
        }

        foreach ($_neraca_lajur as $a) {
            $a->DEBET += $a->type === 'D' ? $a->balance : 0;
            $a->CREDIT += $a->type === 'C' ? $a->balance : 0;
        }

        if ($_neraca_lajur)
            return ResponseFormatter::success($_neraca_lajur, 'Data Neraca Lajur!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }

    public function buku_pembantu($id)
    {
        // dd($id);
        $buku_pembantu = DB::select("SELECT
        p.id,
        j.date,
        j.description,
        p.name,
        p.account_type,
        j.amount,
        j.type,
        CASE WHEN j.type = 'D' THEN j.amount ELSE 0
        END AS DEBET,
        CASE WHEN j.type = 'C' THEN j.amount ELSE 0
        END AS CREDIT
        FROM
            `journals` AS j
        INNER JOIN account_helpers AS p
        ON
            j.account_helper_id = p.id
        WHERE
            j.account_helper_id IS NOT NULL
            AND j.deleted_at IS NULL
            AND p.id = '$id'
        --     AND j.account_id IN(
        --     SELECT id
        --     FROM accounts
        --     WHERE account_type_id = '113000' OR account_type_id = '211000'
        -- )
        ");

        $saldo = 0;
        foreach ($buku_pembantu as $item) {
            if ($item->account_type === "PIUTANG") {
                $saldo += $item->DEBET - $item->CREDIT;
                $item->saldo = $saldo;
            } else {
                $saldo += $item->CREDIT - $item->DEBET;
                $item->saldo = $saldo;
            }
        }

        if ($buku_pembantu)
            return ResponseFormatter::success($buku_pembantu, 'Data Partners!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }

    public function account_hutang()
    {
        $hutang = DB::select("SELECT * FROM `partners` WHERE account_type='HUTANG'");

        if ($hutang)
            return ResponseFormatter::success($hutang, 'Data Akun Hutang!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }
    public function account_piutang()
    {
        $piutang = DB::select("SELECT * FROM `partners` WHERE account_type='PIUTANG'");

        if ($piutang)
            return ResponseFormatter::success($piutang, 'Data Akun piutang!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }


    // Laporan Keuangan
    public function neraca(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $_neraca =  DB::select("SELECT
         a.account_type_id AS kode_type,
        AT.name as nama_type_akun,
        a.id,
        a.name,
        a.code,
        j.type,
        AT.position_normal,

        j.amount,
        SUM(
            CASE WHEN j.type = 'D' AND j.date <= '$request->to' THEN j.amount ELSE 0
        END
        ) AS DEBET,
        SUM(
            CASE WHEN j.type = 'C' AND j.date <= '$request->to' THEN j.amount ELSE 0
        END
        ) AS CREDIT
        FROM
            accounts AS a
        INNER JOIN journals AS j
        ON
            a.id = j.account_id
        INNER JOIN account_types AS AT
        ON
            a.account_type_id = AT.id WHERE
            AT.code >= '100' AND AT.code <= '399'
                -- a.account_type_id != '410'   #Kas
                -- or a.account_type_id != '510' #Bank
                -- OR a.account_type_id = '112000' #BANK
                -- OR a.account_type_id = '113000' #PIUTANG
                -- OR a.account_type_id = '114000' #PERSEDIAAN

                -- OR a.account_type_id = '121000' #AKTIVA TETAP
                -- OR a.account_type_id = '122000' #DEPRESIASI DAN AMORTISASI Akum. Penyusutan
                -- OR a.account_type_id = '123000' #Piutang Jangka Panjang

                -- OR a.account_type_id = '211000' #Akun Hutang
                -- OR a.account_type_id = '214000' #Hutang Jangka Pendek
                -- OR a.account_type_id = '212000' #KEWAJIBAN JANGKA PANJANG

                -- OR a.account_type_id = '321000' #EKUITAS
                -- OR a.account_type_id = '321001' #MODAL AWAL
                -- OR a.account_type_id = '321004' #tambahan Modal Disetor
                -- OR a.account_type_id = '321006' #laba Ditahan
                -- OR a.account_type_id = '321007' #LABA PERIODE BERJALAN
                -- OR a.account_type_id = '500000' #BIAYA ATAS PENDAPATAN
                -- OR a.account_type_id = '630000' #BEBAN PENYUSUTAN

        AND j.deleted_at IS NULL AND j.date <= '$request->to'

        GROUP BY
            a.id ORDER BY a.code ASC");

        foreach ($_neraca as $a) {

            if ($a->position_normal == "D") {
                $a->total = $a->DEBET - $a->CREDIT;
            } else {
                $a->total =  $a->CREDIT - $a->DEBET;
            }

            if ($a->total < 0) {
                $a->total = abs($a->total);
                $a->position_normal = 'C';
            }
        }

        $arr = [];
        foreach ($_neraca as $key => $item) {
            $arr[] =  $item;
        }

        if ($_neraca)
            return ResponseFormatter::success($arr, 'Data Partners!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }

    public function profitLoss(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $_neraca =  DB::select("SELECT
         a.account_type_id AS kode_type,
        AT.name as nama_type_akun,
        a.id,
        a.name,
        a.code,
        j.type,
        AT.position_normal,

        j.amount,
        SUM(
            CASE WHEN j.type = 'D' AND j.date <= '$request->to' THEN j.amount ELSE 0
        END
        ) AS DEBET,
        SUM(
            CASE WHEN j.type = 'C' AND j.date <= '$request->to' THEN j.amount ELSE 0
        END
        ) AS CREDIT
        FROM
            accounts AS a
        INNER JOIN journals AS j
        ON
            a.id = j.account_id
        RIGHT JOIN account_types AS AT
        ON
            a.account_type_id = AT.id WHERE AT.code >= '400' AND AT.code <= '599'
            -- a.account_type_id = AT.id WHERE a.account_type_id
            -- IN(SELECT account_type_id FROM profit_loss_accounts WHERE deleted_at IS NULL)
                -- a.account_type_id != '410'   #Kas
                -- or a.account_type_id != '510' #Bank
                -- OR a.account_type_id = '112000' #BANK
                -- OR a.account_type_id = '113000' #PIUTANG
                -- OR a.account_type_id = '114000' #PERSEDIAAN

                -- OR a.account_type_id = '121000' #AKTIVA TETAP
                -- OR a.account_type_id = '122000' #DEPRESIASI DAN AMORTISASI Akum. Penyusutan
                -- OR a.account_type_id = '123000' #Piutang Jangka Panjang

                -- OR a.account_type_id = '211000' #Akun Hutang
                -- OR a.account_type_id = '214000' #Hutang Jangka Pendek
                -- OR a.account_type_id = '212000' #KEWAJIBAN JANGKA PANJANG

                -- OR a.account_type_id = '321000' #EKUITAS
                -- OR a.account_type_id = '321001' #MODAL AWAL
                -- OR a.account_type_id = '321004' #tambahan Modal Disetor
                -- OR a.account_type_id = '321006' #laba Ditahan
                -- OR a.account_type_id = '321007' #LABA PERIODE BERJALAN
                -- OR a.account_type_id = '500000' #BIAYA ATAS PENDAPATAN
                -- OR a.account_type_id = '630000' #BEBAN PENYUSUTAN

        AND j.deleted_at IS NULL AND j.date <= '$request->to'

        GROUP BY
            a.id ORDER BY a.code ASC");

        foreach ($_neraca as $a) {

            if ($a->position_normal == "D") {
                $a->total = $a->DEBET - $a->CREDIT;
            } else {
                $a->total =  $a->CREDIT - $a->DEBET;
            }
        }

        $arr = [];
        foreach ($_neraca as $key => $item) {
            $arr[] =  $item;
        }

        if ($_neraca)
            return ResponseFormatter::success($arr, 'Data Laba rugi!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }
}
