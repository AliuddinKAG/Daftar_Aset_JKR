<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('components', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('components', 'nama_aras')) {
                $table->string('nama_aras')->nullable()->after('kod_aras');
            }
            
            if (!Schema::hasColumn('components', 'nama_aras_binaan')) {
                $table->string('nama_aras_binaan')->nullable()->after('kod_aras_binaan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn(['nama_aras', 'nama_aras_binaan']);
        });
    }
};