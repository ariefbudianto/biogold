<?php namespace App\Http\Middleware;

use Auth, Closure, Sentinel;
use App\Http\Models\Menu;

class AdminLoggedIn {

    public function handle($request, Closure $next)
    {
        if (!Sentinel::check()) {
            return redirect('app');
        } else {
        	$user 			= Sentinel::getUser();
			$permissions 	= $user->roles->first()->permissions;
            if (array_key_exists('app', $permissions) && !$user->banned) {
                if ($permissions['app']) {
                    return $next($request);
                } else {
                    return redirect('');
                }
            } else {
                return redirect('');
            }
        }
    }

}