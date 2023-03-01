<?php

namespace App\Http\Controllers\Chat;

use App\Events\RedisEvent;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ChatHelper;
use App\Http\Helpers\Helper;
use App\Models\GeneralModel;
use App\Models\Messages;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $check_login =  session()->get('isLogin');
        if (!isset($check_login) || $check_login == null) {
            return redirect('/login')->with('isLogin', 'Bạn phải đăng nhập mới vào được page');
        }
        $data = [
            'css' => ['asset/css/chat.css'],

        ];
        return view('page.chat.Chat', $data);
    }
    public function chat($id)
    {
        $check_login =  session()->get('isLogin');
        if (!isset($check_login) || $check_login == null) {
            return redirect('/login')->with('isLogin', 'Bạn phải đăng nhập mới vào được page');
        }
        $checkUser  = GeneralModel::selectData('*', 'users', ['id' => $id], 'arrray');
        if ($checkUser == null) {
            return view('page.error404');
        }
        if ($checkUser->id == session()->get('id')) {
            return redirect(route('home.chat'));
        }
        // $updateStatusMessage = Messages::updateStatusMessage($id);
        $messageOfUser = Messages::getAllMessageOfOneUser($id);
        $messageImageOfUser = Messages::getAllMessageImageOfOneUser($id);
        $data = [
            'css' => ['asset/css/chat.css'],
            'js' => ['asset/js/lib/jquery.min.js', 'asset/js/lib/select2.min.js', 'asset/js/chat.js'],
            'receider_id' => $id,
            'messagesOfUser' => $messageOfUser,
            'messageImageOfUser' => $messageImageOfUser,
        ];
        return view('page.chat.message', $data);
    }
    public function sendMessage(Request $request)
    {
        $messageImg = isset($_FILES['messageImg']) ? $_FILES['messageImg'] : [];
        $messageImage = '';
        $uploadedFiles = array();
        if (count($messageImg) != 0) {
            foreach (request()->file('messageImg') as $file) {
                $path = 'upload/mesage/image/';
                $filename = $file->getClientOriginalName();
                $file->move(public_path($path), $filename);
                $uploadedFiles[] = $filename;
            }
        }
        // var_dump($uploadedFiles);
        // $validate =  $request->validate([
        //     'content_chat' => 'required',
        // ]);
        $messageImage = implode(',', $uploadedFiles);

        $message = ($request->input('message') == null) ? '' : $request->input('message');
        // dd($message);
        // die;
        $insert_tabl_message = [
            'parend_id' =>  0,
            'message' => $message,
            'message_img' => $messageImage,
            'created_at' =>  date("Y-m-d H:i:s", strtotime('now')),
        ];

        $message_id = GeneralModel::addGetId('messages', $insert_tabl_message);
        $insert_tbl_message_user = [
            'message_id' => $message_id,
            'sender_id' => session()->get('id'),
            'receider_id' => $request->input('id_receiver'),
            'created_at' =>  date("Y-m-d H:i:s", strtotime('now')),
        ];
        $id_user_messages = GeneralModel::addGetId('user_messages', $insert_tbl_message_user);

        // lưu db
        // tạo event 
        event(
            $e = new RedisEvent($id_user_messages)
        );
        $data = [
            'message' => $message,
            'messageImage' => $messageImage,
            'id_receiver' => $request->input('id_receiver'),
        ];
        echo json_encode($data);
    }
}
