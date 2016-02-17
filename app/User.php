<?php
namespace App;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

class User extends CartalystUser {

    protected $fillable = [
        'email',
        'username', 
        'password',
        'last_name',
        'first_name',
        'permissions',
        'username_upline',
        'gender',
        'address1',
        'address2',
        'city',
        'province',
        'country',
        'handphone',
        'bank',
        'lasttwodigit',
        'regpaymentconfirm',
        'regpayment',
        'regamount',
        'regsender',
        'contactbox',
        'subscribe',
        'refip'
    ];

}
