<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;

class UserController extends Controller
{
    public function edit()
    {
       // view()->addLocation('/resources/views/theme01/member'); 
       //return view('theme01/index',$show_array);
        $user = Sentinel::getUser();
        if ($user->gender=='M') $checkM = 'checked="true"'; else $checkM = '0';
        if ($user->gender=='F') $checkF = 'checked="true"'; else $checkF = '0';
        $show_array = array(
            'user'  => $user,
            'checkM' => $checkM,
            'checkF' => $checkF
        );
       //return view('theme01/member/profile',$show_array)->withUser(Sentinel::getUser());
        return view('theme01/member/profile',$show_array);
    }

    public function update(Request $request)
    {
        $user = Sentinel::getUser();
        $rules = array(
             'first_name'   => 'required',
             'gender'       => 'required',
             'handphone'    => 'required',
             'address1'     => 'required',
             'city'         => 'required',
             'province'     => 'required',
             'country'      => 'required',
             'rekNo'        => 'required',
             'rekNama'      => 'required',
             'rekBank'      => 'required',
             'rekCabang'    => 'required',
             'rekKota'      => 'required'
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'first_name.required'   => 'Kolom NAMA harus diisi.',
            'gender.required'       => 'Kolom GENDER harus dipilih (Pria atau Wanita).',
            'handphone.required'    => 'Kolom HANDPHONE harus diisi.',
            'address1.required'     => 'Kolom ALAMAT (baris pertama) harus diisi.',
            'city.required'         => 'Kolom KOTA harus diisi.',
            'province.required'     => 'Kolom PROPINSI harus diisi.',
            'country.required'      => 'Kolom NEGARA harus diisi.',
            'rekNo.required'        => 'Kolom NOMOR REKENING harus diisi.',
            'rekNama.required'      => 'Kolom NAMA (di rekening) harus diisi.',
            'rekBank.required'      => 'Kolom BANK (BCA, Mandiri, dll) harus diisi.',
            'rekCabang.required'    => 'Kolom CABANG (bank) harus diisi.',
            'rekKota.required'      => 'Kolom KOTA (asal bank) harus diisi.'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect()->route('user.profile')->withErrors($validator->messages())->withInput();
        }
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
