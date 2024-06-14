<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Jabatan;
use DB;

class JabatanRepository{

    public function getJabatan(array $data)
    {
        $query = DB::table('mst_jabatan');
        $query->where('id_jabatan', $data['id_jabatan']);

        $dataResult = (array) $query->first();

        $result = new Jabatan($dataResult);
        return $result;
    }
    
    public function getListJabatan(array $data)
    {
        $query = DB::table('mst_jabatan');
        if(!empty($data['id_jabatan'])){
            $query->where('id_jabatan', $data['id_jabatan']);
        }
        
        if(!empty($data['nama_jabatan'])){
            $query->where('nama_jabatan', 'like', '%'.$data['nama_jabatan'].'%');
        }
        
        if(!empty($data['id_level'])){
            $query->where('id_level', $data['id_level']);
        }

        $result = $query->get();
        return $result;
    }

    public function deleteJabatan(array $data): int
    {
        $query = DB::table('mst_jabatan');
        
        $result = $query->where('id_jabatan', $data['id_jabatan'])->delete();

        return intval($result);
    }

    public function insertJabatan(Jabatan $data): int
    {
        $dataJabatan = $data->toArray();

        $result = DB::table('mst_jabatan')->insert($dataJabatan);
        return intval($result);
    }

    public function updateJabatan(Jabatan $data): bool
    {
        $dataJabatan = $data->toArray();

        try {
            DB::table('mst_jabatan')->where('id_jabatan', $dataJabatan['id_jabatan'])->update($dataJabatan);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }
}