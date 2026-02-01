<?php

namespace App\Repositories;

use App\Enums\OtpType;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\Users;
use App\Services\OtpService;
use Exception;
use Illuminate\Support\Facades\Auth;
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
        try 
        {
            $data['password'] = Hash::make($data['password']);
            return $this->user->create($data);
        } catch (Exception $e) {
            throw new Exception('Registrasi gagal: ' . $e->getMessage());
        }
        // throw new Exception('Not implemented');
    }

    public function getUserByEmail(string $email)
    {
        return $this->user->where('email','=', $email)->first();
        // throw new Exception('Not implemented');
    }

    public function updatePasswordByEmail(string $email, string $newPassword)
    {
        $user = $this->user->where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($newPassword)
            ]);
            return $user;
        }

        throw new Exception('Akun tidak ditemukan');
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
        if (!$otpType) {
            throw new Exception('Tipe OTP kosong');
        }

        $user = $this->getUserByEmail($email);

        return $this->otpService->generate($user, OtpType::from($otpType));
        // throw new Exception('Not implemented');
    }

    public function otpVerify(string $email, string $otp, string $otpType)
    {   
        if (!$otpType) {
            throw new Exception('Tipe OTP kosong');
        }

        $user = $this->getUserByEmail($email);

        if (!$user) {
            throw new Exception('Akun tidak ditemukan');
        }

        return $this->otpService->verify($user, OtpType::from($otpType), $otp);
        // throw new Exception('Not implemented');
    }

    public function resetOtp(string $email, string $otpType)
    {
        if (!$otpType) {
            throw new Exception('Tipe OTP kosong');
        }

        $user = $this->getUserByEmail($email);

        return $this->otpService->generate($user, OtpType::from($otpType));
        // throw new Exception('Not implemented');
    }

    public function updateVerifiedEmail(string $email)
    {
        $user = $this->getUserByEmail($email);
        if ($user) {
            $user->update(['email_verified_at' => now()]);
        }
        return $user;
    }
}
