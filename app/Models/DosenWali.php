<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenWali extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "dosen_wali";
    protected $primarykey = "nip";
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nip');
    }
}
