<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenWali extends Model
{
    use HasFactory;

    protected $table = "dosen_wali";

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nip');
    }
}
