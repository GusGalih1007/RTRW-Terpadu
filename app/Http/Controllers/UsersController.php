<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleOption;
use App\Enums\UserStatusOption;
use App\Enums\OtpType;
use App\Mail\RegisteredUserDataMail;
use App\Mail\RegisteredSubAdminDataMail;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Clock\now;

class UsersController extends Controller
{
    protected $loggingService;

    protected $userRepository;

    protected $wilayahService;

    protected $authService;

    public function __construct(
        UserRepository $userRepository,
        LoggingService $loggingService,
        WilayahService $wilayahService,
        AuthService $authService
    ) {
        $this->userRepository = $userRepository;
        $this->loggingService = $loggingService;
        $this->wilayahService = $wilayahService;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userRepository->getAll();
        $data = $this->wilayahService->mapWilayahCollection($data);

        // dd($data);

        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;
        $provinces = $this->wilayahService->getProvinces();

        return view('user.form', compact('data', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16'],
                'username' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'numeric', 'min_digits:10'],
                'role' => ['nullable', 'in:warga,ketua,petugas,admin,sysadmin'],
                'kodeProvinsi' => ['nullable'],
                'kodeKabupaten' => ['nullable'],
                'kodeKecamatan' => ['nullable'],
                'kodeKelurahan' => ['nullable'],
                'alamatDetail' => ['required', 'string'],
                'status' => ['required'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'rtrw' => ['nullable'],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('UserController', 'Gagal Validasi: '.$validate->errors(), null, [
                    'request' => $request->all(),
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->except('password'))
                    ->with('error', 'Mohon lengkapi form diberikan dengan benar');
            }

            $status = null;
            $authUser = Auth::user();
            $role = null;
            $provinsi = null;
            $kabupaten = null;
            $kecamatan = null;
            $kelurahan = null;
            $rtrw = null;

            if ($request->status == 'Active') {
                $status = UserStatusOption::Active->value;
            } elseif ($request->status == 'InActive') {
                $status = UserStatusOption::InActive->value;
            }

            switch ($authUser->roleId) {
                case UserRoleOption::SYSAdmin->getUuid():
                    $provinsi = $request->kodeProvinsi;
                    $kabupaten = $request->kodeKabupaten;
                    $kecamatan = $request->kodeKecamatan;
                    $kelurahan = $request->kodeKelurahan;
                    $rtrw = $request->rtrw;

                    switch ($request->role) {
                        case 'warga':
                            $role = UserRoleOption::User->getUuid();
                            break;
                        case 'ketua':
                            $role = UserRoleOption::SubAdmin->getUuid();
                            break;
                        case 'petugas':
                            $role = UserRoleOption::Staff->getUuid();
                            break;
                        case 'admin':
                            $role = UserRoleOption::Admin->getUuid();
                            break;
                        case 'sysadmin':
                            $role = UserRoleOption::SYSAdmin->getUuid();
                            break;
                    }
                    break;
                case UserRoleOption::Admin->getUuid():
                    $provinsi = $request->kodeProvinsi;
                    $kabupaten = $request->kodeKabupaten;
                    $kecamatan = $request->kodeKecamatan;
                    $kelurahan = $request->kodeKelurahan;
                    $rtrw = $request->rtrw;

                    switch ($request->role) {
                        case 'warga':
                            $role = UserRoleOption::User->getUuid();
                            break;
                        case 'ketua':
                            $role = UserRoleOption::SubAdmin->getUuid();
                            break;
                    }
                    break;
                case UserRoleOption::SubAdmin->getUuid():
                    $provinsi = $authUser->kodeProvinsi;
                    $kabupaten = $authUser->kodeKabupaten;
                    $kecamatan = $authUser->kodeKecamatan;
                    $kelurahan = $authUser->kodeKelurahan;
                    $rtrw = $authUser->rtRwId;

                    $role = UserRoleOption::User->getUuid();
                    break;
            }

            $input = [
                'nik' => $request->nik,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'roleId' => $role,
                'kodeProvinsi' => $provinsi,
                'kodeKabupaten' => $kabupaten,
                'kodeKecamatan' => $kecamatan,
                'kodeKelurahan' => $kelurahan,
                'alamatDetail' => $request->alamatDetail,
                'status' => $status,
                'pekerjaan' => $request->pekerjaan,
                'anggotaKeluarga' => $request->anggotaKeluarga,
                'password' => $request->password,
                'rtRwId' => $rtrw,
                'roleVerifiedAt' => now(),
                'roleVerifiedBy' => Auth::id() ?? null,
                'createdBy' => Auth::id() ?? null,
            ];

            // Store user data
            $user = $this->userRepository->store($input);

            // Generate OTP for email verification
            $otp = $this->authService->generateOtp($user->email, OtpType::Register->value);

            // Store user ID and OTP type in session for verification
            session([
                'userId' => $user->userId,
                'type' => OtpType::Register->value,
                'userData' => $input, // Store user data for completion after OTP verification
            ]);

            return redirect()
                ->route('auth.verify-otp')
                ->with('success', 'Silakan verifikasi email Anda terlebih dahulu');
        } catch (Exception $e) {
            $this->loggingService->error('UserController', $e->getMessage(), $e, [
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan dalam sistem. Coba lagi nanti')
                ->withInput($request->except('password'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->userRepository->getById($id);

        // Only map wilayah if data exists
        if ($data) {
            // Convert single model to collection for mapping, then get the first item back
            $data = $this->wilayahService->mapWilayahCollection(collect([$data]))->first();
        }

        return view('user.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
