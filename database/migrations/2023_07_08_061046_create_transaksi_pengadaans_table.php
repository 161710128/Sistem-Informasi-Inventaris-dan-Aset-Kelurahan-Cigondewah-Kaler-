<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pengadaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id');
            $table->string('kode_transaksi_pengadaan')->unique();
            $table->string('slug');
            $table->date('tgl_transaksi_pengadaan');
            $table->enum('jenis_pengadaan', ['pembelian', 'hibah', 'sumbangan', 'donasi', 'hadiah']);
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
        Schema::dropIfExists('transaksi_pengadaans');
    }
}
