<?php

namespace Tests\Feature\Favorite;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_adds_a_product_to_favorites(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/products/{$product->id}/favorite");

        $response->assertOk();

        $this->assertDatabaseHas('products');
        $this->assertDatabaseHas('favorites');
        $this->assertDatabaseCount('favorites', 1);
        $this->assertDatabaseHas('favorites', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

    }

    public function test_user_fails_to_add_nonexistent_product_to_favorites(): void
    {
        $user = User::factory()->create();
        $fakeProductId = 123213;

        $response = $this->actingAs($user)->post("/products/{$fakeProductId}/favorite");

        $response->assertNotFound();
        $this->assertDatabaseMissing('favorites');
    }

    public function test_guest_fails_to_add_item_to_favorites_and_is_redirected()
    {
        $product = Product::factory()->create();

        $response = $this->post("/products/{$product->id}/favorite");

        $response->assertRedirect();
        $this->assertDatabaseMissing('favorites');
    }

    public function test_user_removes_product_from_favorites()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Favorite::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/products/{$product->id}/favorite");
        $response->assertOk();
    }
}
