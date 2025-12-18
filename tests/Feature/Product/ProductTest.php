<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_and_store_new_product()
    {

        $user = User::factory()->create();

        $payload = [
            'title' => 'Nebula Raiders',
            'logo' => 'https://cdn.example.com/logos/nebula-raiders.png',
            'description' => 'Nebula Raiders is a fast-paced sci-fi action game where players explore abandoned galaxies and battle rogue AI fleets.',
            'upload_date' => '2025-12-01',
            'approval_date' => '2025-12-05',
            'visibility_setting' => 'Public',
            'file_url' => 'https://downloads.example.com/games/nebula-raiders-v1.0.zip',
            'cover_url' => 'https://cdn.example.com/covers/nebula-raiders-cover.jpg',
            'images' => [
                'https://cdn.example.com/screenshots/nebula-raiders-1.jpg',
                'https://cdn.example.com/screenshots/nebula-raiders-2.jpg',
            ],
            'videos' => [
                'https://www.youtube.com/watch?v=exampleTrailer1',
            ],
            'tags' => [
                'SciFi',
                'Action',
                'Indie',
            ],
            // Ensure these user IDs exist in your test database
            'collaborators' => [$user->id],
        ];

        $response = $this->actingAs($user)->post('/products', $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('products');
        $this->assertDatabaseHas('images');
        $this->assertDatabaseHas('videos');
        $this->assertDatabaseHas('tags');
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('images', 1 + 2); // cover + 2 inages
        $this->assertDatabaseCount('videos', 1);
        $this->assertDatabaseCount('tags', 3);

        $this->assertDatabaseHas('products', [
            'title' => 'Nebula Raiders',
        ]);

    }

    public function test_create_and_store_new_product_with_all_nullable_fields_empty()
    {

        $user = User::factory()->create();

        $payload = [
            'title' => 'Nebula Raiders',
            'visibility_setting' => 'Public',
            'file_url' => 'https://downloads.example.com/games/nebula-raiders-v1.0.zip',
            'cover_url' => 'https://cdn.example.com/covers/nebula-raiders-cover.jpg',
        ];

        $response = $this->actingAs($user)->post('/products', $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('products');
        $this->assertDatabaseHas('images');
        $this->assertDatabaseMissing('videos');
        $this->assertDatabaseMissing('tags');

        $this->assertDatabaseHas('products', [
            'title' => 'Nebula Raiders',
        ]);

    }

    public function test_user_fails_to_create_and_store_product_with_bad_request_with_title_missing()
    {

        $user = User::factory()->create();

        $payload = [
            'visibility_setting' => 'Public',
            'file_url' => 'https://downloads.example.com/games/nebula-raiders-v1.0.zip',
            'cover_url' => 'https://cdn.example.com/covers/nebula-raiders-cover.jpg',
        ];

        $response = $this->actingAs($user)->post('/products', $payload);

        $response->assertRedirect();
        $this->assertDatabaseMissing('products');
        $this->assertDatabaseMissing('images');
        $this->assertDatabaseMissing('videos');
        $this->assertDatabaseMissing('tags');
    }

    public function test_user_fails_to_create_and_store_product_with_empty_request()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', []);

        $response->assertRedirect();
        $this->assertDatabaseMissing('products');
        $this->assertDatabaseMissing('images');
        $this->assertDatabaseMissing('videos');
        $this->assertDatabaseMissing('tags');
    }

    public function test_update_product()
    {
        $user = User::factory()->create();

        $product = Product::factory()
            ->public()
            ->withImages(10)
            ->withVideos(2)
            ->create();

        $product->collaborators()->attach($user->id);

        $payload = [
            'title' => 'Moon Raiders',
            'logo' => 'https://cdn.example.com/logos/nebula-raiders.png',
            'description' => 'Nebula Raiders is a fast-paced sci-fi action game where players explore abandoned galaxies and battle rogue AI fleets.',
            'upload_date' => '2025-12-01',
            'approval_date' => '2025-12-05',
            'visibility_setting' => 'Public',
            'file_url' => 'https://downloads.example.com/games/nebula-raiders-v1.0.zip',
            'cover_url' => 'https://cdn.example.com/covers/nebula-raiders-cover.jpg',
            'images' => [
                'https://cdn.example.com/screenshots/nebula-raiders-1.jpg',
                'https://cdn.example.com/screenshots/nebula-raiders-2.jpg',
            ],
            'videos' => [
                'https://www.youtube.com/watch?v=exampleTrailer1',
            ],
            'tags' => [
                'SciFi',
                'Action',
                'Indie',
            ],
            // Ensure these user IDs exist in your test database
            'collaborators' => [$user->id],
        ];

        $product->collaborators()->attach($user->id);

        $response = $this->actingAs($user)->put("products/{$product->id}", $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('products');
        $this->assertDatabaseHas('images');
        $this->assertDatabaseHas('videos');
        $this->assertDatabaseHas('tags');
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('images', 1 + 2); // cover + 2 inages
        $this->assertDatabaseCount('videos', 1);
        $this->assertDatabaseCount('tags', 3);

        $this->assertDatabaseHas('products', [
            'title' => 'Moon Raiders',
        ]);
    }

    // public function test_destroy_product() {}

    /**
     * A basic feature test example.
     */
    public function test_remove_product_from_the_database_with_all_relevant_data(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()
            ->public()
            ->withImages(10)
            ->withVideos(2)
            ->create();

        $product->collaborators()->attach($user->id);

        $response = $this->actingAs($user)->delete("/products/{$product->id}");
        //
        $response->assertRedirect();
        $this->assertDatabaseMissing('products');
        $this->assertDatabaseMissing('images');
        $this->assertDatabaseMissing('videos');
        $this->assertDatabaseMissing('tags');
    }
}
