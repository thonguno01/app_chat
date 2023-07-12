<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = ['parend_id', 'message', 'type', 'status'];
    public $id_user;
    static public function getMessage($id_user_messages)
    {
        return  DB::table('user_messages')
            ->join('messages', 'user_messages.message_id', '=', 'messages.id')
            ->join('users', 'user_messages.sender_id', '=', 'users.id')
            ->select('user_messages.*', 'messages.message as content', 'messages.message_img as contentImage')
            ->where('user_messages.id', $id_user_messages)
            ->first();
    }
    static public  function getAllMessageOfOneUser($id_user)
    {
        session(['idUserGetMessage' => $id_user]);
        $arr = ['u_mes.sender_id' => $id_user, 'u_mes.receider_id' => session()->get('id')];
        $query =  DB::table('user_messages as u_mes')
            ->join('users as u', 'u_mes.receider_id', '=', 'u.id')
            ->join('messages as mes', 'mes.id', '=', 'u_mes.message_id')
            ->select('mes.message', 'mes.message_img', 'u_mes.*',)
            ->where(['u_mes.receider_id' => $id_user, 'u_mes.sender_id' => session()->get('id') , 'u_mes.type' => 0])
            ->orWhere(function ($query) {
                $query->where(['u_mes.sender_id' => session()->get('idUserGetMessage'), 'u_mes.receider_id' => session()->get('id'), 'u_mes.type' => 0]);
            })
            ->orderBy('u_mes.created_at', 'ASC')
            ->get()->toArray();
        session()->forget('idUserGetMessage');
        return $query;
    }
    static public  function getAllMessageImageOfOneUser($id_user)
    {
        session(['idUserGetMessage' => $id_user]);
        $arr = ['u_mes.sender_id' => $id_user, 'u_mes.receider_id' => session()->get('id')];
        $query =  DB::table('user_messages as u_mes')
            ->join('users as u', 'u_mes.receider_id', '=', 'u.id')
            ->join('messages as mes', 'mes.id', '=', 'u_mes.message_id')
            ->select('mes.message_img')
            ->whereNotNull('mes.message_img')
            ->where(['u_mes.receider_id' => $id_user, 'u_mes.sender_id' => session()->get('id')])
            ->orWhere(function ($query) {
                $query->whereNotNull('mes.message_img');
                $query->where(['u_mes.sender_id' => session()->get('idUserGetMessage'), 'u_mes.receider_id' => session()->get('id')]);
            })
            ->orderBy('u_mes.created_at', 'ASC')
            ->get()->toArray();
        session()->forget('idUserGetMessage');
        return $query;
    }

    static public function updateStatusMessage($id_user)
    {

        session(['idUserGetMessage' => $id_user]);
        $arr = ['u_mes.sender_id' => $id_user, 'u_mes.receider_id' => session()->get('id')];
        $query =  DB::table('user_messages as u_mes')
            ->join('users as u', 'u_mes.receider_id', '=', 'u.id')
            ->join('messages as mes', 'mes.id', '=', 'u_mes.message_id')
            ->where(['u_mes.receider_id' => $id_user, 'u_mes.sender_id' => session()->get('id')])
            ->orWhere(function ($query) {
                $query->where(['u_mes.sender_id' => session()->get('idUserGetMessage'), 'u_mes.receider_id' => session()->get('id')]);
            })
            ->update(['u_mes.seen_status' => 1]);
        session()->forget('idUserGetMessage');
    }
}
