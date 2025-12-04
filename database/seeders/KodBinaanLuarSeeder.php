<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KodBinaanLuarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder untuk table: kod_binaan_luar
     */
    public function run(): void
    {
        // Data binaan luar
        $binaanLuar = [
            ['kod' => 'BL-001', 'nama' => 'Kolam Renang'],
            ['kod' => 'BL-002', 'nama' => 'Padang Bola'],
            ['kod' => 'BL-003', 'nama' => 'Gelanggang Tenis'],
            ['kod' => 'BL-004', 'nama' => 'Tempat Letak Kereta'],
            ['kod' => 'BL-005', 'nama' => 'Taman Landskap'],
            ['kod' => 'BL-006', 'nama' => 'Kolam Takungan Air'],
            ['kod' => 'BL-007', 'nama' => 'Pusat Pembuangan Sampah'],
            ['kod' => 'BL-008', 'nama' => 'Stor Luar'],
            ['kod' => 'BL-009', 'nama' => 'Guardhouse'],
            ['kod' => 'BL-010', 'nama' => 'Shelter/Canopy'],
            ['kod' => 'BL-011', 'nama' => 'Padang Permainan Kanak-Kanak'],
            ['kod' => 'BL-012', 'nama' => 'Gazebo'],
            ['kod' => 'BL-013', 'nama' => 'Kolam Ikan'],
            ['kod' => 'BL-014', 'nama' => 'Jalan Kenderaan'],
            ['kod' => 'BL-015', 'nama' => 'Pagar Keliling'],
            ['kod' => 'BL-016', 'nama' => 'Tangki Air'],
            ['kod' => 'BL-017', 'nama' => 'Generator House'],
            ['kod' => 'BL-018', 'nama' => 'Substation'],
            ['kod' => 'BL-019', 'nama' => 'Pump House'],
            ['kod' => 'BL-020', 'nama' => 'Water Treatment Plant'],
        ];

        $now = Carbon::now();

        // Clear existing data (optional)
        // DB::table('kod_binaan_luars')->truncate();

        // Insert data
        foreach ($binaanLuar as $item) {
            DB::table('kod_binaan_luar')->insert([
                'kod' => $item['kod'],
                'nama' => $item['nama'],
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('✓ Kod Binaan Luar seeded successfully: ' . count($binaanLuar) . ' records');
    }
}