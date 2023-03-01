<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SendVeryfyMail;
use App\Models\GeneralModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        $css = ['asset\css\register.css'];
        $data = [
            'css' => $css,
        ];

        return view('page.user.register', $data);
    }
    public function registerUser(Request $request)
    {
        $validate =  $request->validate([
            'Email' => 'required |unique:users,email',
            'Password' => 'required |confirmed|min: 8 ',
            'Fullname' => 'required ',
            'Tel' => 'required | numeric',
            'Address' => 'required'
        ], [
            'Email.required' => 'Email không được bỏ trống ',
            'Email.unique' => 'Email đã tồn tại trong hệ thống',
            'Password.required' => 'Mật khẩu không được bỏ trống ',
            'Password.confirmed' => 'Nhập lại mật khẩu không chính xác ',
            'Password.min' => 'Mật khẩu ít nhất là 8 kí tự ',
            'Fullname.required' => 'Họ và tên không được bỏ trống ',
            'Tel.required' => 'Số điện thoại không được bỏ trống ',
            'Tel.numeric' => 'Số điện thoại phải là kí tự số ',
            'Address.required' => 'Địa chỉ không được bỏ trống ',
        ]);
        $email = $request->input('Email');
        $pass  = $request->input('Password');
        $name = $request->input('Fullname');
        $phone = $request->input('Tel');
        $address = $request->input('Address');
        $code = rand(100000, 999999);
        // echo $code;
        // dd($code);
        // die;
        $data_save = [
            'email' => $email,
            'password' => md5($pass),
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'code' => $code
        ];
        Mail::to($request->input('Email'))->send(new SendVeryfyMail($name, $email, $code));
        // dd($data_save);
        $id =  GeneralModel::addGetId('users', $data_save);
        // var_dump($id);
        return redirect("/email-verify/" . $id)->with('success', 'Đăng ký thành công! Vui lòng vào gmail lấy mã OTP');
        // redirect trang xác thực 
    }
    public function verify($id)
    {
        $info = GeneralModel::selectData('*', 'users', ['id' => $id], 'array');
        if ($info == null) {
            return  redirect(route('register'))->with('errorVerify', 'Tài khoản không tồn tại trên hệ thống . Vui lòng đăng kí lại');
        }
        $data = [
            'css' => ['asset/css/registerVerify.css'],
            'js' => ['asset/js/registerVerify.js'],
            'info' => $info
        ];
        return view('page.user.RegisterVerify', $data);
    }
    public function verifyOTP(Request $request, $id)
    {
        $validate = $request->validate([
            'first' => 'required',
            'second' => 'required',
            'third' => 'required',
            'fourth' => 'required',
            'fifth' => 'required',
            'sixth' => 'required',
        ], [
            'first.required' => 'Số thứ không 1 được bỏ trống',
            'second.required' => 'Số thứ không 2 được bỏ trống',
            'third.required' => 'Số thứ không 3 được bỏ trống',
            'fourth.required' => 'Số thứ không 4 được bỏ trống',
            'fifth.required' => 'Số thứ không 5 được bỏ trống',
            'sixth.required' => 'Số thứ không 6 được bỏ trống',
        ]);
        $code = $request->input('first') . $request->input('second') . $request->input('third') . $request->input('fourth') . $request->input('fifth') . $request->input('sixth');
        $check =  GeneralModel::selectData('*', 'users', ['id' => $id, 'code' => $code], 'array');
        if ($check == null) {
            return redirect()->back()->with('errorOTP', 'Mã OTP bạn nhập chưa chính xác');
        } else {
            if ($check->authentic == 1) {
                return redirect()->back()->with('errorOTP', 'Tài khoản đã được xác thực');
            } else {

                GeneralModel::updateData('users', ['id' => $id], ['authentic' => '1']);
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
