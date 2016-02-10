<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // kosongkan table posts
        DB::table('products')->delete();
        // buat data berupa array untuk diinput ke database 
        $produk = array(
            array('name'=>'Teh botol Sosro', 'price'=>'3500'),
            array('name'=>'Mouse Logitech', 'price'=>'250000')
        );
        // masukkan data ke database 
        DB::table('products')->insert($produk);

        Model::reguard();
    }
}
