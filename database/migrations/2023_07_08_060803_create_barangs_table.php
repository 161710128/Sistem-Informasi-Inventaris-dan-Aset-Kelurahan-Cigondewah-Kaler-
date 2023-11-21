<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id');
            $table->string('kode_barang')->unique();
            $table->string('kode_label')->unique();
            $table->string('slug');
            $table->string('nama_barang');
            $table->string('merk');
            $table->string('spesifikasi');
            $table->decimal('harga', 20, 2);
            $table->enum('satuan', ['unit', 'buah', 'dus', 'pak', 'bal']);
            $table->integer('jumlah_barang');
            $table->decimal('total_biaya', 20, 2);
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
        Schema::dropIfExists('barangs');
    }
}
