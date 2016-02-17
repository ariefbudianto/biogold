<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;//untuk set get cookies
use App;//untuk menarik isi libraries
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('refUsername'))
            $this->Upline = $request->session()->get('refUsername'); 
        else $this->Upline = '';
    }
    public function index(Request $request)
    {
        $welcome = "<h1>Halo</h1>
        Selamat datang di BioGold network.";
        $show_array = array(
            'sponsor'   => $this->Upline,
            'part1' => $welcome
        );
        return view('theme01/index',$show_array);
    }

    public function produk()
    {
        $listproduk = '';
        $produk =  App\Product::all();
        foreach ($produk as $list)
        {
            $listproduk .= $list->name;
            $listproduk .= $list->price;
            $listproduk .= '<br />';
        }
         $show_array = array(
            'sponsor'    => $this->Upline,
            'listproduk' => $listproduk
        );
        return view('theme01/produk',$show_array);
    }
}
