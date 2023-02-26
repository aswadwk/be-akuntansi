<?php

namespace Tests\Feature\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->accountType = $this->createAccountType();
        $this->account = $this->createAccount();
    }

    // should return 401 if not authenticated
    // should return 200 with data if authenticated
    // should return 200 with data paginated if authenticated
    // should return 200 with all data if authenticated and all is true
    // should return 200 with 1 data if authenticated and id is set
    // should return 200 when successfully created a new account
    // should return 200 when successfully updated an account
    // should return 200 when successfully deleted an account

    /** @test */
    public function should_return_401_if_not_authenticated()
    {
        $response = $this->getJson('/api/v1/accounts');
        $response->assertStatus(401);
    }

    /** @test */
    public function should_return_200_with_data_if_authenticated()
    {
        $this->login();

        $response = $this->getJson('/api/v1/accounts');

        $response->assertStatus(200);
    }

    /** @test */
    public function should_return_200_with_data_paginated_if_authenticated()
    {
        $this->login();

        $response = $this->getJson('/api/v1/accounts?page=1&per_page=10');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('current_page', $responseData['data']);
        $this->assertArrayHasKey('first_page_url', $responseData['data']);
        $this->assertArrayHasKey('from', $responseData['data']);
        $this->assertArrayHasKey('last_page', $responseData['data']);
        $this->assertArrayHasKey('last_page_url', $responseData['data']);
        $this->assertArrayHasKey('next_page_url', $responseData['data']);
        $this->assertArrayHasKey('path', $responseData['data']);
    }

    /** @test */
    public function should_return_200_with_all_data_if_authenticated_and_all_is_true()
    {
        $this->login();

        $response = $this->getJson('/api/v1/accounts?all=true');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }

    /** @test */
    public function should_return_200_with_1_data_if_authenticated_and_id_is_set()
    {
        $this->login();

        $accounType = $this->createAccountType();

        $account = $this->createAccount();

        $response = $this->getJson('/api/v1/accounts/'.$account->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        $this->assertArrayHasKey('id', $responseData['data']);
        $this->assertArrayHasKey('code', $responseData['data']);
        $this->assertArrayHasKey('name', $responseData['data']);
        $this->assertArrayHasKey('created_at', $responseData['data']);
        $this->assertArrayHasKey('updated_at', $responseData['data']);

        $this->assertEquals($account->id, $responseData['data']['id']);
        $this->assertEquals($account->code, $responseData['data']['code']);
    }

    /** @test */
    public function should_return_200_when_successfully_created_a_new_account()
    {
        $this->login();

        $response = $this->postJson('/api/v1/accounts', [
            'code' => '9999999',
            'name' => 'test',
            'account_type_id' => $this->accountType->id,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        $this->assertArrayHasKey('id', $responseData['data']);
        $this->assertArrayHasKey('code', $responseData['data']);
        $this->assertArrayHasKey('name', $responseData['data']);
        $this->assertArrayHasKey('created_at', $responseData['data']);
        $this->assertArrayHasKey('updated_at', $responseData['data']);

        $this->assertEquals('9999999', $responseData['data']['code']);
        $this->assertEquals('test', $responseData['data']['name']);
    }

    /** @test */
    public function should_return_200_when_successfully_updated_an_account()
    {
        $this->login();

        $response = $this->putJson('/api/v1/accounts/'.$this->account->id, [
            'code' => '9999999',
            'name' => 'test',
            'account_type_id' => $this->accountType->id,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals($responseData['status'], true);
        $this->assertEquals($responseData['message'], 'Akun berhasil di update');
    }

    /** @test */
    public function should_return_200_when_successfully_deleted_an_account()
    {
        $this->login();

        $response = $this->deleteJson('/api/v1/accounts/'.$this->account->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);

        $this->assertArrayHasKey('id', $responseData['data']);
        $this->assertArrayHasKey('code', $responseData['data']);
        $this->assertArrayHasKey('name', $responseData['data']);
        $this->assertArrayHasKey('created_at', $responseData['data']);
        $this->assertArrayHasKey('updated_at', $responseData['data']);

        $this->assertEquals($this->account->id, $responseData['data']['id']);
        $this->assertEquals($this->account->code, $responseData['data']['code']);
    }
}
