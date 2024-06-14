<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_level',
        'nama_level',
    ];
    
    protected $casts = [
        'id_level'      => 'integer',
        'nama_level'    => 'string'
    ];
}
