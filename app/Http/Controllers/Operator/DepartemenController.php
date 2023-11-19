<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_departemen = Departemen::all();

        return view("operator.akun_departemen.index", [
            "data_departemen" => $data_departemen,
        ]);
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'departemen_id' => 'required|unique:departemen|max:14',
            'no_telp' => 'required',
            'email_sso' => 'required|unique:departemen|regex:/^[a-zA-Z0-9._%+-]+@lecturers\.undip\.ac\.id$/i',
        ]);

        Departemen::create($validatedData);

        $userData = [
            'username'=> $validatedData['departemen_id'],
            'level' => 'departemen',
            'password' => Hash::make("password"),
            'status'=> 1,
        ];

        User::create($userData);

        return redirect('/akunDepartemen')->with('success','Akun Departemen Berhasil Ditambahkan');
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
    public function destroy(Departemen $akunDeparteman)
    {
        User::where('username', $akunDeparteman->departemen_id)->delete();

        $akunDeparteman->delete();

        return redirect('/akunDepartemen')->with('success',"Akun Departemen dengan Departemen ID $akunDeparteman->departemen_id Berhasil Dihapus");
    }

    public function resetPassword(User $user)
    {
        $userData = [
            'password' => Hash::make("password"),
        ];

        $user->update($userData);

        return redirect('/akunDepartemen')->with('success', "Password Akun Departemen dengan Departemen ID $user->username Berhasil Direset");
    }

}
