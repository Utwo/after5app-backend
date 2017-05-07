<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SkillTest extends TestCase {
	/**
	 * GET Skills
	 *
	 * @return void
	 */
	public function testGetSkill() {
		$response = $this->json('GET', '/api/v1/skill?with[]=position.project.user');

		$response
			->assertStatus(200)
			->assertJsonStructure([
				"data" => [
					[
						'id',
						'name',
						'position' => [],
					],
				],
			]);
	}

}
