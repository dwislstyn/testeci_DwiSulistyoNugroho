<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Karyawan;
use DB;

class KaryawanRepository{

    public function getKaryawan(array $data)
    {
        $query = DB::table('mst_karyawan');
        
        if(!empty($data['id_karyawan'])){
            $query->where('id_karyawan', $data['id_karyawan']);
        }
        
        if(!empty($data['nik_karyawan'])){
            $query->where('nik', $data['nik_karyawan']);
        }

        $dataResult = (array) $query->first();

        $result = new Karyawan($dataResult);
        return $result;
    }

    public function getListKaryawan(array $data)
    {
        $query = DB::table('mst_karyawan');

        if(!empty($data['id_karyawan'])){
            $query->where('id_karyawan', $data['id_karyawan']);
        }

        if(!empty($data['nik_karyawan'])){
            $query->where('nik', $data['nik_karyawan']);
        }
        
        if(!empty($data['nama_karyawan'])){
            $query->where('nama', 'like', '%'.$data['nama_karyawan'].'%');
        }
        
        if(!empty($data['tanggal_lahir'])){
            $query->where('tgl_lahir', $data['tanggal_lahir']);
        }
        
        if(!empty($data['alamat'])){
            $query->where('alamat', $data['alamat']);
        }
        
        if(!empty($data['id_jabatan'])){
            $query->where('id_jabatan', $data['id_jabatan']);
        }
        
        if(!empty($data['id_dept'])){
            $query->where('id_dept', $data['id_dept']);
        }

        $result = $query->get();
        return $result;
    }

    public function insertKaryawan(Karyawan $data): int
    {
        $dataKaryawan = $data->toArray();

        $result = DB::table('mst_karyawan')->insert($dataKaryawan);
        return intval($result);
    }

    public function deleteKaryawan(array $data): int
    {
        $query = DB::table('mst_karyawan');
        
        if(!empty($data['id_karyawan'])){
            $query->where('id_karyawan', $data['id_karyawan']);
        }

        if(!empty($data['nik_karyawan'])){
            $query->where('nik', $data['nik_karyawan']);
        }

        $result = $query->delete();

        return intval($result);
    }

    public function updateKaryawan(Karyawan $data): bool
    {
        $dataKaryawan = $data->toArray();

        try {
            DB::table('mst_karyawan')->where('id_karyawan', $dataKaryawan['id_karyawan'])->update($dataKaryawan);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

}