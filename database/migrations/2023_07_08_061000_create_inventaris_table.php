<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id');
            $table->foreignId('transaksi_pengadaan_id');
            $table->string('kode_inventaris')->unique();
            $table->string('slug')->unique();
            $table->enum('kondisi', ['baik', 'buruk']);
            $table->enum('status', ['Tersedia', 'Dipakai', 'Dipinjam', 'Pemeliharaan', 'Habis Pakai']);
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
        Schema::dropIfExists('inventaris');
    }
}
