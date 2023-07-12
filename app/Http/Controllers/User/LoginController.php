<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SendVeryfyMail;
use App\Models\GeneralModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        $css = ['asset\css\login.css'];
        $data = [
            'css' => $css,
        ];

        return view('page.user.login', $data);
    }
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
    public function login(Request $request)
    {
        
        $validate = $request->validate([
            'email' => 'required',
            'pass_word' => 'required'
        ], [
            'email.required' => 'Không được bỏ trống email',
            'pass_word.required' => 'Không được bỏ trống mật khẩu',
        ]);
        $email = $request->input('email');
        $password = $request->input('pass_word');
        $check = GeneralModel::selectData('*', 'users', ['email' => $email, 'password' => md5($password)], 'array');
        if ($check == null) {
            return redirect()->back()->with('errorLogin', 'Email hoặc mật khẩu của bạn nhập không đúng ! Vui lòng nhập lại');
        } else {
            if ($check->authentic == 0) {
                $code = rand(100000, 999999);
                $update_code = GeneralModel::updateData('users', ['id' => $check->id], ['code' => $code]);
                Mail::to($email)->send(new SendVeryfyMail($check->name, $email, $code));
                return redirect("/email-verify/" . $check->id)->with('success', ' Vui lòng vào gmail lấy mã OTP');
            } else {
                $remember = $request->input('remember_pass');
                if (isset($remember)) {
                    echo 'lưu cookie';
                }
                $data_seesion = [
                    'id' => $check->id,
                    'name' => $check->name,
                    'email' => $check->email,
                    'isLogin' => true,
                ];
                session($data_seesion);
                return redirect('/');
            }
        }
    }
}
