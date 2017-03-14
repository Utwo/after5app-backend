<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('hobbies')->nullable(); //json
            $table->text('social')->nullable(); //json
            $table->text('description')->nullable();
            $table->string('city')->nullable();
            $table->boolean('notify_email')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('hobbies');
            $table->dropColumn('description');
            $table->dropColumn('city');
        });
    }
}
