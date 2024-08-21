<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('nama_laptop');
            $table->enum('jenis_kerusakan', ['normal', 'sedang', 'parah']);
            $table->text('deskripsi')->nullable();
            $table->timestamps(); 
        });

        Schema::create('foto_kerusakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporans')->onDelete('cascade');
            $table->string('path'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_kerusakans');
        Schema::dropIfExists('laporans');
    }
}

