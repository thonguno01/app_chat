<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'css' => ['asset/css/trangchu.css'],
        ];
        // return view('page.user.RegisterVerify', $data);
        return view('trangchu', $data);
    }
}
