<?php

namespace Tests\Feature;

use App\Position;
use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionTest extends TestCase
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
     * Store Position
     *
     * @return void
     */
    public function testStorePosition()
    {
        $my_project_id = auth()->user()->Project->pluck('id')->first();
        $response = $this->actingAs(auth()->user())
            ->json('POST', "/api/v1/position",
                [
                    "name" => "php",
                    "description" => "A simple description",
                    "project_id" => $my_project_id,
                    "status" => 1,
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "description" => "A simple description",
                "status" => true,
                "project_id" => $my_project_id,
                "name" => "php",
            ]);

        $this->assertDatabaseHas('positions', [
            'id' => $response->json()['position']['id']
        ]);
    }

    /**
     * Update Position
     *
     * @return void
     */
    public function testUpdatePosition()
    {
        // Just create a Position
        $my_project_id = auth()->user()->Project->pluck('id')->first();
        $this->actingAs(auth()->user())->json('POST', "/api/v1/position",
            [
                "name" => "php",
                "description" => "A simple description",
                "project_id" => $my_project_id,
                "status" => 1,
            ]);

        $my_position_id = Project::find($my_project_id)->Position->pluck('id')->first();
        $response = $this->actingAs(auth()->user())
            ->json('PUT', "/api/v1/position/{$my_position_id}",
                [
                    "description" => "New description",
                    "status" => 0,
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "description" => "New description",
                "status" => false
            ]);
    }

    /**
     * Delete Position
     *
     * @return void
     */
    public function testDeletePosition()
    {
        // Just create a Position
        $my_project_id = auth()->user()->Project->pluck('id')->first();
        $this->actingAs(auth()->user())->json('POST', "/api/v1/position",
            [
                "name" => "php",
                "description" => "A simple description",
                "project_id" => $my_project_id,
                "status" => 1,
            ]);

        $position_id = Project::find($my_project_id)->Position->pluck('id')->first();
        $response = $this->actingAs(auth()->user())
            ->json('DELETE', "/api/v1/position/{$position_id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Position deleted successfully',
            ]);

        $this->assertDatabaseMissing('positions', [
            'id' => $position_id
        ]);
    }
}
