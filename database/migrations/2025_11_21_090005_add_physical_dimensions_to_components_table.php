<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('components', function (Blueprint $table) {
            // Dimensi fizikal (dalam mm atau cm)
            $table->decimal('panjang', 10, 2)->nullable()->after('catatan_binaan');
            $table->decimal('lebar', 10, 2)->nullable()->after('panjang');
            $table->decimal('tinggi', 10, 2)->nullable()->after('lebar');
            $table->string('unit_ukuran', 10)->default('mm')->after('tinggi'); // mm, cm, m
            
            // Keep koordinat GPS sebagai DECIMAL
            $table->decimal('koordinat_x', 10, 6)->nullable()->change();
            $table->decimal('koordinat_y', 10, 6)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn(['panjang', 'lebar', 'tinggi', 'unit_ukuran']);
        });
    }
};