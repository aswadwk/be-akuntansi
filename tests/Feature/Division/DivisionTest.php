<?php

namespace Tests\Feature\Division;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DivisionTest extends TestCase
{
    use RefreshDatabase;

    // should return 401 if not authenticated
    // should return 200 with data if authenticated
    // should return 200 with data paginated if authenticated
    // should return 200 with all data if authenticated and all is true
    // should return 200 with 1 data if authenticated and id is set
    // should return 200 when successfully created a new division
    // should return 200 when successfully updated an division
    // should return 200 when successfully deleted an division

    /** @test */
    public function should_return_401_if_not_authenticated()
    {
        $response = $this->getJson('/api/v1/divisions');
        $response->assertStatus(401);
    }

    /** @test */
    public function should_return_200_with_data_if_authenticated()
    {
        $this->login();

        $response = $this->getJson('/api/v1/divisions');

        $response->assertStatus(200);
    }

    /** @test */
    public function should_return_200_with_data_paginated_if_authenticated()
    {
        $this->login();

        $this->createDivision();

        $response = $this->getJson('/api/v1/divisions?page=1&per_page=10');

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
    }

    /** @test */
    public function should_return_200_with_all_data_if_authenticated_and_all_is_true()
    {
        $this->login();

        $this->createDivision();

        $response = $this->getJson('/api/v1/divisions?all=1');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }

    /** @test */
    public function should_return_200_with_1_data_if_authenticated_and_id_is_set()
    {
        $this->login();

        $division = $this->createDivision();

        $response = $this->getJson('/api/v1/divisions/' . $division->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }

    /** @test */
    public function should_return_200_when_successfully_created_a_new_division()
    {
        $this->login();

        $response = $this->postJson('/api/v1/divisions', [
            'code' => '123',
            'name' => 'Division 1',
            'user_id' => $this->user->id,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }

    /** @test */
    public function should_return_200_when_successfully_updated_an_division()
    {
        $this->login();

        $division = $this->createDivision();

        $response = $this->putJson('/api/v1/divisions/' . $division->id, [
            'code' => '123',
            'name' => 'Division 1',
            'user_id' => $this->user->id,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }

    /** @test */
    public function should_return_200_when_successfully_deleted_an_division()
    {
        $this->login();

        $division = $this->createDivision();

        $response = $this->deleteJson('/api/v1/divisions/' . $division->id);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
    }
}
