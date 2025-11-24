<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sistems', function (Blueprint $table) {
            $table->string('status')->default('aktif')->after('nama');
        });

        Schema::table('subsistems', function (Blueprint $table) {
            $table->string('status')->default('aktif')->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('sistems', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('subsistems', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};