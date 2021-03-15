<?php

namespace Http\Requests\Api;

use App\Http\Requests\Api\UpdateLinkRequest;
use App\Models\Link;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\Feature\Api\Validation\ValidationTestCase;
use Illuminate\Support\Facades\Validator;

class UpdateLinkRequestTest extends ValidationTestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @param array $arr
     * @param array $without
     * @return array
     */
    public function getData(array $arr = [], array $without = []): array
    {
        $link = Link::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'url' => $this->faker->text(128),
            'product_id' => $product->id,
            'id' => $link->id
        ];

        foreach ($without as $item) {
            if (array_key_exists($item, $data)) {
                unset($data[$item]);
            }
        }

        return array_merge($data, $arr);
    }

    /** @test */
    public function validation_pass_for_valid_data()
    {
        $data = $this->getData();

        $validator = Validator::make($data, (new UpdateLinkRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_url_is_missing()
    {
        $data = $this->getData([], ['url']);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_url_is_not_string()
    {
        $data = $this->getData([
            'url' => $this->faker->numberBetween(1, 128)
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_url_is_exceeds_max_length()
    {
        $data = $this->getData([
            'url' => Str::random(513)
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_product_id_is_missing()
    {
        $data = $this->getData([], ['product_id']);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_product_id_is_not_integer()
    {
        $data = $this->getData([
            'product_id' => $this->faker->word
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_product_id_is_not_exist_in_database()
    {
        $data = $this->getData([
            'product_id' => 999
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_id_is_missing()
    {
        $data = $this->getData([], ['id']);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_id_is_not_integer()
    {
        $data = $this->getData([
            'id' => $this->faker->word
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }

    /** @test */
    public function validation_fails_if_id_is_not_exist_in_database()
    {
        $data = $this->getData([
            'id' => 999
        ]);

        $this->expectValidationException($data, UpdateLinkRequest::class);
    }
}
