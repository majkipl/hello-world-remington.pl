<?php

namespace Tests\Feature\Api\Authenticated;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedTestCase extends TestCase
{

    protected $user;

    /**
     * @return $this
     */
    public function authenticated(): AuthenticatedTestCase
    {
        $this->user = User::factory()->create([
            'role' => UserRole::ADMIN
        ]);

        Session::put('token_access', JWTAuth::fromUser($this->user));

        $this->actingAs($this->user);

        return $this;
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function user_has_not_access(string $route, array $params = [])
    {
        $response = $this->get(route($route, $params));
        $response->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function user_has_access(string $route, array $params = [])
    {
        $response = $this->authenticated()->get(route($route, $params));
        $response->assertStatus(Response::HTTP_OK);
    }
}
