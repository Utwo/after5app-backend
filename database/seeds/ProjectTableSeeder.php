<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();

        $projects = factory(\App\Project::class, 20)->create();

        foreach ($projects as $project) {
            $project->Skill()->attach(\App\Skill::all()->random(5)->pluck('id')->toArray());
        }
    }
}
