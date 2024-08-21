<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_barangs');
    }
}
