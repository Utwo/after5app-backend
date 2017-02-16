<?php

use Illuminate\Database\Seeder;

class FavoriteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();

        $users = \App\User::all()->random(5);
        $projects = \App\Project::all();
        foreach ($users as $user) {
            for ($i = 0; $i <= random_int(0, 20); $i++) {
                $user->favorite()->syncWithoutDetaching([$projects->random(1)->first()->id]);
            }
        }
    }
}
