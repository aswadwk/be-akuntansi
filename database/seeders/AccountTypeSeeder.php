<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all()->first();

        AccountType::create([
            'code'        => '111000',
            'name'        => 'Aktiva Lancar',
            'description' => 'Aktiva Lancar',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '112000',
            'name'        => 'Aktiva Tetap',
            'description' => 'Aktiva Tetap',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '211000',
            'name'        => 'Kewajiban',
            'description' => 'Kewajiban',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '311000',
            'name'        => 'Modal',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '411000',
            'name'        => 'Pendapatan',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '511000',
            'name'        => 'Biaya Atas Pendapatan',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '611000',
            'name'        => 'Biaya Operasional',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '711000',
            'name'        => 'Pendapatan Lainnya',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        AccountType::create([
            'code'        => '811000',
            'name'        => 'Biaya Lainnya',
            'description' => 'Modal',
            'user_id'     => $user->id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
