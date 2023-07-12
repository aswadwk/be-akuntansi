<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProfitLossAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function buku_besar(Request $request, $id)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        // $bukuBesar = DB::select("SELECT
        // a.`name`,
        // j.date,
        // j.description,
        // at.position_normal,
        // CASE
        //         WHEN j.type = 'D' THEN
        //         j.amount ELSE 0
        //     END AS DEBET,
        // CASE
        //         WHEN j.type = 'C' THEN
        //         j.amount ELSE 0
        //     END AS CREDIT
        // FROM
        //     journals AS j
        //     INNER JOIN accounts AS a ON j.account_id = a.id
        //     INNER JOIN account_types AS at ON a.account_type_id = at.id
        // WHERE
        //     j.account_id = '$id'
        //     AND j.deleted_at IS NULL AND j.date BETWEEN '$request->from' AND '$request->to' order by j.date desc");

        // $saldo = 0;
        // foreach ($bukuBesar as $a) {
        //     $a->diffHuman = date('d/m/Y', strtotime($a->date));
        //     if ($a->position_normal === "D") {
        //         $saldo += $a->DEBET - $a->CREDIT;
        //         $a->saldo = $saldo;
        //     } else {
        //         $saldo +=  $a->CREDIT - $a->DEBET;
        //         $a->saldo = $saldo;
        //     }
        // }

        $bukuBesar = DB::table('journals')
            ->select(
                'accounts.name',
                'journals.date',
                'journals.description',
                'account_types.position_normal',
                DB::raw("CASE WHEN journals.type = 'D' THEN journals.amount ELSE 0 END AS DEBET"),
                DB::raw("CASE WHEN journals.type = 'C' THEN journals.amount ELSE 0 END AS CREDIT")
            )
            ->join('accounts', 'journals.account_id', '=', 'accounts.id')
            ->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')
            ->where('journals.account_id', $id)
            ->whereNull('journals.deleted_at')
            ->whereBetween('journals.date', [$request->from, $request->to])
            ->orderBy('journals.date', 'asc')
            ->get();

        $saldo = 0;
        foreach ($bukuBesar as $a) {
            $a->diffHuman = date('d/m/Y', strtotime($a->date));
            $a->DEBET += 0;
            $a->CREDIT += 0;
            if ($a->position_normal === 'D') {
                $saldo += $a->DEBET - $a->CREDIT;
            } else {
                $saldo += $a->CREDIT - $a->DEBET;
            }
            $a->saldo = $saldo;
        }

        // foreach ($bukuBesar as $a) {
        //     $a->DEBET = number_format($a->DEBET, 2, ',', '.');
        //     $a->CREDIT = number_format($a->CREDIT, 2, ',', '.');
        //     $a->saldo = number_format($a->saldo, 2, ',', '.');
        // }


        if ($bukuBesar)
            return ResponseFormatter::success($bukuBesar, 'Data Buku Besar!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }

    public function neraca_lajur(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        // $profitLossAccountIds = DB::select("SELECT account_type_id FROM profit_loss_accounts WHERE deleted_at IS NULL");
        // dd($profitLossAccountIds);

        $_neraca_lajur =  DB::select("SELECT a.id, a.name, a.code, j.type, j.amount,
        SUM(
            CASE WHEN j.type = 'D' THEN j.amount ELSE 0
        END
        ) AS DEBET,
        SUM(
            CASE WHEN j.type = 'C' THEN j.amount ELSE 0
        END
        ) AS CREDIT,
        CASE WHEN j.account_id IN(
            SELECT id FROM accounts WHERE account_type_id IN(SELECT account_type_id FROM profit_loss_accounts WHERE deleted_at IS NULL)
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
            a.id = j.account_id WHERE j.deleted_at IS NULL AND j.date BETWEEN '$request->from' AND '$request->to'
        GROUP BY
            a.id");

        // dd($_neraca_lajur);

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

        // dd($_neraca_lajur);

        if ($_neraca_lajur)
            return ResponseFormatter::success($_neraca_lajur, 'Data Neraca Lajur!!!');
        else
            return ResponseFormatter::error('error', 'Data Tidak di temukan', 404);
    }

    public function buku_pembantu($id)
    {

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
        INNER JOIN partners AS p
        ON
            j.partners_id = p.id
        WHERE
            j.partners_id IS NOT NULL
            AND j.deleted_at IS NULL
            AND p.id = '$id'
            AND j.account_id IN(
            SELECT id
            FROM accounts
            WHERE account_type_id = '113000' OR account_type_id = '211000'
        )");

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
            CASE WHEN j.type = 'D' AND j.date BETWEEN '$request->from' AND '$request->to' THEN j.amount ELSE 0
        END
        ) AS DEBET,
        SUM(
            CASE WHEN j.type = 'C' AND j.date BETWEEN '$request->from' AND '$request->to' THEN j.amount ELSE 0
        END
        ) AS CREDIT
        FROM
            accounts AS a
        INNER JOIN journals AS j
        ON
            a.id = j.account_id
        RIGHT JOIN account_types AS AT
        ON
            a.account_type_id = AT.id WHERE
                a.account_type_id != '410'   #Kas
                or a.account_type_id != '510' #Bank
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

        AND j.deleted_at IS NULL AND j.date BETWEEN '$request->from' AND '$request->to'

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
            return ResponseFormatter::success($arr, 'Data Partners!!!');
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
}
