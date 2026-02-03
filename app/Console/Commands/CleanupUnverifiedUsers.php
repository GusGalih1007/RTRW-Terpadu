<?php

namespace App\Console\Commands;

use App\Models\Users;
use Illuminate\Console\Command;

class CleanupUnverifiedUsers extends Command
{
    protected $signature = 'users:cleanup-unverified';
    protected $description = 'Delete users who have not verified their email within 24 hours';

    public function handle()
    {
        $deletedCount = Users::prunable()->delete();

        $this->info("Successfully deleted {$deletedCount} unverified users.");
        
        return self::SUCCESS;
    }
}