<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //protected $table = 'products' -> opsional bila nama tabel tidak plural (ada s)
    protected $fillable = ['name', 'price'];
}
