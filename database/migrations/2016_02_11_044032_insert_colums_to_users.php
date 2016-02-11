<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertColumsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Menambahkan beberapa kolom ke tabel users
        Schema::table('users', function($table)
        {
            //mengubah nama kolom first_name
            //$table->renameColumn('first_name', 'full_name');
            //menghapus kolom last_name
            //$table->dropColumn('last_name');
            //menambah kolom2 baru
            $table->string('username',255)->after('id');
            $table->string('gender',1)->default('M')->after('last_name');//M=male, F=female
            $table->string('address1',64)->after('gender');
            $table->string('address2',64)->after('address1');      
            $table->string('city',32)->after('address2');     
            $table->string('province',24)->after('city');     
            $table->string('country',32)->default('Indonesia')->after('province');
            $table->string('handphone',16)->after('country');
            $table->text('bank')->after('handphone');
            $table->tinyInteger('lasttwodigit')->default('0')->after('bank');
            $table->date('regdate')->after('lasttwodigit');//tgl register
            $table->date('regpayment')->after('regdate');//tgl pembayaran registrasi
            //jml transfer //Unsigned artinya tidak bisa menyimpan bilangan < 0 
            $table->integer('regamount')->unsigned()->after('regpayment');
            $table->text('regsender')->after('regamount');//informasi rekening sender
            $table->text('contactbox')->after('regsender');
            $table->boolean('subscribe')->default(true)->after('contactbox');
            $table->string('refip',12)->after('subscribe');
            $table->string('refloc',32)->after('refip');
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