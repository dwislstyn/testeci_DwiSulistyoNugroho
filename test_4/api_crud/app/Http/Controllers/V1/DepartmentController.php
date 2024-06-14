<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Exceptions\ParameterException;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use App\Repositories\KaryawanRepository;
use App\Validations\DepartmentValidation;
use Illuminate\Http\Request;
use stdClass;

class DepartmentController extends Controller
{
    private $departRepo;
    private $karyawanRepo;
    private $output;

    public function __construct(DepartmentRepository $departRepo)
    {
        $this->departRepo   = $departRepo;
        $this->karyawanRepo = new KaryawanRepository();

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function inquiryDepartment(Request $request)
    {
        DepartmentValidation::validateInquiryDepartment($request);
        
        $getDepartment = $this->departRepo->getDepartment(['id_dept' => $request->id_dept]);
        if(empty($getDepartment->toArray())){
            throw new DataNotFoundException("Data department tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry department berhasil';
        $this->output->responseData = $getDepartment;

        return response()->json($this->output);
    }
    
    public function inquiryListDepartment(Request $request)
    {
        $filterDept = [
            'id_dept' => empty($request->id_dept) ? null : $request->id_dept,
            'nama_dept' => empty($request->nama_dept) ? null : $request->nama_dept,
        ];
        
        $getDepartment = $this->departRepo->getListDepartment($filterDept);
        if(empty($getDepartment->toArray())){
            throw new DataNotFoundException("Data department tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry department berhasil';
        $this->output->responseData = $getDepartment;

        return response()->json($this->output);
    }

    public function insertDataDepartment(Request $request)
    {
        DepartmentValidation::validateInsertDepartment($request);

        $department = new Department();
        $department->nama_dept = $request->nama_dept;

        $insertDept = $this->departRepo->insertDepartment($department);
        if(empty($insertDept)){
            throw new InvalidRuleException("Insert data department gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Insert data department berhasil';

        return response()->json($this->output);
    }

    public function updateDataDepartment(Request $request)
    {
        DepartmentValidation::validateInquiryDepartment($request);

        $dataDepartment = $this->departRepo->getDepartment(['id_dept' => $request->id_dept]);
        if(empty($dataDepartment->toArray())){
            throw new DataNotFoundException("Data department tidak ditemukan.");
        }

        $dataDepartment->nama_dept = empty($request->nama_dept) ? $dataDepartment->nama_dept : $request->nama_dept;

        $updateDepartment = $this->departRepo->updateDepartment($dataDepartment);
        if($updateDepartment === FALSE){
            throw new InvalidRuleException("Update data department gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data department berhasil.';

        return response()->json($this->output);
    }

    public function deleteDataDepartment(Request $request)
    {
        DepartmentValidation::validateInquiryDepartment($request);

        $getDepartment = $this->departRepo->getDepartment($request->all());
        if(empty($getDepartment->toArray())){
            throw new DataNotFoundException("Data department tidak ditemukan.");
        }

        $cekDeptKaryawan = $this->karyawanRepo->getListKaryawan(['id_dept' => $request->id_dept]);
        if(!empty($cekDeptKaryawan->toArray())){
            throw new InvalidRuleException("Data department tidak dapat dihapus karna ada data karyawan yang menggunakan ID department $getDepartment->nama_dept");
        }

        $deleteDepartment = $this->departRepo->deleteDepartment($request->all());
        if(empty($deleteDepartment)){
            throw new InvalidRuleException("Delete data department gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data department berhasil.';

        return response()->json($this->output);
    }
}
