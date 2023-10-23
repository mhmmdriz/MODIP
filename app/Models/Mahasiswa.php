<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswa";
    protected $primarykey = "nim";
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nim');
    }

    public function getRouteKeyName()
    {
        return 'nim';
    }

}
