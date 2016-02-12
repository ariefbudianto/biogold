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
            $this->newSponsor = $request->session()->get('refUsername'); 
        else $this->newSponsor = '';
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $welcome = "<h1>Halo</h1>
        Selamat datang di BioGold network.";
        $show_array = array(
            'sponsor'   => $this->newSponsor,
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
            'sponsor'    => $this->newSponsor,
            'listproduk' => $listproduk
        );
        return view('theme01/produk',$show_array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
