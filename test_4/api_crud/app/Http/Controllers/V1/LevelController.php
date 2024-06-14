<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidRuleException;
use App\Exceptions\ParameterException;
use App\Models\Level;
use App\Repositories\LevelRepository;
use App\Repositories\JabatanRepository;
use App\Validations\LevelValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

class LevelController extends Controller
{
    private $levelRepo;
    private $jabatanRepo;
    private $output;

    public function __construct(LevelRepository $levelRepo)
    {
        $this->levelRepo   = $levelRepo;
        $this->jabatanRepo = new JabatanRepository();

        $this->output = new stdClass;
        $this->output->responseCode = null;
        $this->output->responseDesc = null;
    }

    public function inquiryLevel(Request $request)
    {
        LevelValidation::validateInquiryLevel($request);
        
        $getLevel = $this->levelRepo->getLevel(['id_level' => $request->id_level]);
        if(empty($getLevel->toArray())){
            throw new DataNotFoundException("Data level jabatan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry level jabatan berhasil';
        $this->output->responseData = $getLevel;

        return response()->json($this->output);
    }

    public function inquiryListLevel(Request $request)
    {
        $filterLevel = [
            'id_level'      => empty($request->id_level) ? null : $request->id_level,
            'nama_level'    => empty($request->nama_level) ? null : $request->nama_level,
        ];
        
        $getListLevel = $this->levelRepo->getListLevel($filterLevel);
        if(empty($getListLevel->toArray())){
            throw new DataNotFoundException("Data list level jabatan tidak ditemukan.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Inquiry list level jabatan berhasil';
        $this->output->responseData = $getListLevel;

        return response()->json($this->output);
    }

    public function deleteDataLevel(Request $request)
    {
        LevelValidation::validateInquiryLevel($request);

        $getLevel = $this->levelRepo->getLevel($request->all());
        if(empty($getLevel->toArray())){
            throw new DataNotFoundException("Data level jabatan tidak ditemukan.");
        }

        $cekLevelJabatan = $this->jabatanRepo->getListJabatan(['id_level' => $request->id_level]);
        if(!empty($cekLevelJabatan->toArray())){
            throw new InvalidRuleException("Data level jabatan tidak dapat dihapus karna ada data jabatan yang menggunakan ID level jabatan $getLevel->nama_level");
        }

        $deleteLevel = $this->levelRepo->deleteLevel($request->all());
        if(empty($deleteLevel)){
            throw new InvalidRuleException("Delete data level jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Delete data level jabatan berhasil.';

        return response()->json($this->output);
    }

    public function insertDataLevel(Request $request)
    {
        LevelValidation::validateInsertLevel($request);

        $level = new Level();
        $level->nama_level = $request->nama_level;

        $insertLevel = $this->levelRepo->insertLevel($level);
        if(empty($insertLevel)){
            throw new InvalidRuleException("Insert data level jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Insert data level jabatan berhasil';

        return response()->json($this->output);
    }

    public function updateDataLevel(Request $request)
    {
        LevelValidation::validateInquiryLevel($request);

        $dataLevel = $this->levelRepo->getLevel(['id_level' => $request->id_level]);
        if(empty($dataLevel->toArray())){
            throw new DataNotFoundException("Data level jabatan tidak ditemukan.");
        }

        $dataLevel->nama_level = empty($request->nama_level) ? $dataLevel->nama_level : $request->nama_level;

        $updateLevel = $this->levelRepo->updateLevel($dataLevel);
        if($updateLevel === FALSE){
            throw new InvalidRuleException("Update data level jabatan gagal.");
        }

        $this->output->responseCode = '00';
        $this->output->responseDesc = 'Update data level jabatan berhasil.';

        return response()->json($this->output);
    }
}
