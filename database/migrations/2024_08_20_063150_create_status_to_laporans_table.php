<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusToLaporansTable extends Migration
{
    public function up()
    {
        Schema::create('statuss', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('proses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('statuss', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
