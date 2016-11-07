<?php

use Illuminate\Support\Facades\Schema;
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

            $table->string('name')->nullable();
            $table->string('email', 191)->unique()->index();
            $table->unsignedBigInteger('facebook_id')->unique()->nullable();
            $table->string('facebook_token')->nullable();
            $table->string('github_id', 191)->unique()->nullable();
            $table->string('github_token')->nullable();
            $table->string('website')->nullable();
            $table->string('twitter')->nullable();
            $table->string('workplace')->nullable();

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
