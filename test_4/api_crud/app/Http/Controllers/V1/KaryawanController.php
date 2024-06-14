<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Exceptions\ParameterException;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Repositories\DepartmentRepository;
use App\Repositories\JabatanRepository;
use App\Repositories\KaryawanRepository;
use App\Validations\KaryawanValidation;
use Illuminate\Http\Request;
use stdClass;

class KaryawanController extends Controller
{

    private $karyawanRepo;
    private $jabatanRepo;
    private $deptRepo;
    private $output;

    public function __construct(KaryawanRepository $karyawanRepo)
    {
        $this->karyawanRepo = $karyawanRepo;
        $this->jabatanRepo  = new JabatanRepository();
        $this->deptRepo  = new DepartmentRepository();

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function inquiryKaryawan(Request $request)
    {
        if(empty($request->id_karyawan) && empty($request->nik_karyawan)){
            throw new ParameterException("Parameter ID karyawan atau NIK karyawan tidak valid");
        }

        $filterKaryawan = [
            'id_karyawan'   => empty($request->id_karyawan) ? null : $request->id_karyawan,
            'nik_karyawan'  => empty($request->nik_karyawan) ? null : $request->nik_karyawan,
        ];
        
        $getKaryawan = $this->karyawanRepo->getKaryawan($filterKaryawan);
        if(empty($getKaryawan->toArray())){
            throw new DataNotFoundException("Data karyawan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry karyawan berhasil.';
        $this->output->responseData = $getKaryawan;

        return response()->json($this->output);
    }

    public function inquiryListKaryawan(Request $request)
    {
        $filterList = [
            'id_karyawan'   => empty($request->id_karyawan) ? null : $request->id_karyawan,
            'nik_karyawan'  => empty($request->nik_karyawan) ? null : $request->nik_karyawan,
            'nama'          => empty($request->nama_karyawan) ? null : $request->nama_karyawan,
            'tgl_lahir'     => empty($request->tanggal_lahir) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->tanggal_lahir)? null : $request->tanggal_lahir,
            'alamat'        => empty($request->alamat) ? null : $request->alamat,
            'id_jabatan'    => empty($request->id_jabatan) ? null : $request->id_jabatan,
        ];

        $listKaryawan = $this->karyawanRepo->getListKaryawan($filterList);
        if(empty($listKaryawan->toArray())){
            throw new DataNotFoundException("Data list karyawan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry list karyawan berhasil.';
        $this->output->responseData = $listKaryawan;

        return response()->json($this->output);
    }

    public function insertDataKaryawan(Request $request)
    {
        KaryawanValidation::validateInsertKaryawan($request);
        
        $dataKaryawan = $this->karyawanRepo->getKaryawan(['nik_karyawan' => $request->nik_karyawan]);
        if(!empty($dataKaryawan->toArray())){
            throw new InvalidRuleException("Data karyawan dengan NIK: $request->nik_karyawan sudah ada.");
        }

        $getJabatan = $this->jabatanRepo->getJabatan(['id_jabatan' => $request->id_jabatan]);
        if(empty($getJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }
        
        $getDept = $this->deptRepo->getDepartment(['id_dept' => $request->id_dept]);
        if(empty($getDept->toArray())){
            throw new DataNotFoundException("Data department tidak ditemukan.");
        }

        $karyawan = new Karyawan();
        $karyawan->nik = $request->nik_karyawan;
        $karyawan->nama = $request->nama_karyawan;
        $karyawan->tgl_lahir = $request->tanggal_lahir;
        $karyawan->alamat = $request->alamat;
        $karyawan->id_jabatan = $request->id_jabatan;
        $karyawan->id_dept = $request->id_dept;

        $insertKaryawan = $this->karyawanRepo->insertKaryawan($karyawan);
        if(empty($insertKaryawan)){
            throw new InvalidRuleException("Insert data karyawan tidak valid.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Insert data karyawan berhasil';

        return response()->json($this->output);
    }

    public function deleteDataKaryawan(Request $request)
    {
        if(empty($request->id_karyawan) && empty($request->nik_karyawan)){
            throw new ParameterException("Parameter ID karyawan atau NIK karyawan tidak valid");
        }

        $filterKaryawan = [
            'id_karyawan'   => empty($request->id_karyawan) ? null : intval($request->id_karyawan),
            'nik_karyawan'  => empty($request->nik_karyawan) ? null : $request->nik_karyawan,
        ];
        
        $getKaryawan = $this->karyawanRepo->getKaryawan($filterKaryawan);
        if(empty($getKaryawan->toArray())){
            throw new DataNotFoundException("Data karyawan tidak ditemukan.");
        }

        $deleteKaryawan = $this->karyawanRepo->deleteKaryawan($filterKaryawan);
        if(empty($deleteKaryawan)){
            throw new InvalidRuleException("Delete data karyawan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data karyawan berhasil.';

        return response()->json($this->output);
    }

    public function updateDataKaryawan(Request $request)
    {
        KaryawanValidation::validateUpdateKaryawan($request);

        $dataKaryawan = $this->karyawanRepo->getKaryawan(['nik_karyawan' => $request->nik_karyawan]);
        if(empty($dataKaryawan->toArray())){
            throw new DataNotFoundException("Data karyawan tidak ditemukan.");
        }

        $dataKaryawan->nama         = empty($request->nama_karyawan) ? $dataKaryawan->nama : $request->nama_karyawan;
        $dataKaryawan->tgl_lahir    = empty($request->tanggal_lahir) ? $dataKaryawan->tgl_lahir : $request->tanggal_lahir;
        $dataKaryawan->alamat       = empty($request->alamat) ? $dataKaryawan->alamat : $request->alamat;
        $dataKaryawan->id_jabatan   = empty($request->id_jabatan) ? $dataKaryawan->id_jabatan : $request->id_jabatan;

        $getJabatan = $this->jabatanRepo->getJabatan(['id_jabatan' => $dataKaryawan->id_jabatan]);
        if(empty($getJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }

        $updateKaryawan = $this->karyawanRepo->updateKaryawan($dataKaryawan);
        if($updateKaryawan === FALSE){
            throw new InvalidRuleException("Update karyawan tidak valid.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data karyawan berhasil.';

        return response()->json($this->output);
    }
}
