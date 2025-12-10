<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_existing_user_can_login(): void
    {
        // Arrange
        // auth()->logout();
        $user = User::factory()->create([
            'password' => Hash::make('secret123'),
        ]);

        // Act

        $response = $this->post('/login',
            [
                'email' => $user->email,
                'password' => 'secret123',
            ]);

        // Assert
        $response->assertStatus(302); // redirect response
        $response->assertRedirect('/products');

        $this->assertAuthenticated();

    }

    public function test_guest_can_access_login_page()
    {
        // Arrange
        // auth()->logout();

        // Act
        $response = $this->get('/login');

        // Assert
        $response->assertStatus(200); // GET OK
        $response->assertViewIs('auth.login');

    }

    // fail case
    public function test_user_cannot_access_login_page()
    {
        // Arrange
        // auth()->logout();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->get('/login');

        // Assert
        $response->assertStatus(302); // redirect
        $response->assertRedirect('/products');

    }
}
