<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertColRegpaidUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Menambahkan kolom regpaid (tgllunas) ke tabel users
        Schema::table('users', function($table)
        {
            $table->datetime('regpaid')->after('regamount');//tgl ditandai lunas oleh ADMIN
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
