<?php

namespace App\Http\Controllers;

use App\Exports\DosenWaliExport;
use App\Imports\DosenWaliImport;
use App\Imports\UserImport;
use App\Models\User;
use App\Models\DosenWali;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DosenWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_doswal = DosenWali::all();

        return view("operator.akun_doswal.index", [
            "data_doswal" => $data_doswal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|unique:dosen_wali|min:14|max:14',
            'no_telp' => 'required',
            'email_sso' => 'required|unique:dosen_wali|regex:/^[a-zA-Z]+@lecturers\.undip\.ac\.id$/',
        ]);

        DosenWali::create($validatedData);

        $userData = [
            'username'=> $validatedData['nip'],
            'level' => 'dosenwali',
            'password' => Hash::make("password"),
            'status'=> 1,
        ];

        User::create($userData);

        return redirect('/akunDosenWali')->with('success','Akun Dosen Wali Berhasil Ditambahkan');
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required',
        ]);

        Excel::import(new UserImport("dosenwali"), request()->file('fileExcel'));
        Excel::import(new DosenWaliImport, request()->file('fileExcel'));

        return redirect('/akunDosenWali')->with('success','Import Akun Dosen Wali Berhasil');
    }

    public function exportData(){
        return (new DosenWaliExport)->download('akun_doswal.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $nip)
    {
        DosenWali::where('nip', $nip)->delete();
        User::where('username', $nip)->delete();

        return redirect('/akunDosenWali')->with('success',"Akun Dosen Wali dengan NIP $nip Berhasil Dihapus");
    }

    public function resetPassword(String $nip)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        User::where('username', $nip)->update($userData);

        return redirect('/akunDosenWali')->with('success', "Password Akun Dosen Wali dengan NIP $nip Berhasil Direset");
    }

    public function viewProfile(){
        return view('dosenwali.profile.index');
    }

    public function editProfile(){
        return view('dosenwali.profile.edit');
    }

    public function updateProfile(Request $request){
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

    public function editPassword(){
        return view('dosenwali.profile.edit_password');
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
