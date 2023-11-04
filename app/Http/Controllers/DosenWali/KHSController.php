<?php

namespace App\Http\Controllers\DosenWali;

use App\Http\Controllers\Controller;
use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KHSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_mhs = Mahasiswa::where("dosen_wali", auth()->user()->username)->get()->groupBy("angkatan")->map(function($item){
            return $item->count(); 
        });
        // dd($data_mhs);

        return view("dosenwali.khs.index",[
            "data_mhs" => $data_mhs,
        ]);
    }

    public function listMhsAngkatan(String $angkatan)
    {
        $data_mhs = Mahasiswa::get()->where("dosen_wali", auth()->user()->username)->where("angkatan", $angkatan);

        $data_khs = KHS::get()->groupBy('nim')->map(function($item) {
            return [
                'sksk' => $item->sum('sks'),
                'ipk' => $item->avg('ips'),
        ];
        });
        // dd($data_khs);
        
        return view("dosenwali.khs.list_mhs",[
            "data_mhs"=> $data_mhs,
            "data_khs"=> $data_khs,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
