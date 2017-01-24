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

// Delete old login tokens from database
Artisan::command('auth:clear-email', function () {
    $weeks = 1;
    $deleted_count = DB::table('email_logins')->where('created_at', '<', \Carbon\Carbon::now()->subWeek($weeks))->delete();
    $this->info("{$deleted_count} emails tokens older then {$weeks} weeks flushed successfully.");
})->describe('Flush expired email token login');

// Remove old notifications
Artisan::command('notifications:flush', function () {
    $weeks = 4;
    $deleted_count = DB::table('notifications')->where('created_at', '<', \Carbon\Carbon::now()->subWeek($weeks))->whereNotNull('read_at')->delete();
    $this->info("{$deleted_count} notifications older then {$weeks} weeks flushed successfully.");
})->describe('Flush old notifications');

Artisan::command('assets:flush', function () {
    $assets_file = Storage::files('assets');
    foreach ($assets_file as $asset_file) {
        if (!\App\Asset::where('path', $asset_file)->exists()) {
            \Illuminate\Support\Facades\Storage::delete($asset_file);
        }
    }
})->describe('Flush assets that no longer have projects assigned');