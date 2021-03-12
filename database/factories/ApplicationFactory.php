<?php

namespace Database\Factories;

use App\Enums\ShopType;
use App\Enums\Voivodeship;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Whence;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $whence = Whence::count() ? Whence::inRandomOrder()->first() : Whence::factory()->create();
        $product = Product::count() ? Product::inRandomOrder()->first() : Product::factory()->create();
        $shop = Shop::count() ? Shop::inRandomOrder()->first() : Shop::factory()->create();
        $voivodeship = Voivodeship::ALL[$this->faker->numberBetween(0, 15)];
        $shopType = ShopType::TYPES[$this->faker->numberBetween(0, 1)];

        $obj = [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'zip' => $this->faker->postcode,
            'voivodeship' => $voivodeship,
            'email' => $this->faker->email,
            'phone' => '+48' . $this->faker->numerify('#########'),
            'shop_type' => $shopType,
            'buyday' => $this->faker->dateTimeBetween('-1 month', 'now')->format('d-m-Y'),
            'number_receipt' => $this->faker->numerify('#########'),
            'img_receipt' => 'receipts/4MT6FqSmHfYM1ebXag3L8Ep1Cn212J9fuNj6uiLL.jpg',
            'img_ean' => 'ean/0W0Eid2st8sZo91N2bycxtzjBkE5KO6mzlOfvK4O.jpg',
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'whence_id' => $whence->id,
            'legal_4' => $this->faker->boolean,
            'legal_5' => $this->faker->boolean,
        ];

        return $obj;
    }
}
