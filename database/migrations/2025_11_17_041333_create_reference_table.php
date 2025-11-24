<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Table untuk Kod Blok
        Schema::create('kod_bloks', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table untuk Kod Aras
        Schema::create('kod_aras', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();
            $table->string('nama');
            $table->integer('tingkat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table untuk Kod Ruang
        Schema::create('kod_ruangs', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();
            $table->string('nama');
            $table->string('kategori')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table untuk Nama Ruang
        Schema::create('nama_ruangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('jenis')->nullable(); // Office, Lab, Store, etc
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table untuk Sistem
        Schema::create('sistems', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Table untuk SubSistem
        Schema::create('subsistems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistem_id')->nullable()->constrained('sistems')->onDelete('set null');
            $table->string('kod')->unique();
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert sample data
        $this->insertSampleData();
    }

    private function insertSampleData()
    {
        // Kod Blok
        DB::table('kod_bloks')->insert([
            ['kod' => 'A', 'nama' => 'BLOK A - UTAMA', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'B', 'nama' => 'BLOK B - PEJABAT', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'C', 'nama' => 'BLOK C - KAFETERIA', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'D', 'nama' => 'BLOK D - STOR', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kod Aras
        DB::table('kod_aras')->insert([
            ['kod' => 'B', 'nama' => 'BAWAH TANAH', 'tingkat' => -1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'LG', 'nama' => 'LOWER GROUND', 'tingkat' => 0, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'G', 'nama' => 'GROUND FLOOR', 'tingkat' => 0, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '01', 'nama' => 'TINGKAT 1', 'tingkat' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '02', 'nama' => 'TINGKAT 2', 'tingkat' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '03', 'nama' => 'TINGKAT 3', 'tingkat' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '04', 'nama' => 'TINGKAT 4', 'tingkat' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'R', 'nama' => 'ROOF/BUMBUNG', 'tingkat' => 99, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kod Ruang
        DB::table('kod_ruangs')->insert([
            ['kod' => '001', 'nama' => 'RUANG 001', 'kategori' => 'Pejabat', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '002', 'nama' => 'RUANG 002', 'kategori' => 'Pejabat', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '044', 'nama' => 'RUANG 044', 'kategori' => 'Kafeteria', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => '101', 'nama' => 'RUANG 101', 'kategori' => 'Stor', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Nama Ruang
        DB::table('nama_ruangs')->insert([
            ['nama' => 'PEJABAT UTAMA', 'jenis' => 'Office', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'BILIK MESYUARAT', 'jenis' => 'Meeting', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KAFETERIA - COOKING AREA', 'jenis' => 'Cafeteria', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KAFETERIA - DINING AREA', 'jenis' => 'Cafeteria', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'BILIK SERVER', 'jenis' => 'IT', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'STOR PERALATAN', 'jenis' => 'Storage', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'TANDAS LELAKI', 'jenis' => 'Facilities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'TANDAS WANITA', 'jenis' => 'Facilities', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sistem
        DB::table('sistems')->insert([
            ['kod' => 'HVAC', 'nama' => 'HVAC (Heating, Ventilation & Air Conditioning)', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'ELEC', 'nama' => 'Electrical System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'PLUMB', 'nama' => 'Plumbing System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'FIRE', 'nama' => 'Fire Protection System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'ICT', 'nama' => 'ICT System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kod' => 'LIFT', 'nama' => 'Lift & Escalator', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // SubSistem
        $hvacId = DB::table('sistems')->where('kod', 'HVAC')->value('id');
        $elecId = DB::table('sistems')->where('kod', 'ELEC')->value('id');
        $fireId = DB::table('sistems')->where('kod', 'FIRE')->value('id');

        DB::table('subsistems')->insert([
            // HVAC Subsystems
            ['sistem_id' => $hvacId, 'kod' => 'HVAC-AC', 'nama' => 'Air Conditioning', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $hvacId, 'kod' => 'HVAC-VENT', 'nama' => 'Ventilation System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $hvacId, 'kod' => 'HVAC-CHILLER', 'nama' => 'Chiller System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $hvacId, 'kod' => 'HVAC-AHU', 'nama' => 'Air Handling Unit', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Electrical Subsystems
            ['sistem_id' => $elecId, 'kod' => 'ELEC-LIGHT', 'nama' => 'Lighting System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $elecId, 'kod' => 'ELEC-POWER', 'nama' => 'Power Distribution', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $elecId, 'kod' => 'ELEC-GEN', 'nama' => 'Generator System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            
            // Fire Protection Subsystems
            ['sistem_id' => $fireId, 'kod' => 'FIRE-ALARM', 'nama' => 'Fire Alarm System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $fireId, 'kod' => 'FIRE-SPRINKLER', 'nama' => 'Sprinkler System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['sistem_id' => $fireId, 'kod' => 'FIRE-HYDRANT', 'nama' => 'Fire Hydrant System', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('subsistems');
        Schema::dropIfExists('sistems');
        Schema::dropIfExists('nama_ruangs');
        Schema::dropIfExists('kod_ruangs');
        Schema::dropIfExists('kod_aras');
        Schema::dropIfExists('kod_bloks');
    }
};