<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'product_id' => null, // will be set by ProductFactory
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
