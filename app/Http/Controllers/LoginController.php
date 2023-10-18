<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

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

            return redirect()->intended('/');
        }
        
        // jika ingin menggunakan flash message saja menggunakan with
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
