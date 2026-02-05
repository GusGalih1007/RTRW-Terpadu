<?php

namespace App\Http\Controllers;

use App\Enums\OtpType;
use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\OtpMail;
use App\Mail\RegisteredUserDataMail;

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
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Kesalahan Validasi', null, [
                    'request' => $validate->errors(),
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->all())
                    ->with('error', 'Mohon lengkapi form yang diberikan');
            }

            $existingEmail = $this->authService->getUserByEmail($request->email);

            if ($existingEmail && $existingEmail->email_verified_at != null) {
                $this->authService->resendOtp($existingEmail->email, OtpType::Register->value);

                session([
                    'userId' => $existingEmail->userId,
                    'type' => OtpType::Register->value,
                ]);

                return redirect()
                    ->route('auth.verify-otp')
                    ->with('success', 'Silakan verifikasi akun yang telah kamu buat');
            }

            $user = $this->authService->register($request->all());

            session([
                'userId' => $user->userId,
                'type' => OtpType::Register->value,
            ]);

            return redirect()
                ->route('auth.verify-otp')
                ->with('success', 'email');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function showRegisteredProfile(string $userId)
    {
        $user = $this->authService->getUserById($userId);
        $provinces = $this->wilayahService->getProvinces();

        return view('auth.complete-profile', compact('user', 'provinces'));
    }

    public function completeProfile(Request $request, string $userId)
    {
        try {
            // dd($request->all());
            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'min_digits:16', 'max_digits:16'],
                'username' => ['required', 'string', 'min:2', 'max:80'],
                'phone' => ['required', 'min_digits:10', 'max_digits:15'],
                'kodeProvinsi' => ['required'],
                'kodeKabupaten' => ['required'],
                'kodeKecamatan' => ['required'],
                'kodeKelurahan' => ['required'],
                'alamatDetail' => ['required', 'string'],
                'pekerjaan' => ['required', 'string'],
                'anggotaKeluarga' => ['required', 'numeric']
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Kesalahan Validasi', null, [
                    'request' => $validate->errors(),
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->all())
                    ->with('error', 'Mohon lengkapi data anda');
            }

            $user = $this->authService->editProfile($userId, $request->all());

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

            // Send email with user data and QR code
            try {
                Mail::to($user->email)->send(new RegisteredUserDataMail($user));
                
                $this->loggingService->info('AuthController', 'Email data pendaftaran berhasil dikirim', [
                    'email' => $user->email,
                ]);
            } catch (Exception $emailException) {
                $this->loggingService->warning('AuthController', 'Gagal mengirim email data pendaftaran', [
                    'email' => $user->email,
                    'error' => $emailException->getMessage(),
                ]);
            }

        } catch (Exception $e) {
            $this->loggingService->error('AuthController', 'Terjadi Kesalahan Dalam sistem', $e, [
                'request' => $request->all()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan dalam sistem dan gagal melengkapi data. Coba lagi nanti');
        }
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

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->all())
                    ->with('error', 'Mohon lengkapi form yang diberikan');
            }

            $user = $this->authService->getUserByEmail($request->email);

            if (!$user) {
                throw new Exception('Akun dengan email ini tidak ditemukan');
            }

            $this->authService->sendLoginOtp($request->all());

            session([
                'userId' => $user->userId,
                'type' => OtpType::Login->value,
            ]);

            return redirect()
                ->route('auth.verify-otp')
                ->with('success', 'login');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function forgotPasswordPage()
    {
    }

    public function forgotPassword(Request $request)
    {
    }

    public function resetPasswordPage()
    {
    }

    public function resetPassword(Request $request)
    {
    }

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

            if ($type && $userId) {
                if ($type == OtpType::Register->value) {
                    $user = $this->authService->getUserById($userId);

                    $this->authService->verifyOtp($user->email, $request->otp, $type);

                    return redirect()->route('auth.complete-profile', $userId)->with('success', 'Berhasil register. Silakan untuk login');
                } elseif ($type == OtpType::Login->value) {
                    $user = $this->authService->getUserById($userId);

                    if (!$user->email_verified_at) {
                        $otp = $this->authService->generateOtp($user->email, OtpType::Register->value);

                        Mail::to($user->email)->send(new OtpMail($otp, 'Verifikasi Email'));

                        return redirect()
                            ->route('auth.verify-otp')
                            ->with('error', 'Anda belum dapat login karena email anda belum terverifikasi.');
                    }

                    $this->authService->verifyOtp($user->email, $request->otp, $type);

                    $this->authService->login($request->all());

                    return redirect()
                        ->route('welcome')
                        ->with('success', 'Login berhasil. Selamat datang');
                }
            }
            throw new Exception('Session tidak valid. Silakan ulangi proses.');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request->all()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal verifikasi. Coba lagi nanti');
        }
    }

    public function resetOtp()
    {
        try {
            $type = session('type');
            $userId = session('userId');

            if (!$type || !$userId) {
                $this->loggingService->error('AuthController', 'Session tidak valid. Silakan ulangi proses');

                return redirect()->back()->with('error', 'Session tidak valid. Silakan ulangi proses');
            }
            $user = $this->authService->getUserById($userId);

            $this->authService->resendOtp($user->email, $type);

            return redirect()
                ->back()
                ->with('success', 'OTP telah dikirim. Cek Email anda');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'session' => session()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function logout()
    {
        try {
            $this->authService->logout();

            return redirect()
                ->route('auth.login')
                ->with('success', 'Berhasil logout');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', 'Logout failed', $e, []);

            return redirect()
                ->back()
                ->with('error', 'Proses logout gagal. Coba lagi nanti');
        }
    }
}
