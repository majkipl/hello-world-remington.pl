<?php

namespace Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Link;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function getUser()
    {
        return User::factory()->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /* index */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_link()
    {
        $response = $this->getJson(route('api.link'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_link()
    {
        $queryParams = [
            'searchable' => ['id', 'url'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.link') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_list_link()
    {
        $link = Link::factory()->count(5)->create();

        $queryParams = [
            'searchable' => ['id', 'url'],
        ];

        $token = JWTAuth::fromUser($this->getUser());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('api.link') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($link->count(), 'rows');
    }

    /* add */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_link()
    {
        $response = $this->postJson(route('api.link.add'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_link()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.link.add'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_add_link()
    {
        $token = JWTAuth::fromUser($this->getUser());
        $product = Product::factory()->create();

        $linkData = [
            'url' => 'https://example.com',
            'product_id' => $product->id
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.link.add'), $linkData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('links', [
            'url' => 'https://example.com',
            'product_id' => $product->id
        ]);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_add_link()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $invalidLinkData = [];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.link.add'), $invalidLinkData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'url' => [
                        'Pole jest wymagane.',
                    ],
                    'product_id' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);

        $this->assertDatabaseCount('links', 0);
    }

    /* update */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_link()
    {
        $response = $this->putJson(route('api.link.update'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_link()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.link.update'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_update_link()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $link = Link::factory()->create();

        $updateData = [
            'id' => $link->id,
            'url' => 'https://updated-example.com',
            'product_id' => $link->product_id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.link.update'), $updateData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'url' => 'https://updated-example.com',
            'product_id' => $link->product_id
        ]);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_update_link()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $link = Link::factory()->create();

        $invalidUpdateData = [
            'id' => $link->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.link.update'), $invalidUpdateData);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'url' => [
                        'Pole jest wymagane.',
                    ],
                    'product_id' => [
                        'Pole jest wymagane.',
                    ],
                ],
            ]);
    }

    /* delete */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_link()
    {
        $link = Link::factory()->create();

        $response = $this->deleteJson(route('api.link.delete', ['link' => $link->id]));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_link()
    {
        $link = Link::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.link.delete', ['link' => $link->id]));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_delete_link()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $link = Link::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(route('api.link.delete', ['link' => $link->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'message' => 'Rekord został pomyślnie usunięty.',
            ]);

        $this->assertDatabaseMissing('links', [
            'id' => $link->id,
        ]);
    }
}
