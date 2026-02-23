<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Repositories\ProgramRepository;
use App\Repositories\RtRwRepository;
use App\Services\LoggingService;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    protected $programRepository;
    protected $rtRwRepository;
    protected $loggingService;

    public function __construct(
        ProgramRepository $programRepository,
        LoggingService $loggingService,
        RtRwRepository $rtRwRepository
        )
    {
        $this->programRepository = $programRepository;
        $this->loggingService = $loggingService;
        $this->rtRwRepository = $rtRwRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->programRepository->getAll();

        return view('subadmin.program', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rtrw = $this->rtRwRepository->getAll(  );
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
