<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JabatanValidation{
    
    public static function validateInsertJabatan(Request $request)
    {
        $rules = [
            'nama_jabatan'  => 'required|string:max:100',
            'id_level'      => ['required', 'numeric', Rule::notIn([0,'0'])],
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function validateInquiryJabatan(Request $request)
    {
        $rules = [
            'id_jabatan' => ['required', 'numeric', Rule::notIn([0,'0'])],
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}