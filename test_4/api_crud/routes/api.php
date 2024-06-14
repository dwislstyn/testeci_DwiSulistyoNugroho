<?php

use App\Http\Controllers\V1\DepartmentController;
use App\Http\Controllers\V1\JabatanController;
use App\Http\Controllers\V1\KaryawanController;
use App\Http\Controllers\V1\LevelController;
use App\Http\Controllers\V1\ApiLogicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
$router->get('/', function () use ($router) {
    if (getenv('APP_NAME') === null) {
        return $router->app->version();
    } else {
        return 'Welcome to ' . getenv('APP_NAME') . ' ' . getenv('APP_ENV');
    }
});

$router->group(['prefix' => 'v1', 'namespace' => 'V1'], function () use ($router) {
    
    // KaryawanController
    $router->post('/inquiryKaryawan', [KaryawanController::class, 'inquiryKaryawan']);
    $router->post('/inquiryListKaryawan', [KaryawanController::class, 'inquiryListKaryawan']);
    $router->post('/insertDataKaryawan', [KaryawanController::class, 'insertDataKaryawan']);
    $router->post('/deleteDataKaryawan', [KaryawanController::class, 'deleteDataKaryawan']);
    $router->post('/updateDataKaryawan', [KaryawanController::class, 'updateDataKaryawan']);
    
    // DepartmentController
    $router->post('/inquiryDepartment', [DepartmentController::class, 'inquiryDepartment']);
    $router->post('/inquiryListDepartment', [DepartmentController::class, 'inquiryListDepartment']);
    $router->post('/insertDataDepartment', [DepartmentController::class, 'insertDataDepartment']);
    $router->post('/updateDataDepartment', [DepartmentController::class, 'updateDataDepartment']);
    $router->post('/deleteDataDepartment', [DepartmentController::class, 'deleteDataDepartment']);
    
    // LevelController
    $router->post('/inquiryLevel', [LevelController::class, 'inquiryLevel']);
    $router->post('/inquiryListLevel', [LevelController::class, 'inquiryListLevel']);
    $router->post('/deleteDataLevel', [LevelController::class, 'deleteDataLevel']);
    $router->post('/insertDataLevel', [LevelController::class, 'insertDataLevel']);
    $router->post('/updateDataLevel', [LevelController::class, 'updateDataLevel']);
    
    // LevelController
    $router->post('/inquiryJabatan', [JabatanController::class, 'inquiryJabatan']);
    $router->post('/inquiryListJabatan', [JabatanController::class, 'inquiryListJabatan']);
    $router->post('/deleteDataJabatan', [JabatanController::class, 'deleteDataJabatan']);
    $router->post('/insertDataJabatan', [JabatanController::class, 'insertDataJabatan']);
    $router->post('/updateDataJabatan', [JabatanController::class, 'updateDataJabatan']);
    
    //ApiLogicController
    $router->post('/nomor_satu', [ApiLogicController::class, 'nomor_satu']);
    $router->post('/nomor_dua', [ApiLogicController::class, 'nomor_dua']);
});
