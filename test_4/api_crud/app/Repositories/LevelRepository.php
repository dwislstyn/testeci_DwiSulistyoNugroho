<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Level;
use DB;

class LevelRepository{

    public function getLevel(array $data)
    {
        $query = DB::table('mst_level');
        $query->where('id_level', $data['id_level']);

        $dataResult = (array) $query->first();

        $result = new Level($dataResult);
        return $result;
    }
    
    public function getListLevel(array $data)
    {
        $query = DB::table('mst_level');
        if(!empty($data['id_level'])){
            $query->where('id_level', $data['id_level']);
        }
        
        if(!empty($data['nama_level'])){
            $query->where('nama_level', 'like', '%'.$data['nama_level'].'%');
        }

        $result = $query->get();
        return $result;
    }

    public function deleteLevel(array $data): int
    {
        $query = DB::table('mst_level');
        
        $result = $query->where('id_level', $data['id_level'])->delete();

        return intval($result);
    }

    public function insertLevel(Level $data): int
    {
        $dataLevel = $data->toArray();

        $result = DB::table('mst_level')->insert($dataLevel);
        return intval($result);
    }

    public function updateLevel(Level $data): bool
    {
        $dataLevel = $data->toArray();

        try {
            DB::table('mst_level')->where('id_level', $dataLevel['id_level'])->update($dataLevel);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }
}