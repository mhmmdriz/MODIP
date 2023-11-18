<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartemenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departemen $departemen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departemen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departemen $departemen)
    {
        //
    }

    public function viewProfile(){
        return view('departemen.profile.index');
    }

    public function editProfile(){
        return view('departemen.profile.edit');
    }

    public function updateProfile(Request $request){
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
