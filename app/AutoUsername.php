<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoUsername extends Model
{
    protected $table = 'autousername';
    protected $fillable = ['username'];
}
