<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleOption;
use App\Models\Users;
use App\Repositories\UserRepository;
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

    public function __construct(
        UserRepository $userRepository,
        LoggingService $loggingService,
        WilayahService $wilayahService
    ) {
        $this->userRepository = $userRepository;
        $this->loggingService = $loggingService;
        $this->wilayahService = $wilayahService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userRepository->getAll();
        $data = $this->wilayahService->mapWilayahCollection($data);

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
                'nik' => ['required', 'integer', 'max_digits:16', 'min_digits:16'],
                'username' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'numeric', 'min_digits:10'],
                'role' => ['required', 'in:warga,ketua,petugas,admin,sysadmin'],
                'kodeProvinsi' => ['required'],
                'kodeKabupaten' => ['required'],
                'kodeKecamatan' => ['required'],
                'kodeKelurahan' => ['required'],
                'alamatDetail' => ['required', 'string'],
                'status' => ['required'],
                'pekerjaan' => ['required', 'string', 'max:100'],
                'anggotaKeluarga' => ['required', 'numeric'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'rtrwId' => ['required'],
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('UserController', 'Gagal Validasi: ' . $validate->errors(), null, [
                    'request' => $request->all()
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->except('password'))
                    ->with('error', 'Mohon lengkapi form diberikan dengan benar');
            }

            $role = null;

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
            
            $input = [
                'nik' => $request->nik,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'roleId' => $role,
                'kodeProvinsi' => $request->kodeProvinsi,
                'kodeKabupaten' => $request->kodeKabupaten,
                'kodeKecamatan' => $request->kodeKecamatan,
                'kodeKelurahan' => $request->kodeKelurahan,
                'alamatDetail' => $request->alamatDetail,
                'status' => $request->status,
                'pekerjaan' => $request->pekerjaan,
                'anggotaKeluarga' => $request->anggotaKeluarga,
                'password' => $request->password,
                'rtRwId' => $request->rtrwId,
                'roleVerifiedAt' => now(),
                'roleVerifiedBy' => Auth::id() ?? null,
                'createdBy' => Auth::id() ?? null,
            ];

            $this->userRepository->store($input);

            return redirect()
                ->route('')
                ->with('success', 'Data pengguna berhasi ditambahkan');
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
        //
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
        //
    }
}
