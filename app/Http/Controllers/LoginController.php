<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\PKL;
use App\Models\Skripsi;

class LoginController extends Controller
{
    public function index(){
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // dd(User::all());

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // tidak langsung ditulis pada redirect, tetapi menggunakkan method intended supaya melewati middleware terlebih dahulu
            // penjelasan lebih lanjut ada di docs
            // dd(auth());

            return redirect()->intended('/dashboard');
        }
        
        // jika ingin menggunakan flash message saja menggunakan with
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }

    public function dashboard(){
        if(auth()->user()->level == "mahasiswa"){
            $mahasiswa = auth()->user()->mahasiswa;
            $semesterInfo = $mahasiswa->calculateSemesterAndThnAjar();
            $semester = $semesterInfo['semester'];

            $arrIRS = $mahasiswa->irs;
            $SKSkIRS = 0;
            foreach($arrIRS as $irs){
                $SKSkIRS += $irs->sks;
            }

            $arrKHS = $mahasiswa->khs;
            $SKSk = 0;
            $IPk = 0;
            $n = 0;
            foreach($arrKHS as $khs){
                $SKSk += $khs->sks;
                $IPk += $khs->ips;
                $n++;
            }
            if($n > 0){
                $IPk = $IPk/$n;
            }

            $data_skripsi = $mahasiswa->skripsi;
            $data_pkl = $mahasiswa->pkl;
            // dd($arrKHS);
            
            return view("mahasiswa.dashboard", $semesterInfo, [
                "SKSk" => $SKSk,
                "IPk" => $IPk,
                "mahasiswa" => $mahasiswa,
                "semester" => $semester,
                "data_skripsi" => $data_skripsi,
                "data_pkl" => $data_pkl,
                "arrIRS" => $arrIRS,
                "arrKHS" => $arrKHS,
                "SKSkIRS" => $SKSkIRS,
                "SKSkKHS" => $SKSk,
            ]);
        }
        if(auth()->user()->level == "dosenwali"){
            $total_mahasiswa = Mahasiswa::selectRaw('count(mahasiswa.nim) as jumlah')->where("dosen_wali", auth()->user()->username)->first();
            $rekap_status = Mahasiswa::selectRaw('status, count(mahasiswa.nim) as jumlah')->groupBy('status')->where("dosen_wali", auth()->user()->username)->get();
            $lulus_pkl = PKL::selectRaw('count(mahasiswa.nim) as jumlah')->where("validasi", "1")->join("mahasiswa", "mahasiswa.nim", "pkl.nim")->where("dosen_wali", auth()->user()->username)->first();
            $rekap_pkl = [
                "sudah" => $lulus_pkl->jumlah,
                "belum" => $total_mahasiswa->jumlah - $lulus_pkl->jumlah
            ];
            
            $lulus_skripsi = Skripsi::selectRaw('count(mahasiswa.nim) as jumlah')->where("validasi", "1")->join("mahasiswa", "mahasiswa.nim", "skripsi.nim")->where("dosen_wali", auth()->user()->username)->first();
            $rekap_skripsi = [
                "sudah" => $lulus_skripsi->jumlah,
                "belum" => $total_mahasiswa->jumlah - $lulus_skripsi->jumlah
            ];
            
            return view("dosenwali.dashboard", [
                "rekap_status" => $rekap_status,
                "rekap_pkl" => $rekap_pkl,
                "rekap_skripsi" => $rekap_skripsi
            ]);
        }
        if(auth()->user()->level == "departemen"){
            $total_mahasiswa = Mahasiswa::selectRaw('count(*) as jumlah')->first();
            $rekap_status = Mahasiswa::selectRaw('status, count(*) as jumlah')->groupBy('status')->get();
            $lulus_pkl = PKL::selectRaw('count(*) as jumlah')->where("validasi", "1")->first();
            $rekap_pkl = [
                "sudah" => $lulus_pkl->jumlah,
                "belum" => $total_mahasiswa->jumlah - $lulus_pkl->jumlah
            ];
            
            $lulus_skripsi = Skripsi::selectRaw('count(*) as jumlah')->where("validasi", "1")->first();
            $rekap_skripsi = [
                "sudah" => $lulus_skripsi->jumlah,
                "belum" => $total_mahasiswa->jumlah - $lulus_skripsi->jumlah
            ];

            
            return view("departemen.dashboard", [
                "rekap_status" => $rekap_status,
                "rekap_pkl" => $rekap_pkl,
                "rekap_skripsi" => $rekap_skripsi
            ]);
        }
        if(auth()->user()->level == "operator"){
            return view("operator.dashboard");
        }
    }
    
}
