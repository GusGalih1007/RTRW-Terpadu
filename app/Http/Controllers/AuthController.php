<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

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
        return view('');
    }

    public function register(Request $request)
    {
        try 
        {
            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16', 'unique:users,nik'],
                'username' => ['required', 'string', 'max:80'],
                'phone' => ['required', 'numeric', 'min_digits:11', 'max_digits:20'],
                'email' => ['required', 'string', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
                'kodeProvinsi' => ['nullable', 'numeric', 'max_digits:2'],
                'kodeKabupaten' => ['nullable', 'numeric', 'max_digits:4'],
                'kodeKecamatan' => ['nullable', 'numeric', 'max_digits:7'],
                'kodeKelurahan' => ['nullable', 'numeric', 'max_digits:10'],
                'alamatDetail' => ['required', 'string'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric']
            ]);

        } catch (Exception $e) {
            $this->loggingService->error('AuthController', 'Terjadi kesalahan sistem', $e, [
                'request' => $request
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam sistem, coba lagi nanti');
        }
    }
}
