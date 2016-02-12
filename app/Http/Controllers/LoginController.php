<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;//untuk set get cookies

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Sentinel;
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

    public function logout()
    {
        //Sentinel::logout();
        Sentinel::logout(null, true);
        return redirect()->route('user.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAuth(Request $request)
    {
        $rules = array(
             'email'    => 'required|email',
             'password' => 'required'
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'required'  => 'Kolom ini harus diisi.',
            'email'     => 'Format email tidak valid'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect('login')->withErrors($validator->messages())->withInput();
        } else {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];
            if ($auth = Sentinel::authenticate($credentials))
            {
                // User is logged in and assigned to the `$user` variable.
                return redirect()->route('user.profile');
            }
            else
            {
                // User is not logged in
                //$request->session()->flash('status', 'Task was successful!');
                return redirect('login')->withInput()->withErrors('Email atau password salah.');
            }
        }
    }
}
