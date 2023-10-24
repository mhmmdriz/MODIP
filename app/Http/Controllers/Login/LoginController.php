<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Carbon\Carbon;

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

    public function dosen(){
        return view("dosenwali.khususdosen");
    }

    public function dashboard(){
        if(auth()->user()->level == "mahasiswa"){
            $curr_date = Carbon::now()->setTimezone('Asia/Jakarta');
            $curr_year = $curr_date->year;
            $angkatan = auth()->user()->mahasiswa->angkatan;
            $semester = ($curr_year - $angkatan)*2+1;
            if ($curr_date->month <= 6) {
                $smt = "Genap";
                $thn_ajar = strval($curr_year-1).'/'.strval($curr_year);
                $semester -= 1;
            } else {
                $smt = "Gasal";
                $thn_ajar = strval($curr_year).'/'.strval($curr_year+1);
            }
            return view("mahasiswa.dashboard", [
                'smt' => $smt,
                'thn_ajar' => $thn_ajar,
                'semester' => $semester,
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
