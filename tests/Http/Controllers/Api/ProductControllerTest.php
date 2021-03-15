<?php

namespace Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function getUser()
    {
        return User::factory()->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /* index */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_product()
    {
        $response = $this->getJson(route('api.product'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_product()
    {
        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.product') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_list_product()
    {
        $product = Product::factory()->count(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $token = JWTAuth::fromUser($this->getUser());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('api.product') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($product->count(), 'rows');
    }

    /* add */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_product()
    {
        $response = $this->postJson(route('api.product.add'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_product()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.product.add'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_add_product()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $productData = [
            'name' => $this->faker->word,
            'code' => $this->faker->numerify('S####'),
            'text' => $this->faker->text('4096'),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.product.add'), $productData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_add_product()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $invalidProductData = [];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.product.add'), $invalidProductData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'Pole jest wymagane.',
                    ],
                    'name' => [
                        'Pole jest wymagane.',
                    ],
                    'text' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);

        $this->assertDatabaseCount('products', 0);
    }

    /* update */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_product()
    {
        $response = $this->putJson(route('api.product.update'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_product()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.product.update'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_update_product()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $product = Product::factory()->create();

        $updateData = [
            'id' => $product->id,
            'name' => $this->faker->word,
            'code' => $this->faker->numerify('S####'),
            'text' => $this->faker->text('4096'),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.product.update'), $updateData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('products', $updateData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_update_product()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $product = Product::factory()->create();

        $invalidUpdateData = [
            'id' => $product->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.product.update'), $invalidUpdateData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'code' => [
                        'Pole jest wymagane.',
                    ],
                    'name' => [
                        'Pole jest wymagane.',
                    ],
                    'text' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);
    }

    /* delete */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.product.delete', ['product' => $product->id]));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.product.delete', ['product' => $product->id]));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_delete_product()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(route('api.product.delete', ['product' => $product->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'message' => 'Rekord został pomyślnie usunięty.',
            ]);

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
