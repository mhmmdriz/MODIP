<?php

namespace App\Http\Controllers;

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
            return view("dosenwali.dashboard");
        }
        if(auth()->user()->level == "departemen"){
            return view("departemen.dashboard");
        }
        if(auth()->user()->level == "operator"){
            return view("operator.dashboard");
        }
    }
    
}
