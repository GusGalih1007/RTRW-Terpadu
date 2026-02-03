<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function register(array $data);
    public function getUserByEmail(string $email);
    public function getUserById(string $userId);
    public function updatePasswordById(string $userId, string $newPassword);
    public function updatePasswordByEmail(string $email, string $newPassword);
    public function generateOtp(string $email, string $otpType);
    public function otpVerify(string $email, string $otp, string $otpType);
    public function resetOtp(string $email, string $otpType);
    public function updateVerifiedEmail(string $email);
    public function saveQrImage(string $userId, string $qrPath);
}
