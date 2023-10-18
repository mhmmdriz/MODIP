<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    
    protected $table = "departemen";

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'departemen_id');
    }
}
