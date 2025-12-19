<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_return_profile_page_of_a_user(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/profile/{$user->id}");

        $response->assertOK();
        $response->assertViewHas('user');
        $response->assertViewHas('products');
    }
}
