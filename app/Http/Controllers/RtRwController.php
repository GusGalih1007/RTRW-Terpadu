<?php

namespace App\Http\Controllers;

use App\Models\RtRw;
use App\Repositories\RtRwRepository;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->All(), [
                'rt' => ['required', 'numeric', 'max_digits:3'],
                'rw' => ['required', 'numeric', 'max_digits:3'],
                'kodeProvinsi' => ['required'],
                'kodeKabupaten' => ['required'],
                'kodeKecamatan' => ['required'],
                'kodeKelurahan' => ['required'],
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

            $input = [
                'nomor' => $request->rt . '/' . $request->rw,
                'kodeProvinsi' =>  $request->kodeProvinsi,
                'kodeKabupaten' => $request->kodeKabupaten,
                'kodeKecamatan' => $request->kodeKecamatan,
                'kodeKelurahan' => $request->kodeKelurahan,
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

            return redirect()->route('')->with('success', 'Data RT/RW telah ditambahkan!');
        } catch (Exception $e) {
            $this->loggingService->error('RtRwController', 'Terjadi kesalahan sistem.', $e, [
                'request' => $request->all(),
                'method' => 'store'
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Coba lagi nanti');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RtRw $rtRw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RtRw $rtRw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RtRw $rtRw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RtRw $rtRw)
    {
        //
    }

    public function apiGetByKelurahan(int $kelurahanId)
    {
        try {
            $rtrws = $this->rtrwRepository->getByKelurahan($kelurahanId);

            // Transform data to match frontend expectations
            $transformedData = $rtrws->map(function ($rtrw) {
                return [
                    'rtRwId' => $rtrw->rtRwId,
                    'nomor' => $rtrw->nomor,
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
