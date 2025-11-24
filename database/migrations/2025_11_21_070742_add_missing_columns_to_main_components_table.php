<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            // Tambah kolum yang tiada - semak dulu sebelum tambah
            if (!Schema::hasColumn('main_components', 'no_pesanan_rasmi')) {
                $table->string('no_pesanan_rasmi')->nullable()->after('kos_perolehan');
            }
            if (!Schema::hasColumn('main_components', 'kod_lokasi')) {
                $table->string('kod_lokasi')->nullable()->after('component_id');
            }
            if (!Schema::hasColumn('main_components', 'tarikh_tamat_dlp')) {
                $table->date('tarikh_tamat_dlp')->nullable()->after('tarikh_waranti_tamat');
            }
            if (!Schema::hasColumn('main_components', 'catatan_maklumat')) {
                $table->text('catatan_maklumat')->nullable()->after('no_telefon_kontraktor');
            }
            if (!Schema::hasColumn('main_components', 'status_komponen')) {
                $table->string('status_komponen')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('main_components', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('main_components', function (Blueprint $table) {
            $table->dropColumn([
                'no_pesanan_rasmi',
                'kod_lokasi', 
                'tarikh_tamat_dlp',
                'catatan_maklumat',
                'status_komponen'
            ]);
            $table->dropSoftDeletes();
        });
    }
};