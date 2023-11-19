<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;

class MahasiswaTaskController extends Controller
{
    public function firstLogin(){
        return view("mahasiswa.first_login");
    }

    public function updateDataPribadi(Request $request){
        $rules = [
            'jalur_masuk' => 'required',
            'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
            'email_sso' => 'required|unique:mahasiswa|regex:/^[a-zA-Z0-9._%+-]+@students\.undip\.ac\.id$/i',
            'alamat' => 'required|max:255',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
            'password' => 'required|min:8|max:16|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
            'konfirmasi_password' => 'required|same:password',
            
        ];

        $errorMessages = [
            'email_sso.regex' => 'Email SSO must end with a domain students.undip.ac.id',
            'password.regex' => 'Password must contain at least one letter and one number',
            'konfirmasi_password.same' => 'Konfirmasi password must be the same as password',
        ];
        
        $validatedData = $request->validate($rules, $errorMessages);
        $new_password = bcrypt($validatedData['password']);
        unset($validatedData['password']);
        unset($validatedData['konfirmasi_password']);

        Mahasiswa::where('nim', auth()->user()->mahasiswa->nim)->update($validatedData);
        auth()->user()->update(['password' => $new_password]); //syntax highlight error, tapi bisa jalan

        return redirect("/dashboard");
    }
}
