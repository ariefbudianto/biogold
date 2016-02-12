<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Sentinel;
use App;

class Sponsor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (null !== $request->ref) $refSponsor = $request->ref; else $refSponsor = '';
        if (null !== $request->cookie('refCookiesUsername')) $cookSponsor = $request->cookie('refCookiesUsername'); else $cookSponsor = '';
        if ($request->session()->has('refUsername')) $sesSponsor = $request->session()->get('refUsername'); else $sesSponsor = '';

        //Ada parameter
        if (!empty($refSponsor))
        { //parameter cookies session  = 1 0 0 = session ambil dari parameter, set cookies dan set session
            $user =  App\User::where('username', $refSponsor)->first();
            if (null !== $user)
            {
                $newSponsor = $user->username;
            } else {
                $newSponsor = env('SPONSOR_DEFAULT');//ganti dgn record User where username = $refSponsor
            }
            $request->session()->put('refUsername', $newSponsor);
            return $next($request)->withCookie('refCookiesUsername', $newSponsor, 129600);//3 bulan. karena dalam menit, 1 hari = 1440. 
        } elseif ( (empty($refSponsor)) && (empty($cookSponsor)) && (empty($sesSponsor)) )
        {//parameter cookies session = 0 0 0 ambil dari database, where username ='default', set cookis & set session
            $newSponsor = 'pertama';//ganti dgn record User
            $request->session()->put('refUsername', $newSponsor);
            return $next($request)->withCookie('refCookiesUsername', $newSponsor, 129600);//3 bulan. karena dalam menit, 1 hari = 1440. 
        } elseif ( (empty($refSponsor)) && (empty($cookSponsor)) && (!empty($sesSponsor)) ) 
        { //parameter cookies session = 0 0 1  = ambil dari session, set cookies
            return $next($request)->withCookie('refCookiesUsername', $sesSponsor, 129600);
        } elseif ( (empty($refSponsor)) && (!empty($cookSponsor)) && (!empty($sesSponsor)) ) 
        { //parameter cookies session  = 0 1 0   = set session from cookies
            $request->session()->put('refUsername', $cookSponsor);
            return $next($request);
        } elseif ( (!empty($refSponsor)) && (empty($cookSponsor)) && (empty($sesSponsor)) ) 
        { //parameter cookies session  = 1 0 0 = session ambil dari parameter, set cookies dan set session
            $newSponsor = $refSponsor;//ganti dgn record User where username = $refSponsor
            $request->session()->put('refUsername', $newSponsor);
            return $next($request)->withCookie('refCookiesUsername', $newSponsor, 129600);//3 bulan. karena dalam menit, 1 hari = 1440. 
        } else return $next($request);
    }
}
