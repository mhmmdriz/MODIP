<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaTaskController extends Controller
{
    public function firstLogin(){
        return view("mahasiswa.first_login");
    }

    public function updateDataPribadi(Request $request){
        $rules = [
            'jalur_masuk' => 'required',
            'no_telp' => 'required|numeric',
            'email_sso' => 'required|regex:/^[a-zA-Z]+@students\.undip\.ac\.id$/',
            'alamat' => 'required',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
        ];

        $errorMassages = [
            'email_sso.regex' => 'Email SSO harus berakhiran @students.undip.ac.id',
        ];
        
        $validatedData = $request->validate($rules, $errorMassages);
        
        Mahasiswa::where('nim', auth()->user()->mahasiswa->nim)->update($validatedData);

        return redirect("/dashboard");
    }
}
