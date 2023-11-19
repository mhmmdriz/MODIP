<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = "departemen";
    protected $primaryKey = "departemen_id";
    public $incrementing = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'departemen_id');
    }
}
