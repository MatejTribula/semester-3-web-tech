<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_register_new_user_and_login(): void
    {
        // Arrange
        // auth()->logout();

        // Act

        $response = $this->post('/register', [
            'nickname' => 'test',
            'email' => 'test@test.test',
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);

        // Assert
        $response->assertStatus(302); // redirect response
        $response->assertRedirect('/products');

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'nickname' => 'test',
            'email' => 'test@test.test',
        ]);

    }

    public function test_guest_can_access_register_page()
    {
        // Arrange
        // auth()->logout();

        // Act
        $response = $this->get('/register');

        // Assert
        $response->assertStatus(200); // GET OK
        $response->assertViewIs('auth.register');

    }

    // fail case
    public function test_user_cannot_access_register_page()
    {
        // Arrange
        // auth()->logout();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/register');

        // Assert
        $response->assertStatus(302); // redirect
        $response->assertRedirect('/products');

    }
}
