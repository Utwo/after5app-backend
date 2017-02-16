<?php

use Illuminate\Database\Seeder;

class MessengerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();
        $faker = \Faker\Factory::create();

        $projects = \App\Project::all();

        foreach ($projects as $project) {
            $users = \App\User::whereHas('Application.Position', function ($query) use ($project) {
                return $query->where('project_id', $project->id);
            })->get();
            $users = $users->merge($project->User()->get());

            for ($i = 0; $i <= random_int(0, 100); $i++) {
                \Illuminate\Support\Facades\DB::table('messengers')->insert([
                    'message' => '{"text": "' . $faker->sentence() . '", "user_id": "' . $users->random(1)->first()->id . '", "user_name": "' . $users->random(1)->first()->name . '"}',
                    'project_id' => $project->id
                ]);
            }
        }
    }
}
