<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;
use App\Enums\OtpType;

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
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16', 'unique:users,nik'],
                'username' => ['required', 'string', 'max:80'],
                'phone' => ['required', 'numeric', 'min_digits:11', 'max_digits:20'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'kodeProvinsi' => ['nullable', 'numeric', 'max_digits:2'],
                'kodeKabupaten' => ['nullable', 'numeric', 'max_digits:4'],
                'kodeKecamatan' => ['nullable', 'numeric', 'max_digits:7'],
                'kodeKelurahan' => ['nullable', 'numeric', 'max_digits:10'],
                'alamatDetail' => ['required', 'string'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric']
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Kesalahan Validasi', null, [
                    'request' => $validate->errors()
                ]);
                return redirect()->back()->withErrors($validate->errors())->withInput($request->all())->with('error', 'Mohon lengkapi data anda');
            }

            $user = $this->authService->register($request->all());

            session([
                'email' => $user->email,
                'type' => OtpType::Register->value
            ]);

            return redirect()->route('auth.verify-otp');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required', 'min:8']
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('AuthController', 'Gagal Validasi', null, [
                    'request' => $request->all()
                ]);
            }

            $this->authService->sendLoginOtp($request->email);

            session([
                'email' => $request->email,
                'type' => OtpType::Login->value
            ]);

            return redirect()->route('');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, [
                'request' => $request
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function forgotPasswordPage()
    {
        return view('');
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
                'otp',
                ['required', 'numeric']
            ]);

            if (!$validate) {
                throw new Exception('Session tidak valid. Silakan ulangi proses.');
            }

            $type = session('type');
            $email = session('email');

            if (!$type || !$email) {
                $this->loggingService->error('AuthController', 'Session tidak valid. Silakan ulangi proses');
            }

            $this->authService->verifyOtp($email, $request->otp, $type);

            session()->forget(['email', 'type']);

            if ($type === 'register') {
                return redirect()->route('auth.login')->with('success', 'Berhasil register. Silakan untuk login');
            }

            if ($type === 'login') {
                $user = $this->authService->login($email);
                return redirect()->route('/')->with('success', 'Login berhasil. Selamat datang, ' . $user->username);
            }
            
            throw new Exception('Tipe OTP tidak dikenali.');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, []);

            return redirect()->back()->with('error', 'Gagal verifikasi. Coba lagi nanti');
        }
    }

    public function resetOtp()
    {
        try
        {
            $type = session('type');
            $email = session('email');

            if (!$type || !$email) {
                $this->loggingService->error('AuthController', 'Session tidak valid. Silakan ulangi proses');
            }

            $this->authService->resendOtp($email, $type);

            return redirect()->back()->with('success', 'OTP telah dikirim. Cek Email anda');
        } catch (Exception $e) {
            $this->loggingService->error('AuthController', $e->getMessage(), $e, []);
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti');
        }
    }

    public function logout()
    {

    }
}
