<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengadaanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->references('id')->on('barangs')->constrained()->onDelete('cascade');
            $table->foreignId('transaksi_pengadaan_id')->references('id')->on('transaksi_pengadaans')->constrained()->onDelete('cascade');
            $table->string('kode_pengadaan_item')->unique();
            $table->string('slug');
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
        Schema::dropIfExists('pengadaan_items');
    }
}
