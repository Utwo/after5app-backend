<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
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
     * GET User
     *
     * @return void
     */
    public function testGetUser()
    {
        $test_as_user_id = 2;
        $response = $this->json('GET', "/api/v1/user/{$test_as_user_id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id", "name", "email", "facebook_id", "github_id", "website", "twitter", "workplace", "created_at", "updated_at", "hobbies", "social", "description", "city", "notify_email", "picture"
            ])
            ->assertJsonFragment([
                "id" => $test_as_user_id,
            ]);
    }

    /**
     * GET authenticated User
     *
     * @return void
     */
    public function testGetAuthUser()
    {
        $response = $this->actingAs(auth()->user())
            ->json('GET', "/api/v1/user");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "id", "name", "email", "facebook_id", "github_id", "website", "twitter", "workplace", "created_at", "updated_at", "hobbies", "social", "description", "city", "notify_email", "picture"
            ])
            ->assertJsonFragment([
                "id" => auth()->user()->id,
                "name" => auth()->user()->name,
            ]);
    }


    /**
     * Update User
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $response = $this->actingAs(auth()->user())
            ->json('PUT', "/api/v1/user",
                [
                    "name" => "Darth Vader",
                    "workplace" => "rainbow maker",
                    "twitter" => "@utwo",
                    "website" => "http://utwo.ro",
                    "hobbies" => ["art", "drawing", "cycling"],
                    "description" => "Simple description here",
                    "city" => "Romania, Cluj",
                    "notify_email" => 1,
                    "social" => [
                        "twitter" => "utwoo",
                        "facebook" => "utwoo",
                        "github" => "utwooo"
                    ]
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                "name" => "Darth Vader",
                "workplace" => "rainbow maker",
                "twitter" => "@utwo",
                "website" => "http://utwo.ro",
                "hobbies" => ["art", "drawing", "cycling"],
                "description" => "Simple description here",
                "city" => "Romania, Cluj",
                "notify_email" => true,
                "social" => [
                    "twitter" => "utwoo",
                    "facebook" => "utwoo",
                    "github" => "utwooo"
                ]
            ]);
    }

    /**
     * Update User skills
     *
     * @return void
     */
    public function testUpdateUserSkill()
    {
        $response = $this->actingAs(auth()->user())
            ->json('PUT', "/api/v1/user/skill",
                [
                    "skill" => [
                        [
                            "name" => "this-is-new",
                            "skill_level" => 15
                        ],
                        [
                            "name" => "js developer",
                            "skill_level" => 40
                        ]
                    ]
                ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'skills'
            ]);

        $this->assertDatabaseHas('skills', [
            'id' => array_keys($response->json()['skills'], ["skill_level" => 15])[0]
        ]);
    }
}
