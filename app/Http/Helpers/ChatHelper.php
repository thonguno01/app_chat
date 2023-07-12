<?php

namespace App\Http\Helpers;

use App\Models\GeneralModel;
use App\Models\GroupModel;
use App\Models\Messages;
use Illuminate\Support\Facades\DB;

class ChatHelper
{
    static public function callUser()
    {
        $id_me = session()->get('id');
        $users = DB::table('users as u')
            ->select('u.*')
            ->where('id', '!=', $id_me)
            ->get()->toArray();
        return $users;
    }
    static public function getInforUser($id)
    {
        $users = DB::table('users')->where(['id' => $id])->first();
        return $users;
    }
    static public  function getLastMessage($id_receider)
    {
        $message = Messages::getAllMessageOfOneUser($id_receider);
        return $message;
    }
    static public function callGroup()
    {
        $idMe = session()->get('id');
        $group =  GroupModel::memberGroup(4);
        // var_dump($group);
        // echo $idMe;
    }
}
