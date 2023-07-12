<?php

namespace App\Http\Controllers;

use App\Models\GeneralModel;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkLogin');
    }
    public function getImageMessage(Request $request)
    {
        // var_dump($request->all());
        $id_recei = $request->input('id_receiver');
        // $id_sender = $request->input('id_sender');
        $messageImageOfUser = Messages::getAllMessageImageOfOneUser($id_recei);
        echo json_encode(['msgImage' => $messageImageOfUser]);
    }
    //
    public function getAllUser()
    {
        $data = DB::table('users')->select('name', 'id')->where('id', '<>',  session()->get('id'))->get()->toArray();
        echo json_encode($data);
    }
    public  function addMemberToGroup(Request $request)
    {

        $member = explode(',', $request->input('member'));
        $personCreateGroup =  session()->get('id');
        $nameGroup = $request->input('nameGroup');
        $data_save = [
            'creativer_gr_id' => $personCreateGroup,
            'name_group' => $nameGroup,
            'created_at' =>  date("Y-m-d H:i:s", strtotime('now')),
        ];
        $idGroup = GeneralModel::addGetId('groups', $data_save);
        foreach ($member as $key => $val) {
            GeneralModel::add('gr_members', ['member_id' => $val, 'gr_id' => $idGroup,  'created_at' =>  date("Y-m-d H:i:s", strtotime('now')),]);
        }
        echo json_encode(['rs' => true]);
    }
}
