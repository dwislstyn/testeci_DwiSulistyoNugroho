<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormCrudController extends Controller
{
    public function indexKaryawan()
    {
        return view('form_karyawan');
    }
    
    public function indexJabatan()
    {
        return view('form_jabatan');
    }
    
    public function indexLevel()
    {
        return view('form_level');
    }
    
    public function indexDepartment()
    {
        return view('form_department');
    }
}
