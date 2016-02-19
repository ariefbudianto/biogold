<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Events\ReminderEvent;
use Event;
use Sentinel;
use Reminder;

class ReminderController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('refUsername'))
            $this->Upline = $request->session()->get('refUsername'); 
        else $this->Upline = '';
    }
    public function create() {
        $show_array = array(
            'sponsor'   => $this->Upline
        );
        return view('theme01.resetpassword',$show_array);
    }
    public function store(Request $request)
    {
        $user = Sentinel::findByCredentials(array('login'=>$request->login));

        if ($user) {
            ($reminder = Reminder::exists($user)) || ($reminder = Reminder::create($user));

            Event::fire(new ReminderEvent($user, $reminder));
            $msg = '<li>Cek email Anda. Sebuah email untuk reset password telah dikirimkan.</li>';
        } else {
            $msg = '<li>Email atau username tidak ada di database.</li>';
        }
        $request->session()->flash('flash_message', $msg);
        $show_array = array(
            'sponsor'    => $this->Upline
        );
        return view('theme01/message',$show_array);
    }
    public function edit($id,$code,Request $request)
    {
        $user = Sentinel::findById($id);

        $show_array = array(
            'sponsor'   => $this->Upline
        );
        if (Reminder::exists($user, $code)) {
            return view('theme01.newpassword', ['id' => $id, 'code' => $code], $show_array);
        }
        else {            
            $msg = '<li>Link reset password sudah kadaluarsa. <br />Silahkan ulangi lagi langkah lupa password.</li>';
            $request->session()->flash('flash_message', $msg);
            $show_array = array(
                'sponsor'    => $this->Upline
            );
            return view('theme01/message',$show_array);
        }
    }
    public function update($id,$code,Request $request)
    {
        $rules = array(
             'newpassword'      => 'confirmed|required|min:5',
             'newpassword_confirmation' => 'required'
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'newpassword.required'           => 'Kolom INPUT PASSWORD BARU harus diisi.',
            'newpassword_confirmation.required'  => 'Kolom ULANGI PASSWORD BARU harus diisi.',
            'confirmed'                     => 'Isi PASSWORD BARU dan ULANGI PASSWORD BARU tidak sama.',
            'min'                           => 'Password min. :min karakter'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect()->route('user.passwordnew',['id' => $id, 'code' => $code])->withErrors($validator->messages())->withInput();
        } else {
            $user = Sentinel::findById($id);
            $reminder = Reminder::exists($user, $code);
            if ($reminder == false) 
            {
                $msg = '<li>Link reset password sudah kadaluarsa.</li>';
            } else {
                Reminder::complete($user, $code, $request->newpassword);
                $msg = '<li>Password baru sudah tersimpan di database.</li>';
            }
            $request->session()->flash('flash_message', $msg);
            $show_array = array(
                'sponsor'    => $this->Upline
            );
            return view('theme01/message',$show_array);
        }
    }
}
