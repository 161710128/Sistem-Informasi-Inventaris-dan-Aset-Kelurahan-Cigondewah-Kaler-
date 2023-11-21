<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id');
            $table->foreignId('pegawai_id');
            $table->string('kode_pemakaian')->unique();
            $table->string('slug')->unique();
            $table->date('tgl_pemakaian');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemakaians');
    }
}
