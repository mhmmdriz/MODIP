<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use App\Models\DosenWali;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::all();
        $data_angkatan = $data_mhs->pluck('angkatan')->unique()->values();
        $data_doswal = DosenWali::all();

        return view("operator.akun_mhs.index", [
            "data_mhs" => $data_mhs,
            "data_angkatan" => $data_angkatan,
            "data_doswal" => $data_doswal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd();
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nim' => 'required|unique:mahasiswa|min:14|max:14',
            'angkatan' => 'required',
            'status' => 'required',
            'dosen_wali' => 'required',
        ]);

        Mahasiswa::create($validatedData);

        $userData = [
            'username'=> $validatedData['nim'],
            'level' => 'mahasiswa',
            'password' => Hash::make("password"),
            'status'=> 1,
        ];

        User::create($userData);

        return redirect('/akunMHS')->with('success','Akun Mahasiswa Berhasil Ditambahkan');
    }


    public function update(Request $request, Mahasiswa $akunMH){
        // dd($akunMH);
        $rules = [
            'nama_edit' => 'required|max:255',
            'angkatan_edit' => 'required',
            'status_edit' => 'required',
            'dosen_wali_edit' => 'required',
        ];

        // if($request->nim_edit != $akunMH->nim){
        //     $rules['nim_edit'] = 'required|unique:mahasiswa,nim|min:14|max:14';
        // }
        
        $validatedData = $request->validate($rules);

        $validatedData = [
            'nama' => $validatedData['nama_edit'],
            // 'nim' => $validatedData['nim_edit'],
            'angkatan' => $validatedData['angkatan_edit'],
            'status' => $validatedData['status_edit'],
            'dosen_wali' => $validatedData['dosen_wali_edit'],
        ];

        Mahasiswa::where('nim', $akunMH->nim)->update($validatedData);

        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $akunMH->nim Berhasil Diubah");
    }

    public function storeImport(Request $request){
        $validatedData = $request->validate([
            'fileExcel' => 'required',
        ]);

        Excel::import(new UserImport("mahasiswa"), request()->file('fileExcel'));
        Excel::import(new MahasiswaImport, request()->file('fileExcel'));

        return redirect('/akunMHS')->with('success','Import Akun Mahasiswa Berhasil');
    }

    public function exportData(Request $request){
        return (new MahasiswaExport($request->angkatanExport))->download('akun_mhs.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nim)
    {
        User::where('username',$nim)->delete();
        
        Mahasiswa::where('nim',$nim)->delete();

        return redirect('/akunMHS')->with('success',"Akun Mahasiswa dengan NIM $nim Berhasil Dihapus");
    }

    public function resetPassword(String $nim)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        User::where('username', $nim)->update($userData);

        return redirect('/akunMHS')->with('success', "Password Akun Mahasiswa dengan NIM $nim Berhasil Direset");
    }

    public function updateTableMhs(Request $request){
        $data_mhs = Mahasiswa::whereRaw("nim LIKE '%$request->keyword%' OR nama LIKE '%$request->keyword%' OR angkatan LIKE '%$request->keyword%' OR status LIKE '%$request->keyword%'")->get();

        $view = view('operator.ajax.update_mhs')->with('data_mhs', $data_mhs)->render();

        return response()->json(['html' => $view]);
    }

    public function viewProfile(){
        return view('mahasiswa.profile.index');
    }

    public function editProfile(){
        return view('mahasiswa.profile.edit');
    }

    public function updateProfile(Request $request){
        $rules = [
            'no_telp' => 'required|max:15|regex:/^[0-9]{1,15}$/',
            'email_sso' => [
                'required',
                Rule::unique('mahasiswa')->ignore(auth()->user()->mahasiswa, 'email_sso'),
                'regex:/^[a-zA-Z]+@students\.undip\.ac\.id$/',
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

    public function editPassword(){
        return view('mahasiswa.profile.edit_password');
    }

    public function updatePassword(Request $request){
        $rules = [
            'password_lama' => [
                'required',
                'min:8',
                'max:16',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
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
