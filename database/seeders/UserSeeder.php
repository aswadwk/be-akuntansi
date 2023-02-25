<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => 'Aswad',
            'email'    => 'aswad@gmail.com',
            'password' => '$2y$10$QC.it5rWGgqPoIDFSEJBieAmtJEMl4cGeZhYw9mcmsB/hYRU8h5t2',
        ]);

        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => '$2y$10$QC.it5rWGgqPoIDFSEJBieAmtJEMl4cGeZhYw9mcmsB/hYRU8h5t2',
        ]);
    }
}
