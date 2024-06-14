<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
        'id_level',
    ];
    
    protected $casts = [
        'id_jabatan' => 'integer',
        'nama_jabatan' => 'string',
        'id_level' => 'integer',
    ];
}
