<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function register(array $data);
    public function getUserByEmail(string $email);
    public function updatePasswordById(string $userId, string $newPassword);
    public function updatePasswordByEmail(string $email, string $newPassword);
    public function generateOtp(string $email, string $otpType);
    public function otpVerify(string $email, string $otp, string $otpType);
    public function resetOtp(string $email, string $otpType);
}
