<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KaryawanValidation{
    
    public static function validateInsertKaryawan(Request $request)
    {
        $rules = [
            'nik_karyawan'  => 'required|numeric',
            'nama_karyawan' => 'required|string:max:100',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'alamat'        => 'required|string:max:255',
            'id_jabatan'    => 'required|numeric',
            'id_dept'       => 'required|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function validateUpdateKaryawan(Request $request)
    {
        $rules = [
            'nik_karyawan'  => 'required|numeric',
            'nama_karyawan' => 'nullable|string:max:100',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'alamat'        => 'nullable|string:max:255',
            'id_jabatan'    => 'nullable|numeric',
            'id_dept'       => 'nullable|numeric',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}