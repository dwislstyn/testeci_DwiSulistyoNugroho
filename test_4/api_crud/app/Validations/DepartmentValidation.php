<?php declare(strict_types=1);

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentValidation{
    
    public static function validateInsertDepartment(Request $request)
    {
        $rules = [
            'nama_dept' => 'required|string:max:100',
        ];

        Validator::make($request->all(), $rules)->validate();
    }
    
    public static function validateInquiryDepartment(Request $request)
    {
        $rules = [
            'id_dept' => ['required', 'numeric', Rule::notIn([0,'0'])],
        ];

        Validator::make($request->all(), $rules)->validate();
    }
}