<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('facebook_id')->unique()->nullable();
            $table->string('facebook_token')->nullable();
            $table->string('password')->nullable();
            $table->string('website')->nullable();
            $table->string('twitter')->nullable();
            $table->string('workplace')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
