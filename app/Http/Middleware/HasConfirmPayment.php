<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Sentinel;

class HasConfirmPayment
{
    public function handle($request, Closure $next)
    {
        $user = Sentinel::getUser();
        $formatter = new App\Http\Libraries\Formatters;
        $tgl_konfirmasi = $formatter->tgl_indo($user->regpaymentconfirm);
        if (!empty($user->regpaymentconfirm) && ($user->regpaymentconfirm <> '0000-00-00 00:00:00'))
        {
            $msg = '
                <li>Anda telah mengkonfirmasi pembayaran pada tanggal '.$tgl_konfirmasi.'.</li>
                <li>Silahkan menunggu konfirmasi LUNAS dari ADMIN maksimal 2x24 jam kerja.</li>
                <li>Bila ada kesalahan, silahkan kontak ADMIN.</li>';
            $request->session()->flash('flash_message', $msg);
            return view('theme01/member/message');
        }
        return $next($request);
    }
}
