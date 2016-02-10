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
    public function create()
    {
        return view('theme01/register');
    }
    public function store(Request $request)
    {
        // $rules = array(
        //     'first_name'    => 'required',
        //     'email'         => 'required|email|unique:users,email,:id', 
        //     'password'      => 'confirmed|required|min:5',
        // );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'required'  => 'Kolom ini harus diisi.',
            'confirmed' => 'Password dan ulangi password tidak sama',
            'email'     => 'Format email tidak valid',
            'unique'    => 'Email sudah terdaftar, tidak bisa digunakan kembali',
            'min'       => 'Minimal :min karakter'
        );
        $validator     = Validator::make($request->all(), User::$rules, $messages);
        if ($validator->fails())
        {
            //echo $validator->messages();//menampilkan semua message error
            return redirect('register')->withErrors($validator->messages())->withInput();
        } else {
             // PROSES REGISTRASI USER
            $user = Sentinel::register([
                    'first_name'    => $request->first_name,
                    'email'         => $request->email,
                    'password'      => $request->password,
            ]);
            // PROSES MASUKAN USER KE DALAM ROLE
            $user = Sentinel::findById($user->id);
            $role = Sentinel::findRoleByName('Members');//dibuat dulu bila blm ada Role nya
            $role->users()->attach($user);
            $activation = Activation::create($user);
            //$activation = Activation::exists($user);
            $data = [
             'name'          => $user->first_name,
             'email'         => $user->email,
             'activationCode'=> $activation->code
            ];
            //$data ini yang dipakai untuk mengganti token di template email
            if (view()->exists('emails.auth.register')) {
                $user = User::findOrFail($user->id);
                Mail::send('emails.auth.register', $data, function ($m) use ($user) {
                    $m->from('admin@cakning.loc', 'Biogold');
                    $m->to($user->email, $user->first_name)->subject($user->first_name.', Aktivasi akun Biogold Anda');
                });
            }
            $show_array = array(
                'msg' => '<li>Registrasi sukses. <br />Silahkan cek email Anda, sebuah link aktifasi telah kami kirimkan.</li>'
            );
            return view('theme01/message',$show_array);
        }
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
