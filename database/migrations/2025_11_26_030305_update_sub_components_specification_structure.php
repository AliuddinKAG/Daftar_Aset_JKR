<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sub_components', function (Blueprint $table) {
            // Change columns to simple string format
            $table->string('saiz')->nullable()->change();
            $table->string('saiz_unit', 50)->nullable()->change();
            $table->string('kadaran')->nullable()->change();
            $table->string('kadaran_unit', 50)->nullable()->change();
            $table->string('kapasiti')->nullable()->change();
            $table->string('kapasiti_unit', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('sub_components', function (Blueprint $table) {
            $table->text('saiz')->nullable()->change();
            $table->text('saiz_unit')->nullable()->change();
            $table->text('kadaran')->nullable()->change();
            $table->text('kadaran_unit')->nullable()->change();
            $table->text('kapasiti')->nullable()->change();
            $table->text('kapasiti_unit')->nullable()->change();
        });
    }
};