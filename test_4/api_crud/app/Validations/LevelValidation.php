<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LevelValidation{
    
    public static function validateInsertLevel(Request $request)
    {
        $rules = [
            'nama_level' => 'required|string:max:100',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function validateInquiryLevel(Request $request)
    {
        $rules = [
            'id_level' => ['required', 'numeric', Rule::notIn([0,'0'])],
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}