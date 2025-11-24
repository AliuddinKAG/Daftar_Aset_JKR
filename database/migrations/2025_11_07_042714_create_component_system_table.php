<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Borang 1: Komponen (Peringkat Komponen)
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('nama_premis');
            $table->string('nombor_dpa');
            
            // Maklumat Lokasi - Blok
            $table->boolean('ada_blok')->default(false);
            $table->string('kod_blok')->nullable();
            $table->string('kod_aras')->nullable();
            $table->string('kod_ruang')->nullable();
            $table->string('nama_ruang')->nullable();
            $table->text('catatan_blok')->nullable();
            
            // Maklumat Lokasi - Binaan Luar
            $table->boolean('ada_binaan_luar')->default(false);
            $table->string('nama_binaan_luar')->nullable();
            $table->string('kod_binaan_luar')->nullable();
            $table->decimal('koordinat_x', 10, 6)->nullable();
            $table->decimal('koordinat_y', 10, 6)->nullable();
            $table->string('kod_aras_binaan')->nullable();
            $table->string('kod_ruang_binaan')->nullable();
            $table->string('nama_ruang_binaan')->nullable();
            $table->text('catatan_binaan')->nullable();
            
            // Removed: Pengumpul & Pengesah Data 
            // (Tandatangan hanya untuk print sahaja)
            
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });

        // Borang 2: Komponen Utama (Peringkat Komponen Utama)
        Schema::create('main_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            
            // Maklumat Utama
            $table->string('nama_komponen_utama');
            $table->string('kod_lokasi')->nullable();
            $table->string('sistem')->nullable();
            $table->string('subsistem')->nullable();
            $table->integer('kuantiti')->default(1);
            $table->text('komponen_sama_jenis')->nullable();
            
            // Upload gambar
            $table->string('gambar_komponen')->nullable();
            
            // Bidang Kejuruteraan
            $table->boolean('awam_arkitek')->default(false);
            $table->boolean('elektrikal')->default(false);
            $table->boolean('elv_ict')->default(false);
            $table->boolean('mekanikal')->default(false);
            $table->boolean('bio_perubatan')->default(false);
            $table->string('lain_lain')->nullable();
            
            $table->text('catatan')->nullable();
            
            // Maklumat Perolehan
            $table->date('tarikh_perolehan')->nullable();
            $table->string('kos_perolehan')->nullable();
            $table->string('no_pesanan_rasmi_kontrak')->nullable();
            
            // Tarikh-tarikh penting
            $table->date('tarikh_dipasang')->nullable();
            $table->date('tarikh_waranti_tamat')->nullable();
            $table->date('tarikh_tamat_dlp')->nullable();
            $table->string('jangka_hayat')->nullable();
            
            // Pengilang & Pembekal
            $table->string('nama_pengilang')->nullable();
            
            $table->string('nama_pembekal')->nullable();
            $table->text('alamat_pembekal')->nullable();
            $table->string('no_telefon_pembekal')->nullable();
            
            // Kontraktor
            $table->string('nama_kontraktor')->nullable();
            $table->text('alamat_kontraktor')->nullable();
            $table->string('no_telefon_kontraktor')->nullable();
            
            $table->text('catatan_maklumat')->nullable();
            
            // Maklumat Komponen
            $table->text('deskripsi')->nullable();
            $table->string('status_komponen')->nullable(); // operational, rosak, etc
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->string('no_siri')->nullable();
            $table->string('no_tag_label')->nullable();
            $table->string('no_sijil_pendaftaran')->nullable();
            
            // Maklumat Atribut Spesifikasi
            $table->string('jenis')->nullable();
            $table->string('bekalan_elektrik')->nullable(); // MSB/SSB/PP/DB
            $table->string('bahan')->nullable();
            $table->string('kaedah_pemasangan')->nullable();
            
            // Saiz Fizikal
            $table->string('saiz')->nullable();
            $table->string('saiz_unit')->nullable();
            
            // Kadaran
            $table->string('kadaran')->nullable();
            $table->string('kadaran_unit')->nullable();
            
            // Kapasiti
            $table->string('kapasiti')->nullable();
            $table->string('kapasiti_unit')->nullable();
            
            $table->text('catatan_atribut')->nullable();
            
            $table->text('catatan_komponen_berhubung')->nullable();
            $table->text('catatan_dokumen')->nullable();
            
            $table->text('nota')->nullable();
            
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });

        // Komponen Yang Berhubungkait
        Schema::create('related_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_component_id')->constrained()->onDelete('cascade');
            $table->integer('bil')->nullable();
            $table->string('nama_komponen')->nullable();
            $table->string('no_dpa_kod_ruang')->nullable();
            $table->string('no_tag_label')->nullable();
            $table->timestamps();
        });

        // Dokumen Berkaitan
        Schema::create('related_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_component_id')->constrained()->onDelete('cascade');
            $table->integer('bil')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->string('no_rujukan_berkaitan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        // Borang 3: Sub Komponen
        Schema::create('sub_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_component_id')->constrained()->onDelete('cascade');
            
            // Maklumat Sub Komponen
            $table->string('nama_sub_komponen');
            $table->text('deskripsi')->nullable();
            $table->string('status_komponen')->nullable();
            $table->string('no_siri')->nullable();
            $table->string('no_sijil_pendaftaran')->nullable();
            $table->string('jenama')->nullable();
            $table->string('model')->nullable();
            $table->integer('kuantiti')->default(1);
            $table->text('catatan')->nullable();
            
            // Maklumat Atribut Spesifikasi
            $table->string('jenis')->nullable();
            $table->string('bahan')->nullable();
            
            // Saiz Fizikal
            $table->string('saiz')->nullable();
            $table->string('saiz_unit')->nullable();
            
            // Kadaran
            $table->string('kadaran')->nullable();
            $table->string('kadaran_unit')->nullable();
            
            // Kapasiti
            $table->string('kapasiti')->nullable();
            $table->string('kapasiti_unit')->nullable();
            
            // Gambar
            $table->string('gambar_sub_komponen')->nullable();
            $table->text('catatan_atribut')->nullable();
            
            // Maklumat Pembelian
            $table->date('tarikh_pembelian')->nullable();
            $table->string('kos_perolehan')->nullable();
            $table->string('no_pesanan_rasmi_kontrak')->nullable();
            $table->string('kod_pm')->nullable();
            
            $table->date('tarikh_dipasang')->nullable();
            $table->date('tarikh_waranti_tamat')->nullable();
            $table->string('jangka_hayat')->nullable();
            
            // Pengilang, Pembekal, Kontraktor
            $table->string('nama_pengilang')->nullable();
            
            $table->string('nama_pembekal')->nullable();
            $table->text('alamat_pembekal')->nullable();
            $table->string('no_telefon_pembekal')->nullable();
            
            $table->string('nama_kontraktor')->nullable();
            $table->text('alamat_kontraktor')->nullable();
            $table->string('no_telefon_kontraktor')->nullable();
            
            $table->text('catatan_pembelian')->nullable();
            $table->text('catatan_dokumen')->nullable();
            $table->text('nota')->nullable();
            
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
        
        // Sub Component Documents
        Schema::create('sub_component_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_component_id')->constrained()->onDelete('cascade');
            $table->integer('bil')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->string('no_rujukan_berkaitan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_component_documents');
        Schema::dropIfExists('sub_components');
        Schema::dropIfExists('related_documents');
        Schema::dropIfExists('related_components');
        Schema::dropIfExists('main_components');
        Schema::dropIfExists('components');
    }
};