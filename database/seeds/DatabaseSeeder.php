<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SkillTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(ApplicationTableSeeder::class);
        $this->call(FavoriteTableSeeder::class);
    }
}
