<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLaporansTable extends Migration
{
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
