<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KodBlok;
use App\Models\KodAras;
use App\Models\KodRuang;
use App\Models\NamaRuang;
use App\Models\KodBinaanLuar;
use App\Models\Sistem;
use App\Models\SubSistem;
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

        $suggestion = $this->generateArasNamaSuggestion($kod);
        
        return response()->json([
            'exists' => false,
            'suggestion' => $suggestion,
            'message' => 'Kod baru - Nama disarankan'
        ]);
    }

    /**
     * Check if kod sistem exists and return info or generate suggestion (NEW)
     */
    public function checkKodSistem(Request $request)
    {
        $kod = trim($request->input('kod'));
        
        if (empty($kod)) {
            return response()->json([
                'exists' => false,
                'message' => 'Kod kosong'
            ]);
        }

        $existing = Sistem::where('kod', $kod)->first();
        
        if ($existing) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'id' => $existing->id,
                    'kod' => $existing->kod,
                    'nama' => $existing->nama,
                    'status' => $existing->is_active ? 'aktif' : 'tidak_aktif'
                ],
                'message' => 'Kod sudah wujud dalam database'
            ]);
        }

        $suggestion = $this->generateSistemNamaSuggestion($kod);
        
        return response()->json([
            'exists' => false,
            'suggestion' => $suggestion,
            'message' => 'Kod baru - Nama disarankan'
        ]);
    }

    /**
     * Check if kod subsistem exists and return info or generate suggestion (NEW)
     */
    public function checkKodSubSistem(Request $request)
    {
        $kod = trim($request->input('kod'));
        $sistemId = $request->input('sistem_id');
        
        if (empty($kod)) {
            return response()->json([
                'exists' => false,
                'message' => 'Kod kosong'
            ]);
        }

        $query = SubSistem::where('kod', $kod);
        
        // If sistem_id provided, check within that sistem
        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }
        
        $existing = $query->first();
        
        if ($existing) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'id' => $existing->id,
                    'kod' => $existing->kod,
                    'nama' => $existing->nama,
                    'sistem_id' => $existing->sistem_id,
                    'sistem_nama' => $existing->sistem->nama ?? null,
                    'status' => $existing->is_active ? 'aktif' : 'tidak_aktif'
                ],
                'message' => 'Kod sudah wujud dalam database'
            ]);
        }

        $suggestion = $this->generateSubSistemNamaSuggestion($kod);
        
        return response()->json([
            'exists' => false,
            'suggestion' => $suggestion,
            'message' => 'Kod baru - Nama disarankan',
            'sistem_id' => $sistemId
        ]);
    }

    /**
     * Generate smart name suggestion based on kod pattern
     */
    private function generateBlokNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        if (preg_match('/^[A-Z]$/', $kod)) {
            return "Blok {$kod}";
        }
        
        if (preg_match('/^[A-Z]\d+$/', $kod)) {
            return "Blok {$kod}";
        }
        
        if (preg_match('/^B0*(\d+)$/i', $kod, $matches)) {
            return "Blok " . (int)$matches[1];
        }
        
        if (preg_match('/^BLK-?(.+)$/i', $kod, $matches)) {
            return "Blok " . strtoupper($matches[1]);
        }
        
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
        
        if (stripos($kod, 'WING') !== false) {
            $wing = str_replace(['WING', '-', '_'], '', $kod);
            return "Sayap " . ucfirst(strtolower($wing));
        }
        
        return "Blok " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for Aras based on kod pattern
     */
    private function generateArasNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        if (preg_match('/^(\d+)$/', $kod, $matches)) {
            $num = (int)$matches[1];
            return "Tingkat {$num}";
        }
        
        $basementPatterns = [
            '/^B(\d*)$/i' => 'Bawah Tanah',
            '/^BT(\d*)$/i' => 'Bawah Tanah',
            '/^BASEMENT(\d*)$/i' => 'Bawah Tanah',
            '/^LB(\d*)$/i' => 'Bawah Tanah Bawah',
            '/^UB(\d*)$/i' => 'Bawah Tanah Atas',
            '/^LG(\d*)$/i' => 'Bawah Tanah Bawah',
            '/^UG(\d*)$/i' => 'Bawah Tanah Atas',
        ];
        
        foreach ($basementPatterns as $pattern => $name) {
            if (preg_match($pattern, $kod, $matches)) {
                $num = isset($matches[1]) && $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
                return $name . $num;
            }
        }
        
        $groundPatterns = [
            '/^G$/i' => 'Tingkat Bawah',
            '/^GF$/i' => 'Tingkat Bawah',
            '/^GROUND$/i' => 'Tingkat Bawah',
            '/^TB$/i' => 'Tingkat Bawah',
        ];
        
        if (isset($groundPatterns[$kod])) {
            return $groundPatterns[$kod];
        }
        
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
        
        if (preg_match('/^T[K]?(\d+)$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        if (preg_match('/^(\d+)[A-Z]+$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        return "Aras " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for Sistem (NEW)
     */
    private function generateSistemNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Common system patterns
        $patterns = [
            // HVAC
            '/^HVAC$/i' => 'Sistem Penghawa Dingin dan Pengudaraan',
            '/^AC$/i' => 'Sistem Penghawa Dingin',
            '/^VENT$/i' => 'Sistem Pengudaraan',
            
            // Electrical
            '/^ELEC$/i' => 'Sistem Elektrikal',
            '/^POWER$/i' => 'Sistem Bekalan Kuasa',
            '/^LIGHT$/i' => 'Sistem Pencahayaan',
            
            // Plumbing
            '/^PLUMB$/i' => 'Sistem Paip',
            '/^WATER$/i' => 'Sistem Bekalan Air',
            '/^DRAIN$/i' => 'Sistem Perparitan',
            
            // Fire
            '/^FIRE$/i' => 'Sistem Kebakaran',
            '/^SPRINK$/i' => 'Sistem Pemercik',
            '/^ALARM$/i' => 'Sistem Penggera',
            
            // Security
            '/^SEC$/i' => 'Sistem Keselamatan',
            '/^CCTV$/i' => 'Sistem CCTV',
            '/^ACCESS$/i' => 'Sistem Kawalan Akses',
            
            // Lift
            '/^LIFT$/i' => 'Sistem Lif',
            '/^ELEV$/i' => 'Sistem Lif',
            
            // IT
            '/^IT$/i' => 'Sistem Teknologi Maklumat',
            '/^NET$/i' => 'Sistem Rangkaian',
            '/^TEL$/i' => 'Sistem Telefon',
        ];
        
        foreach ($patterns as $pattern => $name) {
            if (preg_match($pattern, $kod)) {
                return $name;
            }
        }
        
        // If kod contains number at end, might be version/type
        if (preg_match('/^([A-Z]+)(\d+)$/i', $kod, $matches)) {
            $base = $matches[1];
            $num = $matches[2];
            return "Sistem " . ucfirst(strtolower($base)) . " " . $num;
        }
        
        // Default: "Sistem [Kod]"
        return "Sistem " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for SubSistem (NEW)
     */
    private function generateSubSistemNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Common subsystem patterns
        $patterns = [
            // HVAC subsystems
            '/^AHU$/i' => 'Unit Pengendalian Udara',
            '/^FCU$/i' => 'Unit Kipas Gegelung',
            '/^CHILLER$/i' => 'Chiller',
            '/^COOL$/i' => 'Menara Penyejuk',
            '/^PUMP$/i' => 'Pam',
            
            // Electrical subsystems
            '/^MSB$/i' => 'Papan Suis Utama',
            '/^DB$/i' => 'Papan Pengedaran',
            '/^GEN$/i' => 'Penjana',
            '/^UPS$/i' => 'Bekalan Kuasa Tanpa Gangguan',
            '/^PANEL$/i' => 'Panel Elektrik',
            
            // Plumbing subsystems
            '/^TANK$/i' => 'Tangki Air',
            '/^VALVE$/i' => 'Injap',
            '/^PIPE$/i' => 'Paip',
            
            // Fire subsystems
            '/^HYDRANT$/i' => 'Hidran',
            '/^HOSE$/i' => 'Hos Reel',
            '/^DETECT$/i' => 'Pengesan',
            
            // Lift subsystems
            '/^PASS$/i' => 'Lif Penumpang',
            '/^CARGO$/i' => 'Lif Barang',
            '/^MOTOR$/i' => 'Motor',
        ];
        
        foreach ($patterns as $pattern => $name) {
            if (preg_match($pattern, $kod)) {
                return $name;
            }
        }
        
        // If kod has prefix and number (like AHU-1, FCU-2)
        if (preg_match('/^([A-Z]+)[_-]?(\d+)$/i', $kod, $matches)) {
            $base = $matches[1];
            $num = $matches[2];
            
            // Check if base matches any pattern
            foreach ($patterns as $pattern => $name) {
                if (preg_match($pattern, $base)) {
                    return $name . " " . $num;
                }
            }
            
            return "Sub " . ucfirst(strtolower($base)) . " " . $num;
        }
        
        // Default: "SubSistem [Kod]"
        return "SubSistem " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
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