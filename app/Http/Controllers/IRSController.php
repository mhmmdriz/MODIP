<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Http\Requests\StoreIRSRequest;
use App\Http\Requests\UpdateIRSRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class IRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        // $irs = IRS::where('nim', auth()->user()->username)->get();
        
        $dataIRS = $mahasiswa->getIRSArray($semester);
        $smtIrsArray = $dataIRS['smtIrsArray'];
        $arrIRS = $dataIRS['arrIRS'];
        $SKSk = $dataIRS['SKSk'];

        // dump($SKSk);
        // dump($smtIrsArray);
        // dd($arrIRS);

        return view('mahasiswa.irs.index', [
            'irs' => $arrIRS,
            'semester' => $semester,
            'smtIrsArray' => $smtIrsArray,
            'SKSk' => $SKSk,
        ]);
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
    public function store(StoreIRSRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IRS $iRS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IRS $iRS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrInsert(Request $request)
    {
        $rules = [
            'sks' => 'required',
        ];

        if ($request->scan_irs_old == null) {
            $rules['scan_irs'] = 'required|mimes:pdf|max:10000';
        }else{
            Storage::delete("private/".$request->scan_irs_old);
        }

        $validatedData = $request->validate($rules);
        $mahasiswa = auth()->user()->mahasiswa;
        
        $validatedData['nama'] = $mahasiswa->nama;
        if($request->scan_irs != null){
            $validatedData ["scan_irs"] = $request->file('scan_irs')->store('private/irs');
        }

        if($request->scan_irs_old == null){
            $validatedData['smt'] = $request->smt;
            $validatedData['nim'] = $mahasiswa->nim;
            $validatedData['validasi'] = 0;
            IRS::create($validatedData);
        }else{
            IRS::where("smt", $request->smt)->where("nim",$mahasiswa->nim)->update($validatedData);
        }

        

        return redirect('/irs')->with('success', "Data IRS Semester $request->smt Berhasil Diubah!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IRS $irs)
    {
        //
    }

    public function showIRS($filename)
    {
        $filePath = asset('/storage/irs/'.$filename);

        // $path = Storage::path('tes');

        // return redirect($filePath);
        
        $path = Storage::path('private\irs\\'.$filename);
        // dd(Storage::exists($filename));
        // dd($path);
        return response()->file($path);
    }

    // public function __invoke()
    // {
        
    // }
}
