<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_barang_id')->constrained('jenis_barangs')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('barcode')->unique();
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
