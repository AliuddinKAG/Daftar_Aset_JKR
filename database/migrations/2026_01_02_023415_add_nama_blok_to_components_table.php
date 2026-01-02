<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            // Tambah column nama_blok selepas kod_blok
            $table->string('nama_blok')->nullable()->after('kod_blok');
        });
    }

    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('nama_blok');
        });
    }
};