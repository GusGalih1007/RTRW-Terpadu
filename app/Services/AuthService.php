<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;
use App\Enums\OtpType;
use App\Mail\OtpMail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $authRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $existingUser = $this->authRepository->getUserByEmail($data['email']);
        if ($existingUser) {
            throw new Exception('Email already registered');
        }

        $user = $this->authRepository->register($data);

        // Generate OTP for email verification
        $otp = $this->authRepository->generateOtp($user->email, OtpType::Register->value);

        Mail::to($user['email'])->queue(new OtpMail($otp, 'Verifikasi Email'));

        return $user;
    }

    public function login(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception('Email not found');
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new Exception('Invalid password');
        }

        if (!$user->email_verified_at) {
            // Regenerate OTP for verification
            $otp = $this->authRepository->generateOtp($user->email, OtpType::Register->value);
            Mail::to($user->email)->send(new OtpMail($otp, 'Verifikasi Email'));

            throw new Exception('Email not verified. OTP has been resent to your email.');
        }

        return $user;
    }

    public function requestPasswordReset(string $email)
    {
        $user = $this->authRepository->getUserByEmail($email);

        if (!$user) {
            throw new Exception('Email not found');
        }

        $otp = $this->authRepository->generateOtp($email, OtpType::ResetPassword->value);

        Mail::to($email)->send(new OtpMail($otp, 'Reset Password'));

        return true;
    }

    public function verifyOtp(string $email, string $otp, $otpType)
    {
        $result = $this->authRepository->otpVerify($email, $otp, $otpType);
        
        if (!$result['success']) {
            throw new Exception($result['message'] ?? 'Invalid OTP');
        }

        return true;
    }

    public function resetPassword(string $email, string $otp, string $password)
    {
        // Verify OTP first
        $this->verifyOtp($email, $otp, OtpType::ResetPassword);

        // Update password
        $user = $this->authRepository->updatePasswordByEmail($email, $password);
        
        if (!$user) {
            throw new Exception('Failed to reset password');
        }

        return $user;
    }

    public function resendOtp(string $email, string $otpType)
    {
        $user = $this->authRepository->getUserByEmail($email);
        
        if (!$user && $otpType !== OtpType::Register->value) {
            throw new Exception('Email not found');
        }

        // Regenerate OTP
        $otp = $this->authRepository->resetOtp($email, $otpType);

        // Send OTP email
        switch ($otpType) {
            case OtpType::Register->value:
                $subject = 'Verifikasi Email';
                break;
            case OtpType::Login->value:
                $subject = 'Verifikasi Login';
                break;
            case OtpType::ResetPassword->value:
                $subject = 'Reset Password';
                break;
            default:
                $subject = 'Verifikasi Tindakan Khusus';
        }
        
        Mail::to($email)->send(new OtpMail($otp, $subject));

        return true;
    }

    public function logout($user)
    {
        // Revoke all tokens (for API)
        $user->tokens()->delete();
        
        // For web authentication
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
