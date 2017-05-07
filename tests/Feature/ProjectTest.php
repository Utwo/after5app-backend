<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
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
     * GET Projects
     *
     * @return void
     */
    public function testGetProjects()
    {
        $response = $this->json('GET', '/api/v1/project');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'per_page',
                'data' => [
                    ['id', 'title', 'description', 'application_questions', 'status', 'user_id', 'favorite_count', 'comment_count', 'created_at', 'updated_at'],
                ]
            ]);
    }

    /**
     * Store Project
     *
     * @return void
     */
    public function testStoreProject()
    {
        $response = $this->actingAs(auth()->user())
            ->json('POST', "/api/v1/project?token={$this->token}",
                [
                    "title" => "Project name",
                    "description" => "A simple description",
                    "application_questions" => [
                        "Cum te cheama?",
                        "In ce lucrezi?"
                    ],
                    "position" => [
                        [
                            "name" => "php",
                            "description" => "In ce lucrezi?",
                            "status" => 0
                        ],
                        [
                            "name" => "javascript",
                            "description" => "In ce lucrezi?",
                            "status" => 1
                        ]
                    ]
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'project' => [
                    'id',
                    'title',
                    'description',
                    'application_questions',
                    'user_id',
                    'position' => [
                        [
                            "description",
                            "status",
                            "skill_id",
                            "project_id",
                            "id",
                            "name"
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $response->json()['project']['id']
        ]);
    }

    /**
     * Update Project
     *
     * @return void
     */
    public function testUpdateProject()
    {
        $my_project_id = auth()->user()->Project->pluck('id')->first();
        $response = $this->actingAs(auth()->user())
            ->json('PUT', "/api/v1/project/{$my_project_id}?token={$this->token}",
                [
                    "title" => "New Project name",
                    "description" => "New descriptions",
                    "application_questions" => [
                        "New question",
                        "New question 2"
                    ],
                    "status" => false
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "title" => "New Project name",
                "description" => "New descriptions",
                "application_questions" => [
                    "New question",
                    "New question 2"
                ],
                "status" => false
            ]);
    }

    /**
     * Delete Project
     *
     * @return void
     */
    public function testDeleteProject()
    {
        $project_id = Project::where('user_id', $this->auth_user_id)->pluck('id')->first();
        $response = $this->actingAs(auth()->user())
            ->json('DELETE', "/api/v1/project/{$project_id}/?token={$this->token}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Project deleted successfully',
            ]);

        $this->assertDatabaseMissing('projects', [
            'id' => $project_id
        ]);
    }
}
