<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KodBlok;
use App\Models\KodAras;
use App\Models\KodRuang;
use App\Models\NamaRuang;
use App\Models\KodBinaanLuar;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Check if kod blok exists and return info or generate suggestion
     */
    public function checkKodBlok(Request $request)
    {
        $kod = trim($request->input('kod'));
        
        if (empty($kod)) {
            return response()->json([
                'exists' => false,
                'message' => 'Kod kosong'
            ]);
        }

        // Check if exists in database
        $existing = KodBlok::where('kod', $kod)->first();
        
        if ($existing) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'kod' => $existing->kod,
                    'nama' => $existing->nama,
                    'keterangan' => $existing->keterangan,
                    'status' => $existing->is_active ? 'aktif' : 'tidak_aktif'
                ],
                'message' => 'Kod sudah wujud dalam database'
            ]);
        }

        // Generate smart suggestion for new kod
        $suggestion = $this->generateBlokNamaSuggestion($kod);
        
        return response()->json([
            'exists' => false,
            'suggestion' => $suggestion,
            'message' => 'Kod baru - Nama disarankan'
        ]);
    }

    /**
     * Check if kod aras exists and return info or generate suggestion
     */
    public function checkKodAras(Request $request)
    {
        $kod = trim($request->input('kod'));
        
        if (empty($kod)) {
            return response()->json([
                'exists' => false,
                'message' => 'Kod kosong'
            ]);
        }

        // Check if exists in database
        $existing = KodAras::where('kod', $kod)->first();
        
        if ($existing) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'kod' => $existing->kod,
                    'nama' => $existing->nama,
                    'tingkat' => $existing->tingkat ?? null,
                    'status' => $existing->is_active ? 'aktif' : 'tidak_aktif'
                ],
                'message' => 'Kod sudah wujud dalam database'
            ]);
        }

        // Generate smart suggestion for new kod
        $suggestion = $this->generateArasNamaSuggestion($kod);
        
        return response()->json([
            'exists' => false,
            'suggestion' => $suggestion,
            'message' => 'Kod baru - Nama disarankan'
        ]);
    }

    /**
     * Generate smart name suggestion based on kod pattern
     */
    private function generateBlokNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Pattern 1: Single letter (A, B, C) -> "Blok A", "Blok B"
        if (preg_match('/^[A-Z]$/', $kod)) {
            return "Blok {$kod}";
        }
        
        // Pattern 2: Letter + Number (A1, B2) -> "Blok A1"
        if (preg_match('/^[A-Z]\d+$/', $kod)) {
            return "Blok {$kod}";
        }
        
        // Pattern 3: B + Number (B01, B02) -> "Blok 1", "Blok 2"
        if (preg_match('/^B0*(\d+)$/i', $kod, $matches)) {
            return "Blok " . (int)$matches[1];
        }
        
        // Pattern 4: BLK- prefix -> "Blok X"
        if (preg_match('/^BLK-?(.+)$/i', $kod, $matches)) {
            return "Blok " . strtoupper($matches[1]);
        }
        
        // Pattern 5: Direction words (UTARA, SELATAN, etc)
        $directions = [
            'UTARA' => 'Blok Utara',
            'SELATAN' => 'Blok Selatan',
            'TIMUR' => 'Blok Timur',
            'BARAT' => 'Blok Barat',
            'TENGAH' => 'Blok Tengah',
            'NORTH' => 'Blok Utara',
            'SOUTH' => 'Blok Selatan',
            'EAST' => 'Blok Timur',
            'WEST' => 'Blok Barat',
        ];
        
        if (isset($directions[$kod])) {
            return $directions[$kod];
        }
        
        // Pattern 6: Specific building types
        $types = [
            'ADMIN' => 'Blok Pentadbiran',
            'LIBRARY' => 'Blok Perpustakaan',
            'LAB' => 'Blok Makmal',
            'LECTURE' => 'Blok Kuliah',
            'HOSTEL' => 'Blok Asrama',
            'SPORT' => 'Blok Sukan',
        ];
        
        if (isset($types[$kod])) {
            return $types[$kod];
        }
        
        // Pattern 7: Contains "WING" -> "Sayap X"
        if (stripos($kod, 'WING') !== false) {
            $wing = str_replace(['WING', '-', '_'], '', $kod);
            return "Sayap " . ucfirst(strtolower($wing));
        }
        
        // Default: Just add "Blok" prefix
        return "Blok " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for Aras based on kod pattern
     */
    private function generateArasNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Pattern 1: Pure numbers (1, 2, 3, 10, 25) -> "Tingkat 1", "Tingkat 2"
        if (preg_match('/^(\d+)$/', $kod, $matches)) {
            $num = (int)$matches[1];
            return "Tingkat {$num}";
        }
        
        // Pattern 2: Basement variants
        $basementPatterns = [
            '/^B(\d*)$/i' => 'Bawah Tanah', // B, B1, B2
            '/^BT(\d*)$/i' => 'Bawah Tanah', // BT, BT1, BT2
            '/^BASEMENT(\d*)$/i' => 'Bawah Tanah', // BASEMENT, BASEMENT1
            '/^LB(\d*)$/i' => 'Bawah Tanah Bawah', // LB, LB1 (Lower Basement)
            '/^UB(\d*)$/i' => 'Bawah Tanah Atas', // UB, UB1 (Upper Basement)
            '/^LG(\d*)$/i' => 'Bawah Tanah Bawah', // LG, LG1 (Lower Ground)
            '/^UG(\d*)$/i' => 'Bawah Tanah Atas', // UG, UG1 (Upper Ground)
        ];
        
        foreach ($basementPatterns as $pattern => $name) {
            if (preg_match($pattern, $kod, $matches)) {
                $num = isset($matches[1]) && $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
                return $name . $num;
            }
        }
        
        // Pattern 3: Ground floor variants
        $groundPatterns = [
            '/^G$/i' => 'Tingkat Bawah',
            '/^GF$/i' => 'Tingkat Bawah',
            '/^GROUND$/i' => 'Tingkat Bawah',
            '/^TB$/i' => 'Tingkat Bawah',
        ];
        
        if (isset($groundPatterns[$kod])) {
            return $groundPatterns[$kod];
        }
        
        // Pattern 4: Mezzanine variants
        $mezzaninePatterns = [
            '/^M(\d*)$/i' => 'Mezanin',
            '/^MZ(\d*)$/i' => 'Mezanin',
            '/^MEZZ(\d*)$/i' => 'Mezanin',
            '/^MEZZANINE(\d*)$/i' => 'Mezanin',
        ];
        
        foreach ($mezzaninePatterns as $pattern => $name) {
            if (preg_match($pattern, $kod, $matches)) {
                $num = isset($matches[1]) && $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
                return $name . $num;
            }
        }
        
        // Pattern 5: Level/Floor prefix (L1, L2, F1, F2, LV1)
        $levelPatterns = [
            '/^L(\d+)$/i' => 'Tingkat',
            '/^F(\d+)$/i' => 'Tingkat',
            '/^FL(\d+)$/i' => 'Tingkat',
            '/^FLOOR(\d+)$/i' => 'Tingkat',
            '/^LV(\d+)$/i' => 'Tingkat',
            '/^LEVEL(\d+)$/i' => 'Tingkat',
        ];
        
        foreach ($levelPatterns as $pattern => $name) {
            if (preg_match($pattern, $kod, $matches)) {
                return $name . ' ' . (int)$matches[1];
            }
        }
        
        // Pattern 6: Rooftop/Penthouse variants
        $specialPatterns = [
            '/^R$/i' => 'Tingkat Bumbung',
            '/^RF$/i' => 'Tingkat Bumbung',
            '/^ROOF$/i' => 'Tingkat Bumbung',
            '/^ROOFTOP$/i' => 'Tingkat Bumbung',
            '/^PH(\d*)$/i' => 'Penthouse',
            '/^PENTHOUSE(\d*)$/i' => 'Penthouse',
            '/^ATTIC$/i' => 'Loteng',
        ];
        
        foreach ($specialPatterns as $pattern => $name) {
            if (preg_match($pattern, $kod, $matches)) {
                $num = isset($matches[1]) && $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
                return $name . $num;
            }
        }
        
        // Pattern 7: Tingkat prefix already in kod (T1, T2, TK1)
        if (preg_match('/^T[K]?(\d+)$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        // Pattern 8: Starts with number followed by text (1A, 2B, 3ST)
        if (preg_match('/^(\d+)[A-Z]+$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        // Default: Just add "Aras" prefix
        return "Aras " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Get existing master data for Select2
     */
    public function getMasterData($type)
    {
        try {
            switch ($type) {
                case 'blok':
                    $data = KodBlok::active()
                        ->select('kod', 'nama', 'keterangan')
                        ->orderBy('kod')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama,
                                'keterangan' => $item->keterangan
                            ];
                        });
                    break;

                case 'aras':
                    $data = KodAras::active()
                        ->select('kod', 'nama')
                        ->orderBy('tingkat')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama
                            ];
                        });
                    break;

                case 'ruang':
                    $data = KodRuang::active()
                        ->select('kod', 'nama', 'kategori')
                        ->orderBy('kod')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama,
                                'kategori' => $item->kategori
                            ];
                        });
                    break;

                case 'nama-ruang':
                    $data = NamaRuang::active()
                        ->select('nama', 'jenis')
                        ->orderBy('nama')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->nama,
                                'text' => $item->nama,
                                'jenis' => $item->jenis
                            ];
                        });
                    break;

                case 'binaan-luar':
                    $data = KodBinaanLuar::active()
                        ->select('kod', 'nama')
                        ->orderBy('kod')
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama
                            ];
                        });
                    break;

                default:
                    return response()->json(['error' => 'Invalid type'], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}