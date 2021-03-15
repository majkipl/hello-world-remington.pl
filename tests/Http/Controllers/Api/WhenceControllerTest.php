<?php

namespace Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Whence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class WhenceControllerTest extends TestCase
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
    public function it_response_http_forbidden_if_without_token_for_list_whence()
    {
        $response = $this->getJson(route('api.whence'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_whence()
    {
        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.whence') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_list_whence()
    {
        $whence = Whence::factory()->count(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $token = JWTAuth::fromUser($this->getUser());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('api.whence') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($whence->count(), 'rows');
    }

    /* add */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_whence()
    {
        $response = $this->postJson(route('api.whence.add'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_whence()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.whence.add'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_add_whence()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $whenceData = [
            'name' => $this->faker->word,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.whence.add'), $whenceData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('whences', $whenceData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_add_whence()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $invalidWhenceData = [];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->postJson(route('api.whence.add'), $invalidWhenceData);

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

        $this->assertDatabaseCount('whences', 0);
    }

    /* update */

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_whence()
    {
        $response = $this->putJson(route('api.whence.update'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_whence()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.whence.update'));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_update_whence()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $whence = Whence::factory()->create();

        $updateData = [
            'id' => $whence->id,
            'name' => $this->faker->word
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.whence.update'), $updateData);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertDatabaseHas('whences', $updateData);
    }

    /** @test */
    public function it_handles_unprocessable_entity_when_fails_to_update_whence()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $whence = Whence::factory()->create();

        $invalidUpdateData = [
            'id' => $whence->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('api.whence.update'), $invalidUpdateData);

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
    public function it_response_http_forbidden_if_without_token_for_delete_whence()
    {
        $whence = Whence::factory()->create();

        $response = $this->deleteJson(route('api.whence.delete', ['whence' => $whence->id]));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_whence()
    {
        $whence = Whence::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.whence.delete', ['whence' => $whence->id]));

        $response
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_delete_whence()
    {
        $token = JWTAuth::fromUser($this->getUser());

        $whence = Whence::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson(route('api.whence.delete', ['whence' => $whence->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'message' => 'Rekord został pomyślnie usunięty.',
            ]);

        $this->assertDatabaseMissing('whences', [
            'id' => $whence->id,
        ]);
    }
}
