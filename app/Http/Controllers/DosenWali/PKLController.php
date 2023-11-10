<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PKLController extends Controller
{
    public function index()
    {
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });

        return view("dosenwali.pkl.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_pkl = PKL::pluck('validasi', 'nim')->toArray();
        // dd($data_pkl);
        
        return view("dosenwali.pkl.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_pkl"=> $data_pkl,
            'angkatan' => $angkatan,
        ]);
    }

    public function showPKLMhs($angkatan, $nim){
        $mahasiswa = Mahasiswa::where("nim","=",$nim)->first();
        
        $dataPKL = $mahasiswa->pkl;

        return view('dosenwali.pkl.show_pkl', [
            'nim' => $nim,
            'nama' => $mahasiswa->nama,
            'dataPKL' => $dataPKL,
            'angkatan' => $angkatan,
        ]);
    }

    public function updatePKLMhs($angkatan, $nim, Request $request){
        $status = $request->status;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        // $nim = $mahasiswa->nim;
        $nama = $mahasiswa->nama;
        $validasi = 0;
        // dd($request->status_old);
        if ($status == ""){
            return redirect("/pklPerwalian/$angkatan/$nim");
        }
        if ($request->status_old == null){
            if ($status == "Belum Ambil"){
                PKL::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else if ($status == "Sedang Ambil") {
                PKL::create(['nim' => $nim, 'nama' => $nama, 'status' => $status, 'validasi' => $validasi]);
            } else {
                $rules = [ 
                    'tanggal_seminar' => 'required',
                    'nilai' => 'required',
                ];
                
                $tgl_seminar = Carbon::parse($request->tanggal_seminar);
                $semester = ($tgl_seminar->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_seminar->gt(Carbon::createFromDate($tgl_seminar->year, 2, 15)) && $tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_basp != null){
                    $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
                }
                $validatedData['semester'] = $semester;
                $validatedData['nim'] = $nim;
                $validatedData['nama'] = $nama;
                $validatedData['status'] = $status;
                $validatedData['validasi'] = $validasi;
                // dd($semester);
                PKL::create($validatedData);
            }
        } else {
            if ($status == "Belum Ambil"){
                PKL::where("nim", $nim)->update(['status' => $status, 'semester' => null, 'tanggal_seminar' => null, 'nilai' => null, 'scan_basp' => null]);
            } else if ($status == "Sedang Ambil") {
                PKL::where("nim", $nim)->update(['status' => $status, 'semester' => null, 'tanggal_seminar' => null, 'nilai' => null, 'scan_basp' => null]);
            } else {
                $rules = [ 
                    'tanggal_seminar' => 'required',
                    'nilai' => 'required',
                ];
                
                $tgl_seminar = Carbon::parse($request->tanggal_seminar);
                $semester = ($tgl_seminar->year - $mahasiswa->angkatan) * 2 + 1;
                if ($tgl_seminar->gt(Carbon::createFromDate($tgl_seminar->year, 2, 15)) && $tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 8, 15))) {
                    $semester -= 1;
                } else if ($tgl_seminar->lte(Carbon::createFromDate($tgl_seminar->year, 2, 15))) {
                    $semester -= 2;
                }
                $validatedData = $request->validate($rules);
                if($request->scan_basp != null){
                    $validatedData ["scan_basp"] = $request->file('scan_basp')->store('private/pkl');
                }
                $validatedData['semester'] = $semester;
                // $validatedData['nim'] = $nim; 1
                // $validatedData['nama'] = $nama; 2
                $validatedData['status'] = $status;
                // $validatedData['validasi'] = $validasi; 3
                // dd($semester);
                PKL::where("nim", $nim)->update($validatedData);
            }
            
        }
        return redirect("/pklPerwalian/$angkatan/$nim")->with('success', "Data PKL Berhasil Diubah!");
    }

    public function validatePKL($angkatan, $nim, $validate){

        PKL::where('nim', '=', $nim)->update(['validasi' => $validate]);

        return redirect("/pklPerwalian/$angkatan/$nim");
    }
}
