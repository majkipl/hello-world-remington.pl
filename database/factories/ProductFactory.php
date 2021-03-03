<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numerify('S####'),
            'name' => $this->faker->firstName,
            'text' => $this->faker->paragraph
        ];
    }
}
