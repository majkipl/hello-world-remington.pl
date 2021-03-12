<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::count() ? Product::inRandomOrder()->first() : Product::factory()->create();

        return [
            'url' => $this->faker->url,
            'product_id' => $product->id
        ];
    }
}
