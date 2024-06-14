<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_dept',
        'nama_dept',
    ];
    
    protected $casts = [
        'id_dept'      => 'integer',
        'nama_dept'    => 'string'
    ];
}
