<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primarykey = "NIM";

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'NIM');
    }
}
