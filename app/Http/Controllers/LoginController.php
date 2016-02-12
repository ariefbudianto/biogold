<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;//untuk set get cookies

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\User;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('refUsername'))
            $this->Upline = $request->session()->get('refUsername'); 
        else $this->Upline = '';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $show_array = array(
            'sponsor'   => $this->Upline
        );
        return view('theme01/login', $show_array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAuth()
    {
        echo 'arrggghh';
    }
}
