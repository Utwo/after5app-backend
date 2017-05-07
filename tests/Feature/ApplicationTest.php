<?php

namespace Tests\Feature;

use App\Position;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicationTest extends TestCase
{
    use DatabaseTransactions;

    private $auth_user_id = 1;
    private $my_projects;
    private $token;

    protected function setUp()
    {
        parent::setUp();
        $this->token = auth()->login(User::findOrFail($this->auth_user_id));
        $this->my_projects = $this->actingAs(auth()->user())->json('GET', "/api/v1/project?user_id={$this->auth_user_id}&with[]=position")->json();
    }

    /**
     * GET Applications by project
     *
     * @return void
     */
    public function testGetProjectApplication()
    {
        $response = $this->actingAs(auth()->user())
            ->json('GET', "/api/v1/project/{$this->my_projects['data'][0]['id']}/application");

        $response->assertStatus(200);
    }

    /**
     * GET Applications by user
     *
     * @return void
     */
    public function testGetUserApplication()
    {
        $response = $this->actingAs(auth()->user())
            ->json('GET', "/api/v1/application/user");

        $response->assertStatus(200);
    }

    /**
     * Store Application
     *
     * @return void
     */
    public function testStoreApplication()
    {
        $other_position = Position::where('status', 1)->whereHas('Project', function ($query) {
            $query->where('user_id', '<>', $this->auth_user_id);
        })->whereDoesntHave('Application', function ($query) {
            $query->where('accepted', 1);
        })->get();

        $response = $this->actingAs(auth()->user())
            ->json('POST', "/api/v1/application",
                [
                    'message' => 'message name',
                    'position_id' => $other_position[0]['id'],
                    'answers' => [
                        'application answer text1',
                        'application answer text2'
                    ]
                ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'application' => [
                    'message' => 'message name',
                    'position_id' => $other_position[0]['id'],
                    'answers' => [
                        'application answer text1',
                        'application answer text2'
                    ]
                ],
            ]);

        $this->assertDatabaseHas('applications', [
            'id' => $response->json()['application']['id']
        ]);
    }

    /**
     * Update Application
     *
     * @return void
     */
    public function testUpdateApplication()
    {
        $this->assertTrue(true);
    }

    /**
     * Delete Application
     *
     * @return void
     */
    public function testDeleteApplication()
    {
        $my_application = $this->actingAs(auth()->user())->json('GET', "/api/v1/application/user");
        $applicaton_id = $my_application->json()[0]['id'];
        $response = $this->actingAs(auth()->user())->json('DELETE', "/api/v1/application/{$applicaton_id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Application deleted successfully',
            ]);

        $this->assertSoftDeleted('applications', [
            'id' => $applicaton_id
        ]);
    }
}
