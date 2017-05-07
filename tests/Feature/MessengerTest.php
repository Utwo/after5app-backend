<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessengerTest extends TestCase
{
    use DatabaseTransactions;

    private $auth_user_id = 1;
    private $token;

    protected function setUp()
    {
        parent::setUp();
        $this->token = auth()->login(User::findOrFail($this->auth_user_id));
    }

    /**
     * GET Messages
     *
     * @return void
     */
    public function testGetMessage()
    {
        $my_project_id = auth()->user()->Project->pluck(['id'])->first();
        $response = $this->json('GET', "/api/v1/project/{$my_project_id}/messenger");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'per_page',
                'data' => [
                    ['message', 'project_id', 'created_at'],
                ]
            ]);
    }

    /**
     * Store Message
     *
     * @return void
     */
    public function testStoreMessage()
    {
        $my_project_id = auth()->user()->Project->pluck(['id'])->first();
        $response = $this->json('POST', "/api/v1/messenger?token={$this->token}",
                [
                    "text" => "message here",
                    "project_id" => $my_project_id,
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "message" => [
                    "user_id" => auth()->id(),
                    "user_name" => auth()->user()->name,
                    "text" => "message here"
                ],
                "project_id" => $my_project_id,
            ]);

        $this->assertDatabaseHas('messengers', [
            'project_id' => $response->json()['messenger']['project_id']
        ]);
    }
}
