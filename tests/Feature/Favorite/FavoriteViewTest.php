<?php

namespace Tests\Feature\Favorite;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_is_able_to_access_favorite_page_and_see_favorite_products(): void
    {
        $user = User::factory()->create();

        $products = Product::factory()
            ->count(5)
            ->public()
            ->withImages(2)
            ->withVideos()
            ->withTags(5)
            ->withCollaborators(3)
            ->create();

        foreach ($products as $product) {
            Favorite::factory()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        $response = $this->actingAs($user)->get('/favorites');
        $response->assertOk();

        $this->assertDatabaseHas('favorites');
        $this->assertDatabaseCount('favorites', 5);

        foreach ($products as $product) {
            $this->assertDatabaseHas('products', [
                'id' => $product->id,
            ]);
        }

        $response->assertViewIs('favorites');
        $response->assertViewHas('products', function ($products) {
            return $products->count() === 5;
        });

        foreach ($products as $product) {
            $this->assertNotEmpty($product->title);
            $this->assertGreaterThan(0, $product->images->count());
            $this->assertGreaterThan(0, $product->videos->count());
            $this->assertGreaterThan(0, $product->tags->count());
            $this->assertGreaterThan(0, $product->collaborators->count());
        }

    }

    public function test_user_is_able_to_access_favorite_page_but_has_no_favorites(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            Favorite::factory()->create([]);
        }

        $response = $this->actingAs($user)->get('/favorites');
        $response->assertOk();

        $response->assertViewIs('favorites');

        $response->assertViewHas('products', function ($productsFromView) {
            return $productsFromView->isEmpty();
        });
    }
}
