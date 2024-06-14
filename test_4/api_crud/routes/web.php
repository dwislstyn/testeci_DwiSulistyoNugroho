<?php

use App\Http\Controllers\FormCrudController;
use App\Http\Controllers\FormLogicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nomor_satu', [FormLogicController::class, 'nomor_satu']);
Route::get('/nomor_dua', [FormLogicController::class, 'nomor_dua']);

Route::get('/form_karyawan', [FormCrudController::class, 'indexKaryawan']);
Route::get('/form_jabatan', [FormCrudController::class, 'indexJabatan']);
Route::get('/form_level', [FormCrudController::class, 'indexLevel']);
Route::get('/form_department', [FormCrudController::class, 'indexDepartment']);