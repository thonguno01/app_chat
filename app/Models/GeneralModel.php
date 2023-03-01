<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralModel extends Model
{
    use HasFactory;

    static  public function add($table = '', $data = [])
    {
        // var_dump($data);
        if (count($data) !=  0) {
            DB::table($table)->insert($data);
        }
    }
    static  public function addGetId($table = '', $data = [])
    {
        // var_dump($data);
        if (count($data) !=  0) {
            return  DB::table($table)->insertGetId($data);
        }
    }
    static  public function updateData($table = '', $where = [], $data = [])
    {
        // var_dump($data);
        if (count($data) !=  0) {
            DB::table($table)
                ->where($where)
                ->update($data);
        }
    }
    static public function selectData($select, $table, $where = [], $rs = 'list_array')
    {
        $record = DB::table($table)
            ->where($where);
        if ($rs == 'list_array') {
            return $record->get();
        }
        if ($rs = 'array') {
            return $record->first();
        }
    }
}
