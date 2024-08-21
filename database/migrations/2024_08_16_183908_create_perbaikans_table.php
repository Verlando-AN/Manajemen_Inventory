<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbaikansTable extends Migration
{
    public function up()
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->date('tanggal_perbaikan');
            $table->string('keterangan_perbaikan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perbaikans');
    }
}
