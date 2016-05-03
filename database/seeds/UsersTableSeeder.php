<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = factory(App\User::class, 10)->create();
        foreach ($users as $user) {
            $user->Skill()->attach(\App\Skill::all()->random(4)->pluck('id')->toArray());
        }
    }
}
