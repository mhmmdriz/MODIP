<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaTaskController extends Controller
{
    public function firstLogin(){
        return view("mahasiswa.first_login");
    }
}
