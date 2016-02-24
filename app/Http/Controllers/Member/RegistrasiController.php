<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App;
use Sentinel;
use Mail;

class RegistrasiController extends Controller
{
    public function index()
    {
        //FORM konfirmasi pembayaran registrasi
        $user = Sentinel::getUser();
        $formatter = new App\Http\Libraries\Formatters;
        $bank_tujuan = '';
        $arrBankTujuan = explode(',',env('BANK_DESTINATION'));
        foreach($arrBankTujuan as $key => $value)
        {
            $bank_tujuan .= '<option value="'.$value.'">'.$value.'</option>';
        }
        $show_array = array(
            'user'          => $user,
            'bank_tujuan'   => $bank_tujuan,
            'jmltransfer'   => $formatter->currencyFormat(env('REGISTERFEE')+$user->lasttwodigit,true,',-')
        );
        return view('theme01/member/konfirmasibayar',$show_array);
    }
    public function store(Request $request)
    {
        $user = Sentinel::getUser();
        $now = date('Y-m-d H:i:s');
        $formatter = new App\Http\Libraries\Formatters;        
        $jmltransfer = abs((int) filter_var($request->jmltransfer, FILTER_SANITIZE_NUMBER_INT));
        $rules = array(
             'jmltransfer'  => 'required',
             'banktujuan'   => 'required',
             'tgltransfer'  => 'required',
             'rekNo'        => 'required',
             'rekNama'      => 'required',
             'rekBank'      => 'required',
        );
        $messages = array(
            'jmltransfer.required'  => 'Kolom JUMLAH (transfer) harus diisi.',
            'banktujuan.required'   => 'Kolom TRANSFER KE (bank apa) harus diisi.',
            'tgltransfer.required'  => 'Kolom TGL TRANSFER (transfer kapan) harus diisi.',
            'rekNo.required'        => 'Kolom NOMOR REKENING (pengirim) harus diisi.',
            'rekNama.required'      => 'Kolom ATAS NAMA (rekening pengirim)  harus diisi.',
            'rekBank.required'      => 'Kolom BANK (nama bank rekening pengirim) harus diisi.'
        );
        $validator     = Validator::make($request->all(), $rules, $messages);
        if (($validator->fails()) || ($jmltransfer < env('REGISTERFEE')))
        {
            if ($jmltransfer < env('REGISTERFEE'))
            $validator->getMessageBag()->add('notenoughamount', 'Jumlah TRANSFER kurang dari '.$formatter->currencyFormat(env('REGISTERFEE'),true,',-').'.');
            return redirect()->route('user.confirmpayment')->withErrors($validator->messages())->withInput();
        } else {
            $arrSender = array (
                'Nomor Rekening' => $request->rekNo,
                'Atas Nama' => $request->rekNama,
                'Bank' => $request->rekBank,
                'Rekening Tujuan' => $request->banktujuan
            );
        }
        $credentials = [
            'regpaymentconfirm' => $now,
            'regpayment'        => $request->tgltransfer,
            'regamount'         => $jmltransfer,
            'regsender'         => $arrSender
        ];
        if (Sentinel::validForUpdate($user, array('email'=>$user->email)))
        {
            $user = Sentinel::update($user, $credentials);
            //$data ini yang dipakai untuk mengganti token di template email
            $data = [
                'from_email'        => env('MAIL_USERNAME'),
                'from_name'         => env('APP_NAME'),
                'to_email'          => env('MAIL_USERNAME'),
                'to_name'           => env('APP_ADMIN'),
                'user_name'         => $user->first_name,
                'user_username'     => $user->username,
                'user_email'        => $user->email,
                'jml_transfer'      => $formatter->currencyFormat($jmltransfer,true,',-'),
                'rek_tujuan'        => $request->banktujuan,
                'rek_no'            => $request->rekNo,
                'rek_nama'          => $request->rekNama,
                'rek_bank'          => $request->rekBank
            ];
            if (view()->exists('emails.member.konfirmasibayar')) {
                Mail::send('emails.member.konfirmasibayar', $data, function ($m) use ($data) {
                    $m->from($data['from_email'], $data['from_name']);
                    $m->to($data['from_email'],$data['to_email'])->subject($data['to_name'].', ada konfirmasi pembayaran ('.$data['from_name'].')');
                });
            }
            $msg = '<li>Konfirmasi pembayaran telah dikirimkan.</li>
            <li>Tunggu konfirmasi lunas oleh ADMIN.</li>
            ';
            $request->session()->flash('flash_message', $msg);
        } else {
            $request->session()->flash('flash_message', '<li>Anda tidak punya hak untuk akses halaman ini.</li>');
        }
        return view('theme01/member/message');
    }
}
