<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHabisPakaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_habis_pakais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id');
            $table->foreignId('pegawai_id');
            $table->string('kode_barang_habis_pakai')->unique();
            $table->string('slug')->unique();
            $table->date('tgl_pemakaian_barang_habis_pakai');
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
        Schema::dropIfExists('barang_habis_pakais');
    }
}
