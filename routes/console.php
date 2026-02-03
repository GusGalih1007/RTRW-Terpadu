<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register the cleanup command
Artisan::command('users:cleanup-unverified', function () {
    $this->call(\App\Console\Commands\CleanupUnverifiedUsers::class);
})->purpose('Delete users who have not verified their email within 24 hours')
->daily();
