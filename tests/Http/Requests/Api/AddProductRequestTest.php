<?php

namespace Http\Requests\Api;

use App\Http\Requests\Api\AddProductRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\Feature\Api\Validation\ValidationTestCase;
use Illuminate\Support\Facades\Validator;

class AddProductRequestTest extends ValidationTestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @param array $arr
     * @param array $without
     * @return array
     */
    public function getData(array $arr = [], array $without = []): array
    {
        $data = [
            'code' => $this->faker->numerify('S####'),
            'name' => $this->faker->text(128),
            'text' => $this->faker->text(4096),
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

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_code_is_missing()
    {
        $data = $this->getData([], ['code']);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_code_is_not_string()
    {
        $data = $this->getData([
            'code' => $this->faker->numberBetween(1, 128)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_code_is_exceeds_max_length()
    {
        $data = $this->getData([
            'code' => Str::random(6)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_missing()
    {
        $data = $this->getData([], ['name']);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_not_string()
    {
        $data = $this->getData([
            'name' => $this->faker->numberBetween(1, 128)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_exceeds_max_length()
    {
        $data = $this->getData([
            'name' => Str::random(129)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_text_is_missing()
    {
        $data = $this->getData([], ['text']);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_text_is_not_string()
    {
        $data = $this->getData([
            'text' => $this->faker->numberBetween(1, 4096)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }

    /** @test */
    public function validation_fails_if_text_is_exceeds_max_length()
    {
        $data = $this->getData([
            'text' => Str::random(4097)
        ]);

        $this->expectValidationException($data, AddProductRequest::class);
    }
}
