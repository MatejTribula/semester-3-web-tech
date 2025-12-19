<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_index_view()
    {

        $response = $this->get('/');

        $response->assertStatus(302); // redirect status
        $response->assertRedirect('/products');

    }

    public function test_access_products_view_and_see_products()
    {
        $products = Product::factory()
            ->count(5)
            ->public()
            ->withImages(2)
            ->withVideos()
            ->withTags(5)
            ->withCollaborators(3)
            ->create();

        $response = $this->get('/products');

        $response->assertStatus(200); // redirect status
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');

        $products = $response->viewData('products');

        $this->assertCount(5, $products);

        // Loop through the products passed to the view to check values
        foreach ($products as $product) {
            $this->assertNotEmpty($product->title);
            $this->assertGreaterThan(0, $product->images->count());
            $this->assertGreaterThan(0, $product->videos->count());
            $this->assertGreaterThan(0, $product->tags->count());
            $this->assertGreaterThan(0, $product->collaborators->count());
        }

    }

    public function test_access_product_view_and_see_all_info()
    {
        $product = Product::factory()
            ->public()
            ->withImages(2)
            ->withVideos()
            ->withTags(5)
            ->withCollaborators(3)
            ->create();

        $response = $this->get("/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product');

        $product = $response->viewData('product');

        $this->assertNotEmpty($product);
        $this->assertNotEmpty($product->title);
        $this->assertGreaterThan(0, $product->images->count());
        $this->assertGreaterThan(0, $product->videos->count());
        $this->assertGreaterThan(0, $product->tags->count());
        $this->assertGreaterThan(0, $product->collaborators->count());

    }

    public function test_user_can_access_create_product_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/products/create');

        $response->assertStatus(200); // redirect status
        $response->assertViewIs('products.create');

    }

    public function test_guest_cannnot_access_create_product_view_and_is_redirected()
    {
        $response = $this->get('/products/create');

        $response->assertStatus(302); // redirect status
        $response->assertRedirect('/login'); // redirected to login page - default laravel behaviour

    }

    public function test_user_accesses_edit_page_of_owned_game()
    {
        // Arrange
        $user = User::factory()->create();

        $product = Product::factory()
            ->public()
            ->withImages(3)
            ->withVideos(2)
            ->create();

        $product->collaborators()->attach($user->id);

        // Act
        $response = $this->actingAs($user)->get("products/{$product->id}/edit");

        // Assert
        $response->assertStatus(200);

        $this->assertCount(1, $product->collaborators);

    }

    public function test_user_has_access_my_uploads_view_and_see_their_products()
    {
        $user = User::factory()->create();
        // $user2 = User::factory()->create();

        $products = Product::factory()
            ->count(5)
            ->public()
            ->withImages(2)
            ->withVideos()
            ->withTags(5)
            ->create();

        foreach ($products as $product) {
            $product->collaborators()->attach($user->id);
        }

        // for ($x = 0; $x <= 3; $x++) {
        //     $products[$x]->collaborators()->attach($user->id);
        // }

        // $products[4]->collaborators()->attach($user2->id);

        $response = $this->actingAs($user)->get('/my-uploads');
        // }

        $response->assertStatus(200);
        $response->assertViewIs('my-uploads');
        $response->assertViewHas('products');

        $products = $response->viewData('products');

        $this->assertCount(5, $products);

        // Loop through the products passed to the view to check values
        foreach ($products as $product) {
            $this->assertNotEmpty($product->title);
            $this->assertGreaterThan(0, $product->images->count());
            $this->assertGreaterThan(0, $product->videos->count());
            $this->assertGreaterThan(0, $product->tags->count());
            $this->assertGreaterThan(0, $product->collaborators->count());
        }

    }
}
