<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormLogicController extends Controller
{
    public function nomor_satu()
    {
        return view('form_nomor_satu');
    }
    
    public function nomor_dua()
    {
        return view('form_nomor_dua');
    }
}
