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
        Schema::table('sub_components', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('sub_components', 'jenis')) {
                $table->string('jenis')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'bahan')) {
                $table->string('bahan')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'catatan_atribut')) {
                $table->text('catatan_atribut')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'tarikh_pembelian')) {
                $table->date('tarikh_pembelian')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'kos_perolehan')) {
                $table->decimal('kos_perolehan', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'no_pesanan_rasmi_kontrak')) {
                $table->string('no_pesanan_rasmi_kontrak')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'kod_ptj')) {
                $table->string('kod_ptj')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'tarikh_dipasang')) {
                $table->date('tarikh_dipasang')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'tarikh_waranti_tamat')) {
                $table->date('tarikh_waranti_tamat')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'jangka_hayat')) {
                $table->string('jangka_hayat')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'nama_pengilang')) {
                $table->string('nama_pengilang')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'nama_pembekal')) {
                $table->string('nama_pembekal')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'alamat_pembekal')) {
                $table->text('alamat_pembekal')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'no_telefon_pembekal')) {
                $table->string('no_telefon_pembekal', 50)->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'nama_kontraktor')) {
                $table->string('nama_kontraktor')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'alamat_kontraktor')) {
                $table->text('alamat_kontraktor')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'no_telefon_kontraktor')) {
                $table->string('no_telefon_kontraktor', 50)->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'catatan_pembelian')) {
                $table->text('catatan_pembelian')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'dokumen_berkaitan')) {
                $table->json('dokumen_berkaitan')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'catatan_dokumen')) {
                $table->text('catatan_dokumen')->nullable();
            }
            if (!Schema::hasColumn('sub_components', 'nota')) {
                $table->text('nota')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_components', function (Blueprint $table) {
            $table->dropColumn([
                'jenis',
                'bahan',
                'catatan_atribut',
                'tarikh_pembelian',
                'kos_perolehan',
                'no_pesanan_rasmi_kontrak',
                'kod_ptj',
                'tarikh_dipasang',
                'tarikh_waranti_tamat',
                'jangka_hayat',
                'nama_pengilang',
                'nama_pembekal',
                'alamat_pembekal',
                'no_telefon_pembekal',
                'nama_kontraktor',
                'alamat_kontraktor',
                'no_telefon_kontraktor',
                'catatan_pembelian',
                'dokumen_berkaitan',
                'catatan_dokumen',
                'nota',
            ]);
        });
    }
};