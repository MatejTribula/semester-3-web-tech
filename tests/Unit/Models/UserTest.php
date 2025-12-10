<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_avatar_url_returns_default_when_null_or_empty(): void
    {
        $user = new User;

        // Null avatar
        $user->avatar_url = null;
        $this->assertStringContainsString('images/grey.png', $user->avatar_url);

        // Empty string avatar
        $user->avatar_url = '';
        $this->assertStringContainsString('images/grey.png', $user->avatar_url);

        // Route avatar
        $user->avatar_url = 'avatars/me.jpg';
        $this->assertStringContainsString('storage/avatars/me.jpg', $user->avatar_url);

        // Valid string avatar
        $user->avatar_url = 'https://example.com/avatar.png';
        $this->assertStringContainsString('https://example.com/avatar.png', $user->avatar_url);
    }
}
