<?php

namespace Tests\Feature;

use App\Invite;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitesTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class, 2)->create();
    }

    /** @test */
    function a_user_can_send_invite()
    {
        $data = ['recipient_id' => 2, 'body' => 'Test Invite'];

        $this->json('POST', 'api/user/invite/send', $data, $this->headers())
            ->assertStatus(200);

        $this->assertDatabaseHas('invites', $data);
    }

    /** @test */
    function a_user_can_cancel_invite()
    {
        $invite = Invite::create([
            'sender_id' => 1,
            'recipient_id' => 2,
            'body' => 'Test Invite'
        ]);

        $this->json('PATCH', "api/user/invite/{$invite->id}/cancel", [], $this->headers())
            ->assertStatus(200);

        $this->assertDatabaseHas('invites', ['id' => 1, 'is_canceled' => true]);
    }

    /** @test */
    function a_user_can_get_sent_invites()
    {
        $invite = Invite::create([
            'sender_id' => 1,
            'recipient_id' => 2,
            'body' => 'Test Invite'
        ]);

        $this->json('GET', 'api/user/invites/sent', [], $this->headers())
            ->assertStatus(200)
            ->assertJson([
                'data' => [$invite->toArray()],
            ]);
    }

    /** @test */
    function a_user_can_get_received_invites()
    {
        $invite = Invite::create([
            'sender_id' => 2,
            'recipient_id' => 1,
            'body' => 'Test Invite'
        ]);

        $this->json('GET', 'api/user/invites/received', [], $this->headers())
            ->assertStatus(200)
            ->assertJson([
                'data' => [$invite->toArray()],
            ]);
    }

    /** @test */
    function a_user_can_confirm_or_reject_invite()
    {
        $invite = Invite::create([
            'sender_id' => 2,
            'recipient_id' => 1,
            'body' => 'Test Invite'
        ]);

        $this->json('PATCH', "api/user/invite/{$invite->id}/confirm", ['confirmation' => true], $this->headers())
            ->assertStatus(200);
        $this->assertDatabaseHas('invites', ['confirmed' => true]);

        $this->json('PATCH', "api/user/invite/{$invite->id}/confirm", ['confirmation' => false], $this->headers())
            ->assertStatus(200);
        $this->assertDatabaseHas('invites', ['confirmed' => false]);
    }

    private function headers(): array
    {
        $user = User::first();

        return ['Authorization' => "Bearer {$user->api_token}"];
    }
}
