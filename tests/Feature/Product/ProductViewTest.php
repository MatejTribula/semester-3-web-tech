<?php

namespace Tests\Feature\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductViewTest extends TestCase
{
    use RefreshDatabase;

    // private $user;

    // protected function setUp(): void
    // {
    //     $this->user = User::factory()->create();
    // }

    public function test_access_index_view()
    {
        $response = $this->get('/');

        $response->assertStatus(302); // redirect status
        $response->assertRedirect('/products');

    }

    public function test_access_prodcuts_view()
    {
        $response = $this->get('/products');

        $response->assertStatus(200); // redirect status
        $response->assertViewIs('products.index');

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

    // public function test_user_accesses_edit_page_of_owned_game()
    // {
    //     $user = User::factory()->create();

    //     // need to have all other stuff working to make sure rest works

    // }
}
