<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_login_successfully()
    {
        // Arrange
        User::factory()->create([
            'email' => 'aswad@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Act
        $this->post('/api/v1/login', [
            'email' => 'aswad@gmail.com',
            'password' => 'password',
        ])
            // Assert
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data' => [
                    'token_type',
                    'access_token',
                    'expires_in',
                ]
            ]);
    }

    public function test_credential_invalid()
    {
        // Act
        $this->post('/api/v1/login', [
            'email' => 'xxx@gmail.com',
            'password' => 'xxxxxxxx',
        ])
            // Assert
            ->assertStatus(401)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
                'data',
            ])
            ->assertJson([
                'status' => false,
                'message' => 'Unauthentication',
            ]);
    }
}
