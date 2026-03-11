<?php

namespace App\Http\Controllers;

use App\Models\RtRw;
use App\Repositories\RtRwRepository;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RtRwController extends Controller
{
    protected $rtrwRepository;

    protected $loggingService;

    protected $wilayahService;

    public function __construct(RtRwRepository $rtRwRepository, LoggingService $loggingService, WilayahService $wilayahService)
    {
        $this->rtrwRepository = $rtRwRepository;
        $this->loggingService = $loggingService;
        $this->wilayahService = $wilayahService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        switch ($user->role->roleName) {
            case 'Admin':
                $data = $this->rtrwRepository->getByKelurahan($user->kodeKelurahan);
                break;
            case 'SYSAdmin':
                $data = $this->rtrwRepository->getAll();
                break;
            default:
                abort(403, 'Anda tidak memiliki hak untuk mengakses halaman ini');
        }
        $data = $this->wilayahService->mapWilayahCollection($data);

        // dd($data);

        return view('admin.rt-rw.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;
        $provinces = $this->wilayahService->getProvinces();

        return view('admin.rt-rw.form', compact('data', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            $validate = Validator::make($request->All(), [
                'rt' => ['required', 'numeric', 'max_digits:3'],
                'rw' => ['required', 'numeric', 'max_digits:3'],
                'kodeProvinsi' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKabupaten' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKecamatan' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKelurahan' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'alamatDetail' => ['nullable', 'string']
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('RtRwController', 'Validasi form gagal', null, [
                    'request' => $request->all(),
                    'message' => $validate->errors()
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->all())
                    ->with('error', 'Mohon lengkapi form yang diberikan');
            }

            $kodeProvinsi = null;
            $kodeKabupaten = null;
            $kodeKecamatan = null;
            $kodeKelurahan = null;

            switch ($user->role->roleName) {
                case 'SYSAdmin':
                    $kodeProvinsi = $request->kodeProvinsi;
                    $kodeKabupaten = $request->kodeKabupaten;
                    $kodeKecamatan = $request->kodeKecamatan;
                    $kodeKelurahan = $request->kodeKelurahan;
                    break;
                case 'Admin':
                    $kodeProvinsi = $user->kodeProvinsi;
                    $kodeKabupaten = $user->kodeKabupaten;
                    $kodeKecamatan = $user->kodeKecamatan;
                    $kodeKelurahan = $user->kodeKelurahan;
                    break;
            }

            $input = [
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kodeProvinsi' => $kodeProvinsi,
                'kodeKabupaten' => $kodeKabupaten,
                'kodeKecamatan' => $kodeKecamatan,
                'kodeKelurahan' => $kodeKelurahan,
                'alamatDetail' => $request->alamatDetail
            ];

            $newData = $this->rtrwRepository->store($input);

            if ($request->ajax()) {
                return response()->json(
                    [
                        'message' => 'Data RT/RW telah ditambahkan!',
                        'data' => $newData,
                    ],
                    201,
                );
            }

            return redirect()->route('admin.rt-rw')->with('success', 'Data RT/RW telah ditambahkan!');
        } catch (Exception $e) {
            $this->loggingService->error('RtRwController', 'Terjadi kesalahan sistem.', $e, [
                'request' => $request->all(),
                'method' => 'post'
            ]);

            return redirect()
                ->route('admin.rt-rw')
                ->with('error', 'Terjadi kesalahan sistem. Coba lagi nanti');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->rtrwRepository->getById($id);
        $data = $this->wilayahService->mapWilayahCollection($data);

        return view('admin.rt-rw.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->rtrwRepository->getById($id);
        // $data = $this->wilayahService->mapWilayahCollection($data);
        $provinces = $this->wilayahService->getProvinces();

        return view('admin.rt-rw.form', compact('data', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $data)
    {
        $user = Auth::user();
        try {
            $validate = Validator::make($request->All(), [
                'rt' => ['required', 'numeric', 'max_digits:3'],
                'rw' => ['required', 'numeric', 'max_digits:3'],
                'kodeProvinsi' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKabupaten' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKecamatan' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'kodeKelurahan' => [
                    Rule::requiredIf($user->role->roleName === 'SYSAdmin')
                ],
                'alamatDetail' => ['nullable', 'string']
            ]);

            if ($validate->fails()) {
                $this->loggingService->error('RtRwController', 'Validasi form gagal', null, [
                    'request' => $request->all(),
                    'message' => $validate->errors()
                ]);

                return redirect()
                    ->back()
                    ->withErrors($validate->errors())
                    ->withInput($request->all())
                    ->with('error', 'Mohon lengkapi form yang diberikan');
            }

            $kodeProvinsi = null;
            $kodeKabupaten = null;
            $kodeKecamatan = null;
            $kodeKelurahan = null;

            switch ($user->role->roleName) {
                case 'SYSAdmin':
                    $kodeProvinsi = $request->kodeProvinsi;
                    $kodeKabupaten = $request->kodeKabupaten;
                    $kodeKecamatan = $request->kodeKecamatan;
                    $kodeKelurahan = $request->kodeKelurahan;
                    break;
                case 'Admin':
                    $kodeProvinsi = $user->kodeProvinsi;
                    $kodeKabupaten = $user->kodeKabupaten;
                    $kodeKecamatan = $user->kodeKecamatan;
                    $kodeKelurahan = $user->kodeKelurahan;
                    break;
            }

            $input = [
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kodeProvinsi' => $kodeProvinsi,
                'kodeKabupaten' => $kodeKabupaten,
                'kodeKecamatan' => $kodeKecamatan,
                'kodeKelurahan' => $kodeKelurahan,
                'alamatDetail' => $request->alamatDetail
            ];

            $this->rtrwRepository->update($data, $input);

            return redirect()
                ->route('admin.rt-rw')
                ->with('success', 'Data RT/RW telah Diubah!');
        } catch (Exception $e) {
            $this->loggingService->error('RtRwController', 'Terjadi kesalahan sistem.', $e, [
                'request' => $request->all(),
                'method' => 'put'
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Coba lagi nanti');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->rtrwRepository->getById($id);
        $this->rtrwRepository->delete($data->rtRwId);

        return redirect()
            ->route('admin.rt-rw')
            ->with('success', 'Data RT/RW berhasil dihapus!');
    }

    public function apiGetByKelurahan(int $kelurahanId)
    {
        try {
            $rtrws = $this->rtrwRepository->getByKelurahan($kelurahanId);

            // Transform data to match frontend expectations
            $transformedData = collect($rtrws)->map(function ($rtrw) {
                return [
                    'rtRwId' => $rtrw->rtRwId,
                    'rt' => $rtrw->rt,
                    'rw' => $rtrw->rw,
                    'kodeKelurahan' => $rtrw->kodeKelurahan,
                    'created_at' => $rtrw->created_at,
                    'updated_at' => $rtrw->updated_at
                ];
            });

            return response()->json($transformedData, 200);
        } catch (Exception $e) {
            $this->loggingService->error('RtRwController', 'Gagal mengambil data RT/RW berdasarkan kelurahan', $e, [
                'kelurahanId' => $kelurahanId,
                'method' => 'apiGetByKelurahan'
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data RT/RW',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
