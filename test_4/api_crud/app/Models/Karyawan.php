<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nik',
        'nama',
        'tgl_lahir',
        'alamat',
        'id_jabatan',
        'id_dept',
    ];
    
    protected $casts = [
        'id_karyawan'   => 'integer',
        'nik'           => 'string',
        'nama'          => 'string',
        'tgl_lahir'     => 'date:Y-m-d',
        'alamat'        => 'string',
        'id_jabatan'    => 'integer',
        'id_dept'       => 'integer',
    ];
}
