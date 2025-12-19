<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_update_nicnkame_and_avatar(): void
    {
        $user = User::factory()->create();

        $avatar = UploadedFile::fake()->image('newAvatar.jpg');

        $payload = [
            'nickname' => 'new nick',
            'avatar' => $avatar,
        ];

        $response = $this->actingAs($user)->put("/profile/{$user->id}", $payload);

        $response->assertOk();

        $storedPath = 'avatars/'.$avatar->hashName();

        Storage::disk('public')->assertExists($storedPath);

        $this->assertDatabaseHas('users', [
            'nickname' => 'new nick',
            'avatar_url' => $storedPath,
        ]);
    }

    public function test_user_fails_to_change_other_user_nicnkame_and_avatar(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $avatar = UploadedFile::fake()->image('newAvatar.jpg');

        $payload = [
            'nickname' => 'new nick',
            'avatar' => $avatar,
        ];

        $response = $this->actingAs($user)->put("/profile/{$otherUser->id}", $payload);

        $response->assertForbidden();
    }

    public function test_guest_fails_to_change_other_user_nicnkame_and_avatar_and_is_redirected(): void
    {
        $otherUser = User::factory()->create();

        $avatar = UploadedFile::fake()->image('newAvatar.jpg');

        $payload = [
            'nickname' => 'new nick',
            'avatar' => $avatar,
        ];

        $response = $this->put("/profile/{$otherUser->id}", $payload);

        $response->assertRedirect();
    }
}
