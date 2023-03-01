<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;

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
}
