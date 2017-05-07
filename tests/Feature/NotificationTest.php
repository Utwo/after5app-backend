<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationTest extends TestCase
{
    use DatabaseTransactions;

    private $auth_user_id = 1;
    private $token;

    protected function setUp() {
        parent::setUp();
        $this->token = auth()->login(User::findOrFail($this->auth_user_id));
    }

    /**
     * GET Notifications
     *
     * @return void
     */
    public function testCountNotification()
    {
        $response = $this->actingAs(auth()->user())
            ->json('GET', "/api/v1/notification/count");

        $response
            ->assertStatus(200)
            ->assertJson([
                'notification_count' => 0
            ]);
    }

    /**
     * GET Notifications
     *
     * @return void
     */
    public function testGetNotification()
    {
        $response = $this->actingAs(auth()->user())
            ->json('GET', "/api/v1/notification");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'notification'
            ]);
    }
}
