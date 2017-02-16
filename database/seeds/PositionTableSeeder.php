<?php

use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{

    private $taken_skills = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->delete();
        $faker = Faker\Factory::create();
        $projects = \App\Project::all();
        $skills = \App\Skill::all();

        foreach ($projects as $project) {
            $this->taken_skills = [];
            for ($i = 0; $i < random_int(0, 3); $i++) {
                $skill_id = $this->generate_unique_skill($skills);

                $project->Position()->create([
                    'skill_id' => $skill_id,
                    'description' => $faker->sentence(),
                    'status' => $faker->boolean(),
                ]);
            }
        }

        //factory(\App\Position::class, 20)->create();
    }

    private function generate_unique_skill($skills)
    {
        $skill_id = $skills->random(1)->first()->id;
        while (in_array($skill_id, $this->taken_skills)) {
            $skill_id = $skills->random(1)->first()->id;
        }
        $this->taken_skills[] = $skill_id;
        return $skill_id;
    }
}
