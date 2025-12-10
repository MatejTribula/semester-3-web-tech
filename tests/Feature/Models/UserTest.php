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
    public function test_user_avatar_url_is_set_to_default()
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

    public function test_user_avatar_url_null()
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

    public function test_user_avatar_url_is_url()
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

    // edge case
    public function test_user_avatar_url_empty_string_defaults()
    {
        // Arrange
        $user = User::factory()->create([
            'avatar_url' => '',
        ]);

        // Act
        $avatarUrl = $user->avatar_url;

        // Assert
        $this->assertStringContainsString('images/grey.png', $avatarUrl);
    }

    // fail case
    public function test_user_avatar_url_fails_with_array(): void
    {

        // Arrange

        // expect the exception
        $this->expectException(\Illuminate\Database\QueryException::class);

        // Act
        User::factory()->create([
            'avatar_url' => ['invalid', 'array'],
        ]);

        // Assert
        // if there was an exception related to query it passed
    }
}
