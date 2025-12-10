<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_avatar_url_is_set_to_default(): void
    {
        // Arrange

        $user = User::factory()->create([
            'avatar_url' => null,
        ]);

        // Act
        $avatarUrl = $user->avatar_url;

        // Assert
        $this->assertStringContainsString('images/grey.png', $avatarUrl);

    }

    public function test_user_avatar_url_null(): void
    {
        // Arrange

        $user = User::factory()->create([
            'avatar_url' => null,
        ]);

        // Act
        $avatarUrl = $user->avatar_url;

        // Assert
        $this->assertStringContainsString('images/grey.png', $avatarUrl);

    }

    public function test_user_avatar_url_is_url(): void
    {
        // Arrange

        $user = User::factory()->create([
            'avatar_url' => 'https://example.com/api/images/1',
        ]);

        // Act
        $avatarUrl = $user->avatar_url;

        // Assert
        $this->assertStringContainsString('https://example.com/api/images/1', $avatarUrl);

    }
}
