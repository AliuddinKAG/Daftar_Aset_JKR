<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->string('koordinat_x', 50)->nullable()->change();
            $table->string('koordinat_y', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->decimal('koordinat_x', 10, 7)->nullable()->change();
            $table->decimal('koordinat_y', 11, 7)->nullable()->change();
        });
    }
};