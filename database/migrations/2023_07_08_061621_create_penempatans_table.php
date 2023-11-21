<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenempatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penempatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id');
            $table->string('kode_penempatan')->unique();
            $table->string('slug')->unique();
            $table->date('tgl_penempatan');
            $table->string('lokasi');
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
        Schema::dropIfExists('penempatans');
    }
}
