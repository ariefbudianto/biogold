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
            $request->session()->flash('add_class_error', 'has-error');
            return redirect()->route('user.signup')->withErrors($validator->messages())->withInput();
        } else {
            // PROSES REGISTRASI USER 
            $generator = new App\Http\Libraries\Generators;         
            $password = $generator->generateCode(8);
            $lasttwodigit = $generator->generateCode(2,true);
            $newUsername = $generator->autousername();
            $user = Sentinel::register([
                    'first_name'    => $request->first_name,
                    'username'      => $newUsername,
                    'username_upline' => $this->Upline,
                    'lasttwodigit'  => $lasttwodigit,
                    'email'         => $request->email,
                    'password'      => $password,
                    'handphone'     => $request->handphone
            ]);
            // PROSES MASUKAN USER KE DALAM ROLE
            $user = Sentinel::findById($user->id);
            $role = Sentinel::findRoleByName('Members');//dibuat dulu bila blm ada Role nya
            $role->users()->attach($user);
            $activation = Activation::create($user);
            //$activation = Activation::exists($user);
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
            $request->session()->flash('flash_message', '<li>Registrasi sukses. <br />Silahkan cek email Anda, sebuah link aktifasi telah kami kirimkan.</li>');
            $show_array = array(
                'sponsor'    => $this->Upline
            );
            return view('theme01/message',$show_array);
        }
    }
    public function activate($activationCode,$id,Request $request)
    {
        $user = Sentinel::findById($id);
        if (!empty($user))
        {
            if (Activation::complete($user, $activationCode))
            {
                // Activation was successfull
                return redirect('login')->withErrors('Aktifasi berhasil. Silahkan login ke MEMBER AREA dan lengkapi semua data profil '.$user->first_name.'.');
            } elseif ($activation = Activation::completed($user))
            {
                // User has completed the activation process
                $request->session()->flash('flash_message', '<li>Aktifasi sudah dilakukan.</li>');
            } else {
                // Activation not found or not completed                
                $request->session()->flash('flash_message', '<li>Aktifasi gagal.</li>');
            }
        } else {
            $request->session()->flash('flash_message', '<li>Member tidak dikenali.</li>');
        }
        $show_array = array(
            'sponsor'    => $this->Upline
        );
        return view('theme01/message',$show_array);
    }
}
