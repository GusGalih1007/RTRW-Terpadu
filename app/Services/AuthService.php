<?php

namespace App\Services;

use App\Enums\OtpType;
use App\Interfaces\AuthRepositoryInterface;
use App\Mail\OtpMail;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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

    public function editProfile(string $userId, array $data)
    {
        try {
            $user = $this->authRepository->editProfile($userId, $data);

            return $user;
        } catch (Exception $e) {
            throw new Exception('Gagal untuk mengedit profile: ' . $e->getMessage());
        }
    }

    public function generateQrImage(string $userId)
    {
        try {
            $qrContent = (string) $userId;

            $directory = 'user_qr';
            $fileName = "user_qr_{$userId}.png";
            $relativePath = "{$directory}/{$fileName}";

            Storage::disk('public')->makeDirectory($directory);

            QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->generate(
                    $qrContent,
                    storage_path("app/public/{$relativePath}")
                );

            // Simpan path RELATIVE ke database
            $this->authRepository->saveQrImage($userId, $relativePath);

            return [
                'qr_path' => $relativePath,
                'qr_url' => Storage::url($relativePath),
            ];
        } catch (Exception $e) {
            throw new Exception('Gagal membuat kode QR: ' . $e->getMessage());
        }
    }

    public function sendLoginOtp(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        $encryptedPassword = $user->password;

        try
        {
            $decryptedPassword = Crypt::decryptString($encryptedPassword);

            if (!$data['password'] === $decryptedPassword) {
                return [
                    'success' => false,
                    'reason' => 'Password tidak sesuai'
                ];
            }
    
            if (!$user->email_verified_at) {
                return [
                    'success' => false,
                    'reason' => 'Email belum terverifikasi'
                ];
            }
    
            $otp = $this->authRepository->generateOtp($user->email, OtpType::Login->value);
    
            Mail::to($user['email'])->send(new OtpMail($otp, 'Verifikasi Login'));
    
            return true;
        } catch (Exception $e) {
            throw new Exception();
        }
    }

    public function login($user)
    {
        try {

            Auth::login($user);

            return true;
        } catch (Exception $e) {
            throw new Exception('Gagal melakukan proses login: ' . $e->getMessage());
        }
    }

    public function checkEmailVerified(string $email)
    {
        try
        {
            $user = $this->getUserByEmail($email);
    
            return (bool) $user->email_verified_at;
        } catch (Exception $e) {
            throw new Exception('Gagal mengecek email verifikasi: ' . $e->getMessage());
        }
    }

    public function getUserByEmail(string $email)
    {
        return $this->authRepository->getUserByEmail($email);
    }

    public function getUserById(string $userId)
    {
        return $this->authRepository->getUserById($userId);
    }

    public function requestPasswordReset(string $email)
    {
        $user = $this->authRepository->getUserByEmail($email);

        if (!$user) {
            throw new Exception('Akun tidak ditemukan');
        }

        $otp = $this->authRepository->generateOtp($email, OtpType::ResetPassword->value);

        Mail::to($email)->send(new OtpMail($otp, 'Reset Password'));

        return true;
    }

    public function generateOtp(string $email, string $type)
    {
        return $this->authRepository->generateOtp($email, $type);
    }

    public function verifyOtp(string $email, string $otp, $otpType)
    {
        $result = $this->authRepository->otpVerify($email, $otp, $otpType);
        
        if (!$result['success']) {
            throw new Exception($result['message'] ?? 'OTP tidak valid');
        }

        if ($otpType === OtpType::Register->value) {
            $this->authRepository->updateVerifiedEmail($email);
        }

        return $result;
    }

    public function resetPassword(string $email, string $otp, string $password)
    {
        // Verify OTP first
        $this->verifyOtp($email, $otp, OtpType::ResetPassword->value);

        // Update password
        $user = $this->authRepository->updatePasswordByEmail($email, $password);

        if (!$user) {
            throw new Exception('Gagal mereset password');
        }

        return true;
    }

    public function resendOtp(string $email, string $otpType)
    {
        $user = $this->authRepository->getUserByEmail($email);

        if (!$user && $otpType !== OtpType::Register->value) {
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
        try
        {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
    
            return true;
        } catch (Exception $e) {
            throw new Exception('Proses logout telah gagal: ' . $e->getMessage());
        }
    }
}
