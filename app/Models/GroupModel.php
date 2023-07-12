<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupModel extends Model
{
    use HasFactory;
    static public function group($id)
    {
        $query = DB::table('groups')
            ->where(['creativer_gr_id' => $id])
            ->get()
            ->toArray();
        return $query;
    }
    static public function memberGroup($idGroup)
    {
        $query = DB::table('gr_members as mb')
            ->select('mb.id', 'gr.creativer_gr_id', 'gr.name_group', 'mb.member_id', 'u.name as tenMember', 'u.email')
            ->rightJoin('groups as gr', 'gr.id', '=', 'mb.gr_id')
            ->join('users as u', 'u.id', '=', 'mb.member_id')
            ->where('gr.id', '=', $idGroup)
            ->get()
            ->toArray();
        return $query;
    }
    static public function getMessageGroup()
    {
    }
}
