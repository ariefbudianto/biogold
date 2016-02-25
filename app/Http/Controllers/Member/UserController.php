<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use App;
use App\Http\Controllers\Controller;
use Sentinel;

class UserController extends Controller
{
    public function edit()
    {
       // view()->addLocation('/resources/views/theme01/member'); 
        $user = Sentinel::getUser();
        $formatter = new App\Http\Libraries\Formatters;
        if ($user->gender=='M') $checkM = 'checked="true"'; else $checkM = '0';
        if ($user->gender=='F') $checkF = 'checked="true"'; else $checkF = '0';
        //Informasi rekening
        $arrBanks = $user->bank;
        $user->rekNo = $arrBanks['Nomor Rekening'];
        $user->rekNama = $arrBanks['Atas Nama'];
        $user->rekBank = $arrBanks['Bank'];
        $user->rekCabang = $arrBanks['Cabang'];
        $user->rekKota = $arrBanks['Kota'];

        if (!empty($user->regpaymentconfirm) && ($user->regpaymentconfirm<>'0000-00-00 00:00:00'))
            $tglkonfirmasi = $formatter->tgl_indo($user->regpaymentconfirm);
        else 
            $tglkonfirmasi = 'Belum ada konfirmasi';
        if (!empty($user->regpayment) && ($user->regpayment<>'0000-00-00 00:00:00'))
            $tgltransfer = $formatter->tgl_indo($user->regpayment);
        else 
            $tgltransfer = 'Belum ditransfer';
        if (!empty($user->regamount) && ($user->regamount>0))
            $jmltransfer = $formatter->currencyFormat($user->regamount,true,',-');
        else 
            $jmltransfer = 'Belum ditransfer';
        if (!empty($user->regpaid) && ($user->regpaid<>'0000-00-00 00:00:00'))
            $tgllunas = $formatter->tgl_indo($user->regpaid);
        else 
            $tgllunas = 'Belum dikonfirmasi lunas oleh ADMIN.';
        $show_array = array(
            'user'          => $user,
            'checkM'        => $checkM,
            'checkF'        => $checkF,
            'tglkonfirmasi' => $tglkonfirmasi,
            'tgltransfer'   => $tgltransfer,
            'jmltransfer'   => $jmltransfer,
            'tgllunas'      => $tgllunas
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
        } else {
            $arrBanks = array (
                    'Nomor Rekening' => $request->rekNo,
                    'Atas Nama' => $request->rekNama,
                    'Bank' => $request->rekBank,
                    'Cabang' => $request->rekCabang,
                    'Kota' => $request->rekKota,
                );
            //ContactBox
            if (empty($request->contactbox))
            {
                $contactbox = '<strong>'.$request->first_name.'</strong>';
                if ($request->handphone) $contactbox .= '<br />'.$request->handphone;
                if ($user->email) $contactbox .= '<br />'.$user->email;                
            } else {
                $contactbox = $request->contactbox;
            }
            $credentials = [
                'first_name'=> $request->first_name,
                'gender'    => $request->gender,
                'handphone' => $request->handphone,
                'address1'  => $request->address1,
                'address2'  => $request->address2,
                'city'      => $request->city,
                'province'  => $request->province,
                'country'   => $request->country,
                'bank'      => $arrBanks,
                'contactbox'=> $contactbox
            ];
            if (Sentinel::validForUpdate($user, array('email'=>$user->email)))
            {
                $user = Sentinel::update($user, $credentials);
                return redirect()->route('user.profile');
            } else {
                $request->session()->flash('flash_message', '<li>Anda tidak punya hak untuk mengubah profil.</li>');
                return view('theme01/message');
            }
        }
    }
    public function changepassword()
    {
        return view('theme01/member/changepassword');
    }
    public function dochangepassword(Request $request)
    {
        $hasher = Sentinel::getHasher();
        $user = Sentinel::getUser();
        $rules = array(
             'recentpassword'  => 'required',
             'newpassword'      => 'confirmed|required|min:5'
        );
        // MENERJEMAHKAN ERROR
        $messages = array(
            'recentpassword.required'       => 'Kolom INPUT PASSWORD LAMA harus diisi.',
            'newpassword.required'           => 'Kolom INPUT PASSWORD BARU harus diisi.',
            'newpassword_confirmation.required'   => 'Kolom ULANGI PASSWORD BARU harus diisi.',
            'confirmed'                     => 'Isi PASSWORD BARU dan ULANGI PASSWORD BARU tidak sama.',
            'min'                           => 'Password min. :min karakter'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if (($validator->fails()) || (!$hasher->check($request->recentpassword, $user->password)) )
        {
            if (!$hasher->check($request->recentpassword, $user->password)) $validator->getMessageBag()->add('oldnotexist', 'Password lama tidak sama dengan database.');
            return redirect()->route('user.changepassword')->withErrors($validator->messages())->withInput();
        } else {
            Sentinel::update($user, array('password' => $request->newpassword));
            return redirect()->route('user.profile');
        }
    }
}
