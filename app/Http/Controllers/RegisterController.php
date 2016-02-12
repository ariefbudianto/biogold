<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;//untuk set get cookies
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Sentinel;
use Mail;
use Activation;
use App;
use App\User;

class RegisterController extends Controller
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
    public function create()
    {
        $show_array = array(
            'sponsor'   => $this->Upline
        );
        return view('theme01/register', $show_array);
    }
    public function store(Request $request)
    {
        $rules = array(
             'first_name'    => 'required',
             'email'         => 'required|email|unique:users,email,:id',
             'handphone'     => 'required',
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'required'  => 'Kolom ini harus diisi.',
            'email'     => 'Format email tidak valid',
            'unique'    => 'Email sudah terdaftar, tidak bisa digunakan kembali'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            //echo $validator->messages();//menampilkan semua message error
            return redirect('register')->withErrors($validator->messages())->withInput();
        } else {
             // PROSES REGISTRASI USER 
            $generator = new App\Http\Libraries\Generators;         
            $password = $generator->generateCode(8);
            $newUsername = $generator->autousername();
            $user = Sentinel::register([
                    'first_name'    => $request->first_name,
                    'username'      => $newUsername,
                    'email'         => $request->email,
                    'password'      => $password,
                    'handphone'     => $request->handphone,
            ]);
            // PROSES MASUKAN USER KE DALAM ROLE
            $user = Sentinel::findById($user->id);
            $role = Sentinel::findRoleByName('Members');//dibuat dulu bila blm ada Role nya
            $role->users()->attach($user);
            $activation = Activation::create($user);
            //$activation = Activation::exists($user);
            //Username dan handphone dimasukkan manual, karena sentinel tidak bisa menerima parameter lain
            $user->username  = $newUsername;
            $user->username_upline  = $this->Upline;
            $user->handphone = $request->handphone;
            $user->save();
            $data = [
             'id'            => $user->id,
             'username'      => $newUsername,
             'name'          => $user->first_name,
             'email'         => $user->email,
             'password'      => $password,
             'handphone'     => $user->handphone,
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
                'sponsor'    => $this->Upline,
                'msg' => '<li>Registrasi sukses. <br />Silahkan cek email Anda, sebuah link aktifasi telah kami kirimkan.</li>'
            );
            return view('theme01/message',$show_array);
        }
    }
    public function activate($activationCode,$id)
    {
        $user = Sentinel::findById($id);
        if (!empty($user))
        {
            if (Activation::complete($user, $activationCode))
            {
                // Activation was successfull
                $message = '<li>Aktifasi berhasil. Silahkan login ke MEMBER AREA dan lengkapi semua data profil '.$user->first_name.'.</li>';

            } elseif ($activation = Activation::completed($user))
            {
                // User has completed the activation process
                $message = '<li>Aktifasi sudah dilakukan.</li>';
            } else {
                // Activation not found or not completed
                $message = '<li>Aktifasi gagal.</li>';
            }
        } else {
            $message = '<li>Member tidak dikenali.</li>';
        }
        $show_array = array(
            'sponsor'    => $this->Upline,
            'msg' => $message
        );
        return view('theme01/message',$show_array);
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
