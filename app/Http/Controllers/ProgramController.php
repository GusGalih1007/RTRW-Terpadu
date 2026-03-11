<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Repositories\ProgramRepository;
use App\Repositories\RtRwRepository;
use App\Services\LoggingService;
use App\Services\WilayahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    protected $programRepository;
    protected $rtRwRepository;
    protected $loggingService;
    protected $wilayahService;

    public function __construct(
        ProgramRepository $programRepository,
        LoggingService $loggingService,
        RtRwRepository $rtRwRepository,
        WilayahService $wilayahService
        )
    {
        $this->programRepository = $programRepository;
        $this->loggingService = $loggingService;
        $this->rtRwRepository = $rtRwRepository;
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
                $data = $this->programRepository->getAll();
                $data = $this->wilayahService->mapWilayahCollection($data->rtrw);
                break;
            case 'Sub-Admin':
                $data = $this->programRepository->getByRtrw($user->rtrw->rtRwId);
                $data = $this->wilayahService->mapWilayahCollection($data->rtrw);
                break;
        }

        return view('subadmin.program.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rtrw = $this->rtRwRepository->getAll();
        $data = null;

        return view('subadmin.program.form', compact('data', 'rtrw'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        //
    }
}
