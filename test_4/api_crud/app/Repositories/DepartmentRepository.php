<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Department;
use DB;

class DepartmentRepository{

    public function getDepartment(array $data)
    {
        $query = DB::table('mst_department');
        $query->where('id_dept', $data['id_dept']);

        $dataResult = (array) $query->first();

        $result = new Department($dataResult);
        return $result;
    }
    
    public function getListDepartment(array $data)
    {
        $query = DB::table('mst_department');
        
        if(!empty($data['id_dept'])){
            $query->where('id_dept', $data['id_dept']);
        }
        
        if(!empty($data['nama_dept'])){
            $query->where('nama_dept', 'like', '%'.$data['nama_dept'].'%');
        }

        $result = $query->get();
        return $result;
    }
    
    public function insertDepartment(Department $data): int
    {
        $dataDepartment = $data->toArray();

        $result = DB::table('mst_department')->insert($dataDepartment);
        return intval($result);
    }

    public function updateDepartment(Department $data): bool
    {
        $dataDepartment = $data->toArray();

        try {
            DB::table('mst_department')->where('id_dept', $dataDepartment['id_dept'])->update($dataDepartment);
            return TRUE;
        } catch (\Throwable $th) {
            return FALSE;
        }
    }

    public function deleteDepartment(array $data): int
    {
        $query = DB::table('mst_department');
        
        $result = $query->where('id_dept', $data['id_dept'])->delete();

        return intval($result);
    }


}