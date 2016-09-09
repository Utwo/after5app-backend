<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('auth:clear-email', function () {
    $weeks = 1;
    $deleted_count = DB::table('email_logins')->where('created_at', '<', \Carbon\Carbon::now()->subWeek($weeks))->delete();
    $this->info("{$deleted_count} emails tokens older then {$weeks} weeks flushed successfully.");
})->describe('Flush expired email token login');

Artisan::command('notification:flush', function () {
    $weeks = 4;
    $deleted_count = DB::table('notifications')->where('created_at', '<', \Carbon\Carbon::now()->subWeek($weeks))->whereNotNull('read_at')->delete();
    $this->info("{$deleted_count} notifications older then {$weeks} weeks flushed successfully.");
})->describe('Flush old notifications');