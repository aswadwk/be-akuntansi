<?php

namespace Tests;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Division;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $user;
    public AccountType $accountType;
    public Account $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = $this->createUser();
    }

    public function createUser()
    {
        return User::create([
            'name' => 'hajaraswawd',
            'email' => 'hajaraswad@gmail.com',
            'password' => '$2y$10$QC.it5rWGgqPoIDFSEJBieAmtJEMl4cGeZhYw9mcmsB/hYRU8h5t2',
        ]);
    }

    public function login()
    {
        $this->postJson('/api/v1/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
    }

    public function createAccountType()
    {
        return AccountType::create([
            'code' => '123',
            'name' => 'Account Type 1',
            'user_id' =>  $this->user->id
        ]);
    }

    public function createAccount()
    {
        return Account::create([
            'code' => '123',
            'name' => 'Account 1',
            'account_type_id' => $this->accountType->id,
            'user_id' =>  $this->user->id
        ]);
    }

    public function createParner()
    {
        return Partner::create([
            'code' => '999999',
            'name' => 'Partner 1',
            'description' => 'Partner 1 description',
            'account_type' => 'HUTANG', // can be HUTANG or PIUTANG
            'user_id' =>  $this->user->id
        ]);
    }

    public function createDivision(){

        return Division::create([
            'code' => '999999',
            'name' => 'Division 1',
            'description' => 'Division 1 description',
            'user_id' =>  $this->user->id
        ]);
    }
}
