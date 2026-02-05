<?php

namespace App\Repositories;

use App\Enums\OtpType;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\Users;
use App\Services\OtpService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr;

class AuthRepository implements AuthRepositoryInterface
{
    protected $user;
    protected $otpService;

    /**
     * Create a new class instance.
     */
    public function __construct(Users $users, OtpService $otpService)
    {
        $this->user = $users;
        $this->otpService = $otpService;
    }

    public function register(array $data)
    {
        try {
            $data['password'] = Crypt::encrypt($data['password']);
            return $this->user->create($data);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data dalam database: ' . $e->getMessage());
        }
        // throw new Exception('Not implemented');
    }

    public function editProfile(string $userId, array $data)
    {
        try {
            $user = $this->getUserById($userId);

            if (!$user) {
                throw new Exception('Akun tidak ditemukan');
            }

            $user->update($data);
            return $user->fresh();
        } catch (Exception $e) {
            throw new Exception('Gagal untuk merubah data dalam database: ' . $e->getMessage());
        }
    }

    public function saveQrImage(string $userId, string $qrPath)
    {
        try {
            $user = $this->getUserById($userId);

            if (!$user) {
                throw new Exception('Akun tidak ditemukan');
            }

            $user->update([
                'qrImage' => $qrPath
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan kode QR ke dalam database: ' . $e->getMessage());
        }
    }

    public function getUserByEmail(string $email)
    {
        return $this->user->where('email', '=', $email)->first();
        // throw new Exception('Not implemented');
    }

    public function getUserById(string $userId)
    {
        return $this->user->findOrFail($userId);
    }

    public function updatePasswordByEmail(string $email, string $newPassword)
    {
        try
        {
            $user = $this->getUserByEmail($email);
            
            if (!$user) {
                throw new Exception('Akun tidak ditemukan');
            }
    
            $user->update([
                'password' => Hash::make($newPassword)
            ]);
    
            return $user;
        } catch (Exception $e) {
            throw new Exception('Gagal merubah data password dalam database: ' . $e->getMessage());
        }
        // throw new Exception('Not implemented');
    }

    public function updatePasswordById(string $userId, string $newPassword)
    {
        $user = $this->user->find($userId);

        if ($user) {
            $user->update([
                'password' => Hash::make($newPassword)
            ]);
            return $user;
        }

        throw new Exception('Akun tidak ditemukan');
    }

    public function generateOtp(string $email, string $otpType)
    {
        try {
            if (!$otpType) {
                throw new Exception('Tipe OTP kosong');
            }

            $user = $this->getUserByEmail($email);

            return $this->otpService->generate($user, OtpType::from($otpType));
        } catch (Exception $e) {
            throw new Exception('Gagal membuat OTP: ' . $e->getMessage());
        }
        // throw new Exception('Not implemented');
    }

    public function otpVerify(string $email, string $otp, string $otpType)
    {
        try {
            if (!$otpType) {
                throw new Exception('Tipe OTP kosong');
            }

            $user = $this->getUserByEmail($email);

            if (!$user) {
                throw new Exception('Akun tidak ditemukan');
            }

            return $this->otpService->verify($user, OtpType::from($otpType), $otp);
        } catch (Exception $e) {
            throw new Exception('Gagal memverifikasi OTP: ' . $e->getMessage());
        }
        // throw new Exception('Not implemented');
    }

    public function resetOtp(string $email, string $otpType)
    {
        try {
            if (!$otpType) {
                throw new Exception('Tipe OTP kosong');
            }

            $user = $this->getUserByEmail($email);

            return $this->otpService->generate($user, OtpType::from($otpType));
        } catch (Exception $e) {
            throw new Exception('Gagal mereset OTP: ' . $e->getMessage());
        }
    }

    public function updateVerifiedEmail(string $email)
    {
        try {
            $user = $this->getUserByEmail($email);
            if ($user) {
                $user->update(['email_verified_at' => now()]);
            }
            return $user;
        } catch (Exception $e) {
            throw new Exception('Gagal memverifikasi Email: ' . $e->getMessage());
        }
    }
}
