<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Http\Requests\StorePKLRequest;
use App\Http\Requests\UpdatePKLRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class PKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $mahasiswa = auth()->user()->mahasiswa;

        return view('mahasiswa.pkl.index', [
            'pkl' => auth()->user()->mahasiswa->pkl,
        ]);
    }

    public function updateOrInsert(Request $request)
    {
        $validatedData = $request->validate([
            'dospem' => 'required',
            'status' => 'required',
            'nilai' => 'required',
            'tahun' => 'required',
            'scan_basp' => 'nullable|mimes:pdf|max:10000',
        ]);

        if ($request->hasFile('scan_basp')) {
            Storage::delete($validatedData['scan_basp']);

            $validatedData['scan_basp'] = $request->file('scan_basp')->store('private/pkl');
        }

        $id = $request->input('id');
        if ($id) {
            PKL::where('id', $id)->update($validatedData);
        } else {
            PKL::create($validatedData);
        }

        return redirect('/pkl')->with('success', 'PKL record updated or inserted successfully');
    }
}