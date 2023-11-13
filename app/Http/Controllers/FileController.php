<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function showIRS($filename)
    {   
        $path = Storage::path('\\'.$filename);
        return response()->file($path);
    }
    
    public function showKHS($filename)
    {   
        $path = Storage::path('\\'.$filename);
        return response()->file($path);
    }

    public function showProfilePhoto($photoname){
        $path = Storage::path('\\'.$photoname);
        return response()->file($path);
    }

    public function showSkripsi($filename){
        $path = Storage::path('\\'.$filename);
        return response()->file($path);
    }

    public function template($filename){
        $path = Storage::path('private\template\\'.$filename.'.xlsx');
        return response()->download($path);
    }
}
