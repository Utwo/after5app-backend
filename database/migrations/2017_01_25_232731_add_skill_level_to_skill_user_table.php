<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkillLevelToSkillUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            $table->tinyInteger('skill_level')->unsigned()->default(50); //json
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            $table->dropColumn('skill_level');
        });
    }
}
