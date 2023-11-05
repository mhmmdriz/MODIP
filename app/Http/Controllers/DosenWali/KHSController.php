<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });
        // dd($data_mhs);

        return view("dosenwali.khs.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_khs = KHS::get()->groupBy('nim')->map(function($item) {
            return [
                'sksk' => $item->sum('sks'),
                'ipk' => $item->avg('ips'),
        ];
        });
        // dd($data_khs);
        
        return view("dosenwali.khs.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_khs"=> $data_khs,
            "angkatan"=> $angkatan,
        ]);
    }

    // public function showKHSMhs($angkatan, $nim){
    //     $mahasiswa = Mahasiswa::where("nim", $nim)->first();
    //     $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
    //     $semester = $semesterInfo['semester'];
        
    //     $dataKHS = KHS::get()->where('nim', $nim);
    //     $SKSk = $dataKHS->sum('sks');
    //     $IPk = $dataKHS->avg('ips');
    //     dd($dataKHS);
        
    //     return view('dosenwali.khs.show_khs', [
    //         'nim' => $nim,
    //         'dataKHS' => $dataKHS,
    //         'SKSk' => $SKSk,
    //         'IPk' => $IPk,
    //         'semester' => $semester,
    //     ]);
    // }

    public function showKHSMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
        $semester = $semesterInfo['semester'];
        
        $dataKHS = $mahasiswa->getKHSArray($semester);
        $IPk = KHS::get()->where('nim', $nim)->avg('ips');
        // dd($dataKHS['arrKHS']);
        $arrKHS = $dataKHS['arrKHS'];
        $SKSk = $dataKHS['SKSk'];

        return view('dosenwali.khs.show_khs', [
            'nim' => $nim,
            'khs' => $arrKHS,
            'semester' => $semester,
            // 'smtIRSArray' => $smtIRSArray,
            'SKSk' => $SKSk,
            'IPk' => $IPk,
            'angkatan' => $angkatan
        ]);
    }

    public function updateKHSMhs($angkatan, $nim, Request $request){
        $validated_data = $request->validate([
            'sks' => 'required',
            'ips' => 'required',
        ]);

        KHS::where('nim','=',$nim)->where('smt', '=', $request->smt)->update($validated_data);

        return redirect("/khsPerwalian/$angkatan/$nim")->with('success', "Data KHS Semester $request->smt Berhasil Diubah!");
    }

    public function validateKHS(){
        if(request('validasi') == 1){
            KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 1]);
        }else{
            KHS::where('nim', '=', request('nim'))->where('smt', '=', request('smt'))->update(['validasi' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => request('validasi'),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
