<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'visibility_setting' => 'Public',
        ];
    }

    public function public()
    {
        return $this->state([
            'visibility_setting' => 'Public',
        ]);
    }

    public function private()
    {
        return $this->state([
            'visibility_setting' => 'Private',
        ]);
    }

    public function withImages(int $count = 3)
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            Image::factory()->count($count)->create([
                'product_id' => $product->id,
            ]);
        });
    }

    public function withVideos(int $count = 2)
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            Video::factory()->count($count)->create([
                'product_id' => $product->id,
            ]);
        });
    }

    public function withTags(int $count = 3)
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            Tag::factory()->count($count)->create([
                'product_id' => $product->id,
            ]);
        });
    }

    public function withCollaborators(int $count = 2)
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            $users = User::factory()->count($count)->create();
            $product->collaborators()->attach($users->pluck('id'));
        });
    }
}
