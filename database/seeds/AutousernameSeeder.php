<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AutousernameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // kosongkan table autousername
        DB::table('autousername')->delete();
        if(function_exists('date_default_timezone_set')) date_default_timezone_set("Asia/Jakarta");
        $DateTime   = date('Y-m-d H:i:s'); 
        // buat data berupa array untuk diinput ke database 
        $firstrecord = array(
            array('username'=>'AAA000', 'created_at'=>$DateTime)
        );
        // masukkan data ke database 
        DB::table('autousername')->insert($firstrecord);

        Model::reguard();
    }
}
