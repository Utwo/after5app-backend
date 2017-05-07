<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase {
	use DatabaseTransactions;

	private $auth_user_id = 1;
	private $token;

	protected function setUp() {
		parent::setUp();
		$this->token = auth()->login(User::findOrFail($this->auth_user_id));
	}

	/**
	 * Store Comment
	 *
	 * @return void
	 */
	public function testStoreComment() {
		$response = $this->actingAs(auth()->user())
		                 ->json('POST', "/api/v1/comment?token={$this->token}",
			                 [
				                 "text" => "First comment",
				                 "project_id" => 1
			                 ]);

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'comment' => [
					'text',
					'project_id',
					'user_id',
					'id',
				]
			]);
	}

	/**
	 * Delete Comment
	 *
	 * @return void
	 */
	public function testDeleteComment() {
		$this->actingAs(auth()->user())
		     ->json('POST', "/api/v1/comment",
			     [
				     "text" => "First comment",
				     "project_id" => 1
			     ]);

		$comment_id = Comment::where('user_id', $this->auth_user_id)->pluck('id')->first();
		$response   = $this->actingAs(auth()->user())
		                   ->json('DELETE', "/api/v1/comment/{$comment_id}/?token={$this->token}");

		$response
			->assertStatus(200)
			->assertJson([
				'message' => 'Comment deleted successfully',
			]);

		$this->assertDatabaseMissing('comments', [
			'id' => $comment_id
		]);
	}
}
