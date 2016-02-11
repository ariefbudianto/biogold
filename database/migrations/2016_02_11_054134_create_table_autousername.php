<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAutousername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //bikin tabel autousername
        Schema::create('autousername', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->timestamps();//otomatis nanti buat kolom created_at dan update_at
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
