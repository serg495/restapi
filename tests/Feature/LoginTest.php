<?php


namespace Tests\Feature;


use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function an_email_and_password_is_required()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422);
    }
    
    /** @test */
    function a_user_can_authorize()
    {
        factory(User::class)->create([
            'email' => 'login@test.com',
            'password' => bcrypt('123123123'),
        ]);

        $payload = ['email' => 'login@test.com', 'password' => '123123123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
    
    /** @test */
    function a_user_can_logout()
    {
        $user = factory(User::class)->create();

        $headers = [
            'Authorization' => "Bearer {$user->api_token}"
        ];

        $this->json('POST', 'api/logout', [], $headers)
            ->assertStatus(204);
    }
}