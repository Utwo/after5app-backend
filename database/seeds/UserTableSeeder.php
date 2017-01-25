<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $my_user = User::create(['name' => 'mihai', 'email' => 'user1@example.com']);

        $users = factory(App\User::class, 10)->create();
        //users[] = $my_user;
        foreach ($users as $user) {
            $skills = \App\Skill::all()->random(4)->pluck('id')->toArray();
            $skills_with_level = [];
            foreach ($skills as $key => $skill) {
                $skills_with_level[$skill] = ['skill_level' => random_int(1, 100)];
            }
            $user->Skill()->attach($skills_with_level);
        }
    }
}
