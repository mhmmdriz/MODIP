<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\DosenWali;
use App\Models\Departemen;
use App\Models\Operator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function viewProfile(){
        if(auth()->user()->level == "mahasiswa"){
            return view('mahasiswa.profile.index');
        }
        if(auth()->user()->level == "dosenwali"){
            return view('dosenwali.profile.index');
        }
        if(auth()->user()->level == "departemen"){
            return view('departemen.profile.index');
        }
        if(auth()->user()->level == "operator"){
            return view('operator.profile.index');
        }
    }

    public function editProfile(){
        if(auth()->user()->level == "mahasiswa"){
            return view('mahasiswa.profile.edit');
        }
        if(auth()->user()->level == "dosenwali"){
            return view('dosenwali.profile.edit');
        }
        if(auth()->user()->level == "departemen"){
            return view('departemen.profile.edit');
        }
        if(auth()->user()->level == "operator"){
            return view('operator.profile.edit');
        }
    }

    public function updateProfile(Request $request){
        if(auth()->user()->level == "mahasiswa"){
            $rules = [
                'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
                'email_sso' => [
                    'required',
                    Rule::unique('mahasiswa')->ignore(auth()->user()->mahasiswa, 'email_sso'),
                    'regex:/^[a-zA-Z0-9._%+-]+@students\.undip\.ac\.id$/i',
                ],
                'alamat' => 'required|max:255',
                'kabupaten_kota' => 'required',
                'provinsi' => 'required',
            ];
    
            if($request->file('foto_profil')){
                $rules['foto_profil'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            }
    
            $errorMassages = [
                'email_sso.regex' => 'Email SSO harus berakhiran dengan domain students.undip.ac.id',
            ];
            
            $validatedData = $request->validate($rules, $errorMassages);
    
            $foto = auth()->user()->mahasiswa->foto_profil;
            if($request->foto_profil){
                if($foto){
                    Storage::delete($foto);
                }
                $validatedData ["foto_profil"] = $request->file('foto_profil')->store('private/profile_photo');
            }
    
            Mahasiswa::where('nim', auth()->user()->mahasiswa->nim)->update($validatedData);
    
            return redirect('/profile')->with('success', 'Profile berhasil diubah');
        }
        if(auth()->user()->level == "dosenwali"){
            $rules = [
                'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
                'email_sso' => [
                    'required',
                    Rule::unique('dosen_wali')->ignore(auth()->user()->dosen_wali, 'email_sso'),
                    'regex:/^[a-zA-Z0-9._%+-]+@lecturers\.undip\.ac\.id$/i',
                ],
            ];
    
            if($request->file('foto_profil')){
                $rules['foto_profil'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            }
    
            $errorMassages = [
                'email_sso.regex' => 'Email SSO harus berakhiran dengan domain lecturers.undip.ac.id',
            ];
            
            $validatedData = $request->validate($rules, $errorMassages);
    
            $foto = auth()->user()->dosen_wali->foto_profil;
            if($request->foto_profil){
                if($foto){
                    Storage::delete($foto);
                }
                $validatedData ["foto_profil"] = $request->file('foto_profil')->store('private/profile_photo');
            }
    
            DosenWali::where('nip', auth()->user()->dosen_wali->nip)->update($validatedData);
    
            return redirect('/profile')->with('success', 'Profile berhasil diubah');
        }
        if(auth()->user()->level == "departemen"){
            $rules = [
                'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
                'email_sso' => [
                    'required',
                    Rule::unique('departemen')->ignore(auth()->user()->departemen, 'email_sso'),
                    'regex:/^[a-zA-Z0-9._%+-]+@lecturers\.undip\.ac\.id$/i',
                ],
            ];
    
            if($request->file('foto_profil')){
                $rules['foto_profil'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            }
    
            $errorMassages = [
                'email_sso.regex' => 'Email SSO harus berakhiran dengan domain lecturers.undip.ac.id',
            ];
            
            $validatedData = $request->validate($rules, $errorMassages);
    
            $foto = auth()->user()->departemen->foto_profil;
            if($request->foto_profil){
                if($foto){
                    Storage::delete($foto);
                }
                $validatedData ["foto_profil"] = $request->file('foto_profil')->store('private/profile_photo');
            }
    
            Departemen::where('departemen_id', auth()->user()->departemen->departemen_id)->update($validatedData);
    
            return redirect('/profile')->with('success', 'Profile berhasil diubah');
        }
        if(auth()->user()->level == "operator"){
            $rules = [
                'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
                'email_sso' => [
                    'required',
                    Rule::unique('operator')->ignore(auth()->user()->operator, 'email_sso'),
                    'regex:/^[a-zA-Z0-9._%+-]+@lecturers\.undip\.ac\.id$/i',
                ],
            ];
    
            if($request->file('foto_profil')){
                $rules['foto_profil'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            }
    
            $errorMassages = [
                'email_sso.regex' => 'Email SSO harus berakhiran dengan domain lecturers.undip.ac.id',
            ];
            
            $validatedData = $request->validate($rules, $errorMassages);
    
            $foto = auth()->user()->operator->foto_profil;
            if($request->foto_profil){
                if($foto){
                    Storage::delete($foto);
                }
                $validatedData ["foto_profil"] = $request->file('foto_profil')->store('private/profile_photo');
            }
    
            Operator::where('operator_id', auth()->user()->operator->operator_id)->update($validatedData);
    
            return redirect('/profile')->with('success', 'Profile berhasil diubah');
        }
    }

    public function editPassword(){
        if(auth()->user()->level == "mahasiswa"){
            return view('mahasiswa.profile.edit_password');
        }
        if(auth()->user()->level == "dosenwali"){
            return view('dosenwali.profile.edit_password');
        }
        if(auth()->user()->level == "departemen"){
            return view('departemen.profile.edit_password');
        }
        if(auth()->user()->level == "operator"){
            return view('operator.profile.edit_password');
        }
    }

    public function updatePassword(Request $request){
        $rules = [
            'password_lama' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Password lama salah');
                    }
                },
            ],
            'password_baru' => 'required|min:8|max:16|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
            'konfirmasi_password' => 'required|same:password_baru',
        ];

        $validatedData = $request->validate($rules);

        $user = auth()->user();
        $user->password = Hash::make($validatedData['password_baru']);
        $user->save(); //syntax highlight error, tapi bisa jalan

        return redirect('/profile')->with('success', 'Password berhasil diubah');
        
    }
}
