<?php

namespace Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopControllerTest extends TestCase
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
    public function it_response_http_forbidden_if_without_token_for_list_shop()
    {
        $response = $this->getJson(route('api.shop'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_shop()
    {
        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.shop') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_list_shop()
    {
        $shop = Shop::factory()->count(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $token = JWTAuth::fromUser($this->getUser());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('api.shop') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($shop->count(), 'rows');
    }

    /* add */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_shop()
    {
        $response = $this->postJson(route('api.shop.add'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_shop()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.shop.add'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_add_shop()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $shopData = [
            'name' => $this->faker->word,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.shop.add'), $shopData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('shops', $shopData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_add_shop()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $invalidShopData = [];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.shop.add'), $invalidShopData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);

        $this->assertDatabaseCount('shops', 0);
    }

    /* update */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_shop()
    {
        $response = $this->putJson(route('api.shop.update'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_shop()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.shop.update'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_update_shop()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $shop = Shop::factory()->create();

        $updateData = [
            'id' => $shop->id,
            'name' => $this->faker->word
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.shop.update'), $updateData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('shops', $updateData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_update_shop()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $shop = Shop::factory()->create();

        $invalidUpdateData = [
            'id' => $shop->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.shop.update'), $invalidUpdateData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);
    }

    /* delete */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_shop()
    {
        $shop = Shop::factory()->create();

        $response = $this->deleteJson(route('api.shop.delete', ['shop' => $shop->id]));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_shop()
    {
        $shop = Shop::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.shop.delete', ['shop' => $shop->id]));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_delete_shop()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $shop = Shop::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(route('api.shop.delete', ['shop' => $shop->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'message' => 'Rekord został pomyślnie usunięty.',
            ]);

        $this->assertDatabaseMissing('shops', [
            'id' => $shop->id,
        ]);
    }
}
