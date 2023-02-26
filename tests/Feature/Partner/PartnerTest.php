<?php

namespace Tests\Feature\Partner;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->getJson('/api/v1/partners');
        $response->assertStatus(401);
    }

    /** @test */
    public function should_return_200_with_data_if_authenticated()
    {
        $this->login();

        $response = $this->getJson('/api/v1/partners');

        $response->assertStatus(200);
    }

    /** @test */
    public function should_return_200_with_data_paginated_if_authenticated()
    {
        $this->login();

        $response = $this->getJson('/api/v1/partners?page=1&per_page=10');

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
        $this->assertArrayHasKey('per_page', $responseData['data']);
        $this->assertArrayHasKey('prev_page_url', $responseData['data']);
        $this->assertArrayHasKey('to', $responseData['data']);
        $this->assertArrayHasKey('total', $responseData['data']);
    }

    /** @test */
    public function should_return_200_with_all_data_if_authenticated_and_all_is_true()
    {
        $this->login();

        $this->createParner();

        $response = $this->getJson('/api/v1/partners?all=1');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertNotEmpty($responseData['data']);
        $this->assertNotEmpty($responseData['data'][0]);
    }

    /** @test */
    public function should_return_200_with_1_data_if_authenticated_and_id_is_set()
    {
        $this->login();

        $partner = $this->createParner();

        $response = $this->getJson('/api/v1/partners/' . $partner->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertNotEmpty($responseData['data']);
        $this->assertNotEmpty($responseData['data']['id']);
        $this->assertNotEmpty($responseData['data']['name']);

    }

    /** @test */
    public function should_return_200_when_successfully_created_a_new_partner()
    {
        $this->login();

        $response = $this->postJson('/api/v1/partners', [
            'name' => 'Partner 1',
            'code' => '999999',
            'account_type' => 'PIUTANG',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertNotEmpty($responseData['data']);
        $this->assertNotEmpty($responseData['data']['id']);
        $this->assertNotEmpty($responseData['data']['name']);
    }

    /** @test */
    public function should_return_200_when_successfully_updated_an_partner()
    {
        $this->login();

        $partner = $this->createParner();

        $response = $this->putJson('/api/v1/partners/' . $partner->id, [
            'name' => 'Partner 1',
            'code' => '99999999',
            'account_type' => 'PIUTANG',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertNotEmpty($responseData['data']);

        $this->assertEquals($responseData['status'], true);
        $this->assertEquals($responseData['message'], 'Partner berhasil diubah.');
    }

    /** @test */
    public function should_return_200_when_successfully_deleted_an_partner()
    {
        $this->login();

        $partner = $this->createParner();

        $response = $this->deleteJson('/api/v1/partners/' . $partner->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertNotEmpty($responseData['data']);
        $this->assertNotEmpty($responseData['data']['id']);
        $this->assertNotEmpty($responseData['data']['name']);
    }
}
