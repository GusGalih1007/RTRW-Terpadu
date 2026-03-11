<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleOption;
use App\Enums\UserStatusOption;
use App\Enums\OtpType;
use App\Mail\OtpMail;
use App\Mail\RegisteredUserDataMail;
use App\Mail\RegisteredSubAdminDataMail;
use App\Mail\RegisteredSysAdminDataMail;
use App\Mail\RegisteredAdminDataMail;
use App\Repositories\RtRwRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function Symfony\Component\Clock\now;

class UsersController extends Controller
{
    protected $loggingService;

    protected $userRepository;

    protected $wilayahService;

    protected $authService;

    protected $rtRwRepository;

    public function __construct(
        UserRepository $userRepository,
        LoggingService $loggingService,
        WilayahService $wilayahService,
        AuthService $authService,
        RtRwRepository $rtRwRepository
    ) {
        $this->userRepository = $userRepository;
        $this->loggingService = $loggingService;
        $this->wilayahService = $wilayahService;
        $this->authService = $authService;
        $this->rtRwRepository = $rtRwRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $data = null;

        switch ($user->role->roleId) {
            case UserRoleOption::SYSAdmin->getUuid():
                $data = $this->userRepository->getAll();
                break;
            case UserRoleOption::Admin->getUuid():
                $data = $this->userRepository->getByKelurahan($user->kodeKelurahan);
                break;
            case UserRoleOption::SubAdmin->getUuid();
                $data = $this->userRepository->getByRtrw($user->rtRwId);
                break;
            default:
                abort(403, 'Anda tidak memiliki hak untuk mengakses halaman ini');
        }
        $data = $this->wilayahService->mapWilayahCollection($data);

        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $data = null;
        $rtrws = null;
        $provinces = $this->wilayahService->getProvinces();
        if (Auth::user()->role->roleName === 'Admin') {
            $rtrws = $this->rtRwRepository->getByKelurahan($user->kodeKelurahan);
        }

        return view('user.form', compact('data', 'provinces', 'rtrws'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $role = Auth::user()->role->roleName;

            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16'],
                'username' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'numeric', 'min_digits:10'],
                'role' => ['nullable', 'in:warga,ketua,petugas,admin,sysadmin'],
                'kodeProvinsi' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKabupaten' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKecamatan' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKelurahan' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'alamatDetail' => ['required', 'string'],
                // 'status' => ['required'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'rtrw' => [
                    Rule::requiredIf(in_array($role, ['SYSAdmin','Admin']))
                ],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('UserController', 'Gagal Validasi: ' . $validate->errors(), null, [
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
            $status = UserStatusOption::Active->value;

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
                    $provinsi = $authUser->kodeProvinsi;
                    $kabupaten = $authUser->kodeKabupaten;
                    $kecamatan = $authUser->kodeKecamatan;
                    $kelurahan = $authUser->kodeKelurahan;
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

            Mail::to($user->email)->send(new OtpMail($otp, 'Verifikasi Email'));

            // Store user ID and OTP type in session for verification
            session([
                'userId' => $user->userId,
                'type' => OtpType::Register->value,
                'method' => 'user-create'
            ]);

            return redirect()
                ->route('user.otp-verification', $user->userId)
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

    public function otpVerificationPage()
    {
        return view('user.otp-verification');
    }

    public function otpVerification(Request $request)
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
                switch ($type) {
                    case OtpType::Register->value:
                        $user = $this->authService->getUserById($userId);

                        $this->authService->verifyOtp($user->email, $request->otp, $type);

                        // Generate QR code for new user
                        try {
                            $qrResult = $this->authService->generateQrImage($userId);

                            $this->loggingService->info('UsersController', 'QR code berhasil dibuat untuk user baru dari UsersController', [
                                'email' => $user->email,
                                'qr_path' => $qrResult['qr_path'],
                            ]);

                            // Refresh user object to include the qrImage field
                            $user = $this->authService->getUserById($userId);
                        } catch (Exception $qrException) {
                            $this->loggingService->warning('UsersController', 'Gagal membuat QR code untuk user baru dari UsersController', [
                                'email' => $user->email,
                                'error' => $qrException->getMessage(),
                            ]);
                        }

                        // Send email with user data and QR code
                        switch ($user->roleId) {
                            case UserRoleOption::SYSAdmin->getUuid():
                                try {
                                    Mail::to($user->email)->send(new RegisteredSysAdminDataMail($user));

                                    $this->loggingService->info('UsersController', 'Email data pendaftaran berhasil dikirim untuk user dari UsersController', [
                                        'email' => $user->email,
                                    ]);
                                } catch (Exception $emailException) {
                                    $this->loggingService->warning('UsersController', 'Gagal mengirim email data pendaftaran untuk user dari UsersController', [
                                        'email' => $user->email,
                                        'error' => $emailException->getMessage(),
                                    ]);
                                }
                                break;
                            case UserRoleOption::Admin->getUuid():
                                try {
                                    Mail::to($user->email)->send(new RegisteredAdminDataMail($user));

                                    $this->loggingService->info('UsersController', 'Email data pendaftaran berhasil dikirim untuk user dari UsersController', [
                                        'email' => $user->email,
                                    ]);
                                } catch (Exception $emailException) {
                                    $this->loggingService->warning('UsersController', 'Gagal mengirim email data pendaftaran untuk user dari UsersController', [
                                        'email' => $user->email,
                                        'error' => $emailException->getMessage(),
                                    ]);
                                }
                                break;
                            case UserRoleOption::SubAdmin->getUuid():
                                try {
                                    Mail::to($user->email)->send(new RegisteredSubAdminDataMail($user));

                                    $this->loggingService->info('UsersController', 'Email data pendaftaran berhasil dikirim untuk user dari UsersController', [
                                        'email' => $user->email,
                                    ]);
                                } catch (Exception $emailException) {
                                    $this->loggingService->warning('UsersController', 'Gagal mengirim email data pendaftaran untuk user dari UsersController', [
                                        'email' => $user->email,
                                        'error' => $emailException->getMessage(),
                                    ]);
                                }
                                break;
                            case UserRoleOption::User->getUuid():
                                try {
                                    Mail::to($user->email)->send(new RegisteredUserDataMail($user));

                                    $this->loggingService->info('UsersController', 'Email data pendaftaran berhasil dikirim untuk user dari UsersController', [
                                        'email' => $user->email,
                                    ]);
                                } catch (Exception $emailException) {
                                    $this->loggingService->warning('UsersController', 'Gagal mengirim email data pendaftaran untuk user dari UsersController', [
                                        'email' => $user->email,
                                        'error' => $emailException->getMessage(),
                                    ]);
                                }
                                break;
                        }

                        // Clear session data
                        session()->forget(['userId', 'type']);

                        return redirect()
                            ->route('user.index')
                            ->with('success', 'Verifikasi email berhasil. Data pengguna telah dikirim ke email Anda');
                    default:
                        $this->loggingService->error('UsersController', 'Tipe OTP tidak diketahui', null, [
                            'OTP Type' => $type,
                        ]);

                        return redirect()
                            ->back()
                            ->with('error', 'Terjadi kesalahan sistem. Coba lagi nanti');
                }
            }
            throw new Exception('Session tidak valid. Silakan ulangi proses.');
        } catch (Exception $e) {
            $this->loggingService->error('UsersController', $e->getMessage(), $e, [
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal verifikasi. ' . $e->getMessage());
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
        $data = $this->userRepository->getById($id);
        $provinces = $this->wilayahService->getProvinces();

        return view('user.form', compact('data', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Auth::user()->role->roleName;

            $validate = Validator::make($request->all(), [
                'nik' => ['required', 'numeric', 'max_digits:16', 'min_digits:16'],
                'username' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'numeric', 'min_digits:10'],
                'role' => ['nullable', 'in:warga,ketua,petugas,admin,sysadmin'],
                'kodeProvinsi' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKabupaten' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKecamatan' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'kodeKelurahan' => [
                    Rule::requiredIf($role === 'SYSAdmin')
                ],
                'alamatDetail' => ['required', 'string'],
                // 'status' => ['required'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric'],
                'password' => ['nullable', 'string', 'confirmed', 'min:8'],
                'rtrw' => [
                    Rule::requiredIf(in_array($role, ['SYSAdmin','Admin']))
                ],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('UserController', 'Gagal Validasi: ' . $validate->errors(), null, [
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
            $status = UserStatusOption::Active->value;

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
                // 'password' => $request->password,
                'rtRwId' => $rtrw,
                'roleVerifiedAt' => now(),
                'roleVerifiedBy' => Auth::id() ?? null,
                'createdBy' => Auth::id() ?? null,
            ];

            if (filled(value: $request->password)) {
                $input['password'] = $request->password;
            }

            // Store user data
            $user = $this->userRepository->update($id, $input);

            // Generate OTP for email verification
            $otp = $this->authService->generateOtp($user->email, OtpType::Register->value);

            Mail::to($user->email)->send(new OtpMail($otp, 'Verifikasi Perubahan Data'));

            // Store user ID and OTP type in session for verification
            session([
                'userId' => $user->userId,
                'type' => OtpType::Register->value,
                'method' => 'user-update'
            ]);

            return redirect()
                ->route('user.otp-verification', $user->userId)
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }

    public function roleApprove($id, $role)
    {
        try {
            $input = [
                'roleVerifiedAt' => now(),
                'roleVerifiedBy' => Auth::user()->userId,
                'status' => null
            ];

            switch ($role) {
                case 'active':
                    $input['status'] = UserStatusOption::Active->value;
                    break;
                case 'rejected':
                    $input['status'] = UserStatusOption::Rejected->value;
                    break;
                default:
                    $input['status'] = UserStatusOption::Pending->value;
            }

            $this->userRepository->update($id, $input);

            return redirect()
                ->back()
                ->with('success', 'Status pengguna berhasil diverifikasi!');
        } catch (Exception $e) {
            $this->loggingService->error('UserController', 'Gagal merubah data status', $e, [
                'id' => $id,
                'input' => [
                    'role-approval' => $role
                ]
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal merubah status karena kesalahan sistem. Coba lagi nanti');
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $input = [
                'status' => null
            ];

            switch ($status) {
                case 'active':
                    $input['status'] = UserStatusOption::Active->value;
                    break;
                case 'inactive':
                    $input['status'] = UserStatusOption::InActive->value;
                    break;
                default:
                    $input['status'] = UserStatusOption::Pending->value;
            }

            $this->userRepository->update($id, $input);

            return redirect()
                ->back()
                ->with('success', 'Status pengguna berhasil diverifikasi!');
        } catch (Exception $e) {
            $this->loggingService->error('UserController', 'Gagal merubah data status', $e, [
                'id' => $id,
                'input' => [
                    'status-update' => $status
                ]
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal merubah status karena kesalahan sistem. Coba lagi nanti');
        }
    }
}
