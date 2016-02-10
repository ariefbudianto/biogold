<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Sentinel;
use Mail;
use Activation;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerForm()
    {
        return view('theme01/register');
    }
    public function registerProccess(Request $request)
    {
        $rules = array(
            'first_name'    => 'required',
            'email'         => 'required|email|unique:users,email,:id', 
            'password'      => 'confirmed|required|min:5',
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'required'  => 'Kolom ini harus diisi.',
            'confirmed' => 'Password dan ulangi password tidak cocok',
            'email'     => 'Email tidak valid',
            'unique'    => 'Email sudah terdaftar, tidak bisa digunakan kembali',
            'min'       => 'Minimal :min karakter'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            //echo $validator->messages();
            return redirect('register')->withInput()->withErrors($validator->messages());
        } else {
            echo 'berhasil';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
