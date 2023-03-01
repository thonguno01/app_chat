<?php

namespace App\Http\Helpers;

use App\Models\GeneralModel;
use Illuminate\Support\Facades\DB;

class Helper
{
    static public function checkLogin()
    {
        $check_login =  session()->get('isLogin');
        if (!isset($check_login) || $check_login == null) {
            return redirect('/login')->with('isLogin', 'Bạn phải đăng nhập mới vào được page');
        }
    }
}
