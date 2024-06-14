<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Repositories\JabatanRepository;
use App\Repositories\KaryawanRepository;
use App\Repositories\LevelRepository;
use App\Validations\JabatanValidation;
use Illuminate\Http\Request;
use stdClass;

class JabatanController extends Controller
{
    private $jabatanRepo;
    private $karyawanRepo;
    private $levelRepo;
    private $output;

    public function __construct(JabatanRepository $jabatanRepo)
    {
        $this->jabatanRepo   = $jabatanRepo;
        $this->karyawanRepo = new KaryawanRepository();
        $this->levelRepo = new LevelRepository();

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function inquiryJabatan(Request $request)
    {
        JabatanValidation::validateInquiryJabatan($request);
        
        $getJabatan = $this->jabatanRepo->getJabatan(['id_jabatan' => $request->id_jabatan]);
        if(empty($getJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry jabatan berhasil';
        $this->output->responseData = $getJabatan;

        return response()->json($this->output);
    }

    public function inquiryListJabatan(Request $request)
    {
        $filterJabatan = [
            'id_jabatan'    => empty($request->id_jabatan) ? null : $request->id_jabatan,
            'nama_jabatan'  => empty($request->nama_jabatan) ? null : $request->nama_jabatan,
            'id_level'    => empty($request->id_level) ? null : $request->id_level,
        ];
        
        $getListJabatan = $this->jabatanRepo->getListJabatan($filterJabatan);
        if(empty($getListJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry jabatan berhasil';
        $this->output->responseData = $getListJabatan;

        return response()->json($this->output);
    }

    public function deleteDataJabatan(Request $request)
    {
        JabatanValidation::validateInquiryJabatan($request);

        $getJabatan = $this->jabatanRepo->getJabatan($request->all());
        if(empty($getJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }

        $cekJabatanKaryawan = $this->karyawanRepo->getListKaryawan(['id_jabatan' => $request->id_jabatan]);
        if(!empty($cekJabatanKaryawan->toArray())){
            throw new InvalidRuleException("Data jabatan tidak dapat dihapus karna ada data karyawan yang menggunakan ID department $getJabatan->nama_jabatan");
        }

        $deleteJabatan = $this->jabatanRepo->deleteJabatan($request->all());
        if(empty($deleteJabatan)){
            throw new InvalidRuleException("Delete data jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data jabatan berhasil.';

        return response()->json($this->output);
    }

    public function insertDataJabatan(Request $request)
    {
        JabatanValidation::validateInsertJabatan($request);

        $getLevel = $this->levelRepo->getLevel(['id_level' => $request->id_level]);
        if(empty($getLevel->toArray())){
            throw new DataNotFoundException("Data ID level tidak ditemukan.");
        }

        $jabatan = new Jabatan();
        $jabatan->nama_jabatan  = $request->nama_jabatan;
        $jabatan->id_level      = $request->id_level;

        $insertJabatan = $this->jabatanRepo->insertjabatan($jabatan);
        if(empty($insertJabatan)){
            throw new InvalidRuleException("Insert data jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Insert data jabatan berhasil';

        return response()->json($this->output);
    }

    public function updateDataJabatan(Request $request)
    {
        JabatanValidation::validateInquiryJabatan($request);

        $dataJabatan = $this->jabatanRepo->getJabatan(['id_jabatan' => $request->id_jabatan]);
        if(empty($dataJabatan->toArray())){
            throw new DataNotFoundException("Data jabatan tidak ditemukan.");
        }

        $dataJabatan->nama_jabatan  = empty($request->nama_jabatan) ? $dataJabatan->nama_jabatan : $request->nama_jabatan;
        $dataJabatan->id_level      = empty($request->id_level) ? $dataJabatan->id_level : $request->id_level;

        $getLevel = $this->levelRepo->getLevel(['id_level' => $dataJabatan->id_level]);
        if(empty($getLevel->toArray())){
            throw new DataNotFoundException("Data ID level tidak ditemukan.");
        }

        $updateJabatan = $this->jabatanRepo->updateJabatan($dataJabatan);
        if($updateJabatan === FALSE){
            throw new InvalidRuleException("Update data jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data jabatan berhasil.';

        return response()->json($this->output);
    }
}
