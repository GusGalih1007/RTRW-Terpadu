<?php

namespace App\Services;

use App\Enums\OtpType;
use App\Interfaces\AuthRepositoryInterface;
use App\Mail\OtpMail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            throw new Exception('Email sudah terdaftar');
        }

        $user = $this->authRepository->register($data);

        // Generate OTP for email verification
        $otp = $this->authRepository->generateOtp($user->email, OtpType::Register->value);

        Mail::to($user['email'])->send(new OtpMail($otp, 'Verifikasi Email'));

        return $user;
    }

    public function sendLoginOtp(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (! $user) {
            throw new Exception('Akun tidak ditemukan');
        }

        if (! Hash::check($data['password'], $user->password)) {
            throw new Exception('Password tidak valid');
        }

        if (! $user->email_verified_at) {
            throw new Exception('Email belum terverifikasi');
        }

        $otp = $this->authRepository->generateOtp($user->email, OtpType::Login->value);

        Mail::to($user['email'])->send(new OtpMail($otp, 'Verifikasi Login'));

        return true;
    }

    public function getUser(string $email)
    {
        return $this->authRepository->getUserByEmail($email);
    }

    public function requestPasswordReset(string $email)
    {
        $user = $this->authRepository->getUserByEmail($email);

        if (! $user) {
            throw new Exception('Akun tidak ditemukan');
        }

        $otp = $this->authRepository->generateOtp($email, OtpType::ResetPassword->value);

        Mail::to($email)->send(new OtpMail($otp, 'Reset Password'));

        return true;
    }

    public function verifyOtp(string $email, string $otp, $otpType)
    {
        $result = $this->authRepository->otpVerify($email, $otp, $otpType);

        if ($otpType === OtpType::Register->value) {
            $this->authRepository->updateVerifiedEmail($email);
        }

        if (! $result['success']) {
            throw new Exception($result['message'] ?? 'OTP tidak valid');
        }

        return $result;
    }

    public function resetPassword(string $email, string $otp, string $password)
    {
        // Verify OTP first
        $this->verifyOtp($email, $otp, OtpType::ResetPassword);

        // Update password
        $user = $this->authRepository->updatePasswordByEmail($email, $password);

        if (! $user) {
            throw new Exception('Gagal mereset password');
        }

        return true;
    }

    public function resendOtp(string $email, string $otpType)
    {
        $user = $this->authRepository->getUserByEmail($email);

        if (! $user && $otpType !== OtpType::Register->value) {
            throw new Exception('Akun tidak ditemukan');
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

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
