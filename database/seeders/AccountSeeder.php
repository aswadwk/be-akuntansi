<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all()->first();

        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111000',
            'name'            => 'Aktiva Lancar',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111001',
            'name'            => 'Kas Rupiah',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111002',
            'name'            => 'Saldo Tokopedia',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111003',
            'name'            => 'Saldo Flip',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111004',
            'name'            => 'Saldo Link Aja',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111005',
            'name'            => 'Bank BRI',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '111000')->first();
        Account::create([
            'code'            => '111006',
            'name'            => 'Piutang Usaha',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112000',
            'name'            => 'Aktiva Tetap',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112001',
            'name'            => 'Tanah',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112002',
            'name'            => 'Bagunan',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112003',
            'name'            => 'Kendaraan',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112004',
            'name'            => 'Mesin dan Perlatan',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112005',
            'name'            => 'Perabot atau Mebel',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
        $accountType = AccountType::where('code', '112000')->first();
        Account::create([
            'code'            => '112006',
            'name'            => 'Akumulasi Penyusutan',
            'account_type_id' => $accountType->id,
            'position_normal' => $accountType->position_normal,
            'created_by'         => $user->id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
