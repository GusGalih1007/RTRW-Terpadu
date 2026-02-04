<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use Illuminate\Console\Command;

class CleanupExpiredOtp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:cleanup-expired-otp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete used and expired OTP within 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleteOtp = OtpCode::prunable()->delete();

        $this->info("Successfully deleted {$deleteOtp} expired OTP.");
        
        return self::SUCCESS;
    }
}
