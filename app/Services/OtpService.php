<?php

namespace App\Services;

use App\Models\OtpCode;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Enums\OtpType;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function generate(
        Authenticatable $user,
        OtpType $otpType
    ): string {
        return DB::transaction(function () use ($user, $otpType) {
        $otp = (string) random_int(100000, 999999);

        OtpCode::where('userId', $user->getAuthIdentifier())
            ->where('codeType', $otpType)
            ->whereNull('usedAt')
            ->delete();

        OtpCode::create([
            'userId' => $user->getAuthIdentifier(),
            'codeType' => $otpType,
            'codeHash' => Hash::make($otp),
            'expiresAt' => now()->addSeconds($otpType->ttl()),
        ]);

        return $otp;
    });
    }

    public function verify(
        Authenticatable $user,
        OtpType $otpType,
        string $inputOtp
    ): array {
        $otp = OtpCode::where('userId', $user->getAuthIdentifier())
            ->where('codeType', $otpType)
            ->whereNull('usedAt')
            ->latest()
            ->first();

        if (! $otp) {
            return ['success' => false, 'reason' => 'OTP not found', 'message' => 'OTP tidak ditemukan'];
        }

        if ($otp->isExpired()) {
            return ['success' => false, 'reason' => 'OTP expired', 'message' => 'OTP telah kadaluarsa'];
        }

        if ($otp->attempts >= $otpType->maxAttempts()) {
            return ['success' => false, 'reason' => 'Max attempts reached', 'message' => 'Terlalu banyak percobaan. Silahkan buat ulang OTP'];
        }

        $otp->increment('attempts');

        if (! Hash::check($inputOtp, $otp->codeHash)) {
            return ['success' => false, 'reason' => 'Invalid OTP', 'message' => 'OTP tidak valid. Silahkan buat ulang OTP'];
        }

        $otp->update([
            'usedAt' => now(),
        ]);

        return ['success' => true, 'reason' => 'OTP verified successfully'];
    }
}
