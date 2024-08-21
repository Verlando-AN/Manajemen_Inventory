<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->integer('jumlah');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
