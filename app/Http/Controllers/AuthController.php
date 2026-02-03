<?php

namespace App\Http\Controllers;

use App\Enums\OtpType;
use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    protected $loggingService;

    protected $wilayahService;

    public function __construct(AuthService $authService, LoggingService $loggingService, WilayahService $wilayahService)
    {
        $this->authService = $authService;
        $this->loggingService = $loggingService;
        $this->wilayahService = $wilayahService;
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16'],
                'username' => ['required', 'string', 'max:80'],
                'phone' => ['required', 'numeric', 'min_digits:11', 'max_digits:20'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'kodeProvinsi' => ['nullable', 'numeric', 'max_digits:2'],
                'kodeKabupaten' => ['nullable', 'numeric', 'max_digits:4'],
                'kodeKecamatan' => ['nullable', 'numeric', 'max_digits:7'],
                'kodeKelurahan' => ['nullable', 'numeric', 'max_digits:10'],
                'alamatDetail' => ['required', 'string'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric'],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Kesalahan Validasi', null, [
                    'request' => $validate->errors(),
                ]);

                return redirect()->back()->withErrors($validate->errors())->withInput($request->all())->with('error', 'Mohon lengkapi data anda');
            }

            $existingEmail = $this->authService->getUserByEmail($request->email);

            if ($existingEmail && $existingEmail->email_verified_at != null) {
                $this->authService->resendOtp($existingEmail->email, OtpType::Register->value);

                session([
                    'userId' => $existingEmail->userId,
                    'type' => OtpType::Register->value,
                ]);

                return redirect()->route('auth.verify-otp')->with('success', 'Silakan verifikasi akun yang telah kamu buat');
            }

            $user = $this->authService->register($request->all());

            session([
                'userId' => $user->userId,
                'type' => OtpType::Register->value,
            ]);

            return redirect()->route('auth.verify-otp');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request,
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function showQrImage(string $userId)
    {
        $user = $this->authService->getUserById($userId);

        return view('auth.showQr', compact($user));
    }

    public function loginPage()
    {
        // dd(Auth::user());
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'min:8'],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Gagal Validasi', null, [
                    'request' => $request->all(),
                ]);
            }

            $this->authService->sendLoginOtp($request->all());

            session([
                'email' => $request->email,
                'type' => OtpType::Login->value,
            ]);

            return redirect()->route('auth.verify-otp');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request,
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function forgotPasswordPage() {}

    public function forgotPassword(Request $request) {}

    public function resetPasswordPage() {}

    public function resetPassword(Request $request) {}

    public function verifyOtpPage()
    {
        return view('auth.otp-verification');
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'otp' => ['required', 'numeric'],
            ]);

            if ($validate->fails()) {
                throw new Exception('Data OTP tidak valid');
            }

            $type = session('type');
            $userId = session('userId');
            $email = session('email');

            if ($type && $userId || $email) {
                if ($type == OtpType::Register->value) {
                    $user = $this->authService->getUserById($userId);

                    $this->authService->verifyOtp($user->email, $request->otp, $type);

                    // Generate QR code for new user
                    $qrResult = $this->authService->generateQrImage($userId);

                    if ($qrResult['success']) {
                        $this->loggingService->info('AuthController', 'QR code berhasil dibuat untuk user baru', [
                            'email' => $user->email,
                            'qr_path' => $qrResult['qr_path'],
                        ]);
                    } else {
                        $this->loggingService->warning('AuthController', 'Gagal membuat QR code untuk user baru', [
                            'email' => $user->email,
                            'error' => $qrResult['message'],
                        ]);
                    }

                    return redirect()->route('auth.show-user-qr', $userId)->with('success', 'Berhasil register. Silakan untuk login');
                } elseif ($type == OtpType::Login->value) {
                    $this->authService->verifyOtp($email, $request->otp, $type);

                    $user = $this->authService->getUserByEmail($email);

                    Auth::login($user);

                    request()->session()->regenerate();
                    session()->forget(['email', 'type']);

                    return redirect()->route('welcome')->with('success', 'Login berhasil. Selamat datang');
                }
            }
            throw new Exception('Session tidak valid. Silakan ulangi proses.');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, []);

            return redirect()->back()->with('error', 'Gagal verifikasi. Coba lagi nanti');
        }
    }

    public function resetOtp()
    {
        try {
            $type = session('type');
            $userId = session('userId');
            $email = session('email');

            if (! $type || ! $email || ! $userId) {
                $this->loggingService->error('AuthController', 'Session tidak valid. Silakan ulangi proses');

                return redirect()->back()->with('error', 'Session tidak valid. Silakan ulangi proses');
            }

            if ($type === OtpType::Register->value) {
                $user = $this->authService->getUserById($userId);

                $this->authService->resendOtp($user->email, $type);
            } elseif ($type == OtpType::Login->value) {
                $this->authService->resendOtp($email, $type);
            }

            return redirect()->back()->with('success', 'OTP telah dikirim. Cek Email anda');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, []);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function logout()
    {
        try {
            $this->authService->logout();

            return redirect()->route('auth.login')->with('success', 'Berhasil logout');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', 'Logout failed', $e, []);

            return back()->with('error', 'Proses logout gagal. Coba lagi nanti');
        }
    }
}
