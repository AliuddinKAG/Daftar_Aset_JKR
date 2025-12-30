<?php

namespace App\Http\Controllers; // ✅ FIXED: Remove Api subfolder

use App\Http\Controllers\Controller;
use App\Models\KodBlok;
use App\Models\KodAras;
use App\Models\KodRuang;
use App\Models\NamaRuang;
use App\Models\KodBinaanLuar;
use App\Models\Sistem;
use App\Models\SubSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterDataController extends Controller
{
    /**
     * Check if kod blok exists and return info or generate suggestion
     */
    public function checkKodBlok(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            
            Log::info('===== CHECK KOD BLOK =====');
            Log::info('Received kod: ' . $kod);
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Kod kosong'
                ]);
            }

            // Use correct table name 'kod_bloks' (plural)
            $existing = DB::table('kod_bloks')
                ->where('kod', $kod)
                ->first();
            
            Log::info('Query result: ' . ($existing ? 'FOUND' : 'NOT FOUND'));
            
            if ($existing) {
                Log::info('Data found: ' . json_encode($existing));
                
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'kod' => $existing->kod,
                        'nama' => $existing->nama,
                        'keterangan' => $existing->keterangan ?? null,
                        'status' => $this->checkStatus($existing)
                    ],
                    'message' => 'Kod sudah wujud dalam database'
                ]);
            }

            $suggestion = $this->generateBlokNamaSuggestion($kod);
            
            Log::info('Suggestion generated: ' . $suggestion);
            
            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion,
                'message' => 'Kod baru - Nama disarankan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR in checkKodBlok: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Ralat server: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Check if kod aras exists and return info or generate suggestion
     */
    public function checkKodAras(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            
            Log::info('===== CHECK KOD ARAS =====');
            Log::info('Received kod: ' . $kod);
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Kod kosong'
                ]);
            }

            // Try both singular and plural table names
            $tableName = 'kod_aras'; // Most likely singular based on common Laravel convention for "aras"
            
            $existing = DB::table($tableName)
                ->where('kod', $kod)
                ->first();
            
            Log::info('Query result: ' . ($existing ? 'FOUND' : 'NOT FOUND'));
            
            if ($existing) {
                Log::info('Data found: ' . json_encode($existing));
                
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'kod' => $existing->kod,
                        'nama' => $existing->nama,
                        'tingkat' => $existing->tingkat ?? null,
                        'status' => $this->checkStatus($existing)
                    ],
                    'message' => 'Kod sudah wujud dalam database'
                ]);
            }

            $suggestion = $this->generateArasNamaSuggestion($kod);
            
            Log::info('Suggestion generated: ' . $suggestion);
            
            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion,
                'message' => 'Kod baru - Nama disarankan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR in checkKodAras: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Ralat server: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Check if kod sistem exists and return info or generate suggestion
     */
    public function checkKodSistem(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            
            Log::info('===== CHECK KOD SISTEM =====');
            Log::info('Received kod: ' . $kod);
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Kod kosong'
                ]);
            }

            // Try multiple possible table names
            $existing = null;
            $possibleTables = ['sistem', 'sistems', 'kod_sistem', 'kod_sistems'];
            
            foreach ($possibleTables as $table) {
                try {
                    $result = DB::table($table)->where('kod', $kod)->first();
                    if ($result) {
                        $existing = $result;
                        Log::info("Found in table: {$table}");
                        break;
                    }
                } catch (\Exception $e) {
                    Log::warning("Table '{$table}' not found or error: " . $e->getMessage());
                    continue;
                }
            }
            
            if ($existing) {
                Log::info('Data found: ' . json_encode($existing));
                
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'id' => $existing->id ?? null,
                        'kod' => $existing->kod,
                        'nama' => $existing->nama,
                        'status' => $this->checkStatus($existing)
                    ],
                    'message' => 'Kod sudah wujud dalam database'
                ]);
            }

            $suggestion = $this->generateSistemNamaSuggestion($kod);
            
            Log::info('Suggestion generated: ' . $suggestion);
            
            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion,
                'message' => 'Kod baru - Nama disarankan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR in checkKodSistem: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Ralat server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if kod subsistem exists and return info or generate suggestion
     */
    public function checkKodSubSistem(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            $sistemId = $request->input('sistem_id');
            
            Log::info('===== CHECK KOD SUBSISTEM =====');
            Log::info('Received kod: ' . $kod);
            Log::info('Sistem ID: ' . ($sistemId ?? 'none'));
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Kod kosong'
                ]);
            }

            // Try multiple possible table names for subsistem
            $existing = null;
            $possibleTables = ['sub_sistem', 'subsistem', 'sub_sistems', 'subsistems', 'kod_subsistem', 'kod_subsistems'];
            $usedTable = null;
            
            foreach ($possibleTables as $table) {
                try {
                    $query = DB::table($table)->where('kod', $kod);
                    
                    if ($sistemId) {
                        $query->where('sistem_id', $sistemId);
                    }
                    
                    $result = $query->first();
                    
                    if ($result) {
                        $existing = $result;
                        $usedTable = $table;
                        Log::info("Found in table: {$table}");
                        break;
                    }
                } catch (\Exception $e) {
                    Log::warning("Table '{$table}' not found or error: " . $e->getMessage());
                    continue;
                }
            }
            
            if ($existing) {
                Log::info('Data found: ' . json_encode($existing));
                
                // Get sistem nama if exists
                $sistem = null;
                $sistemTables = ['sistem', 'sistems', 'kod_sistem', 'kod_sistems'];
                
                if (isset($existing->sistem_id)) {
                    foreach ($sistemTables as $sTable) {
                        try {
                            $sistem = DB::table($sTable)->where('id', $existing->sistem_id)->first();
                            if ($sistem) break;
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
                
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'id' => $existing->id ?? null,
                        'kod' => $existing->kod,
                        'nama' => $existing->nama,
                        'sistem_id' => $existing->sistem_id ?? null,
                        'sistem_nama' => $sistem->nama ?? null,
                        'status' => $this->checkStatus($existing)
                    ],
                    'message' => 'Kod sudah wujud dalam database'
                ]);
            }

            $suggestion = $this->generateSubSistemNamaSuggestion($kod);
            
            Log::info('Suggestion generated: ' . $suggestion);
            
            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion,
                'message' => 'Kod baru - Nama disarankan',
                'sistem_id' => $sistemId
            ]);
            
        } catch (\Exception $e) {
            Log::error('ERROR in checkKodSubSistem: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => true,
                'message' => 'Ralat server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Check status from either 'status' or 'is_active' column
     */
    private function checkStatus($record)
    {
        if (property_exists($record, 'status')) {
            return $record->status;
        }
        
        if (property_exists($record, 'is_active')) {
            return $record->is_active ? 'aktif' : 'tidak_aktif';
        }
        
        return 'aktif';
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
            'UTARA' => 'Blok Utara', 'SELATAN' => 'Blok Selatan',
            'TIMUR' => 'Blok Timur', 'BARAT' => 'Blok Barat',
            'TENGAH' => 'Blok Tengah',
            'NORTH' => 'Blok Utara', 'SOUTH' => 'Blok Selatan',
            'EAST' => 'Blok Timur', 'WEST' => 'Blok Barat',
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
     * Generate smart name suggestion for Aras
     */
    private function generateArasNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        if (preg_match('/^(\d+)$/', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        if (preg_match('/^B(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
            return 'Bawah Tanah' . $num;
        }
        
        if (in_array($kod, ['G', 'GF', 'GROUND', 'TB'])) {
            return 'Tingkat Bawah';
        }
        
        if (preg_match('/^[LF](\d+)$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        if (preg_match('/^T[K]?(\d+)$/i', $kod, $matches)) {
            return "Tingkat " . (int)$matches[1];
        }
        
        if (in_array($kod, ['R', 'RF', 'ROOF', 'ROOFTOP'])) {
            return 'Tingkat Bumbung';
        }
        
        if (preg_match('/^M[Z]?(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? ' ' . (int)$matches[1] : '';
            return 'Mezanin' . $num;
        }
        
        return "Aras " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for Sistem
     */
    private function generateSistemNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        $patterns = [
            'HVAC' => 'Sistem Penghawa Dingin dan Pengudaraan',
            'AC' => 'Sistem Penghawa Dingin',
            'VENT' => 'Sistem Pengudaraan',
            'ELEC' => 'Sistem Elektrikal',
            'POWER' => 'Sistem Bekalan Kuasa',
            'LIGHT' => 'Sistem Pencahayaan',
            'PLUMB' => 'Sistem Paip',
            'WATER' => 'Sistem Bekalan Air',
            'DRAIN' => 'Sistem Perparitan',
            'FIRE' => 'Sistem Kebakaran',
            'SPRINK' => 'Sistem Pemercik',
            'LIFT' => 'Sistem Lif',
            'SEC' => 'Sistem Keselamatan',
            'CCTV' => 'Sistem CCTV',
        ];
        
        if (isset($patterns[$kod])) {
            return $patterns[$kod];
        }
        
        if (preg_match('/^([A-Z]+)(\d+)$/i', $kod, $matches)) {
            $base = strtoupper($matches[1]);
            $num = $matches[2];
            if (isset($patterns[$base])) {
                return $patterns[$base] . " " . $num;
            }
        }
        
        return "Sistem " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Generate smart name suggestion for SubSistem
     */
    private function generateSubSistemNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        $patterns = [
            'AHU' => 'Unit Pengendalian Udara',
            'FCU' => 'Unit Kipas Gegelung',
            'CHILLER' => 'Chiller',
            'PUMP' => 'Pam',
            'MSB' => 'Papan Suis Utama',
            'DB' => 'Papan Pengedaran',
            'GEN' => 'Penjana',
            'UPS' => 'Bekalan Kuasa Tanpa Gangguan',
            'TANK' => 'Tangki Air',
            'HYDRANT' => 'Hidran',
        ];
        
        if (isset($patterns[$kod])) {
            return $patterns[$kod];
        }
        
        if (preg_match('/^([A-Z]+)[_-]?(\d+)$/i', $kod, $matches)) {
            $base = strtoupper($matches[1]);
            $num = $matches[2];
            if (isset($patterns[$base])) {
                return $patterns[$base] . " " . $num;
            }
        }
        
        return "SubSistem " . ucwords(strtolower(str_replace(['-', '_'], ' ', $kod)));
    }

    /**
     * Get existing master data for Select2
     */
    public function getMasterData($type)
    {
        try {
            $data = [];
            
            switch ($type) {
                case 'blok':
                    $data = DB::table('kod_bloks')
                        ->where(function($q) {
                            $q->where('status', 'aktif')
                              ->orWhere('is_active', 1);
                        })
                        ->orderBy('kod')
                        ->get(['kod', 'nama', 'keterangan'])
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama
                            ];
                        });
                    break;

                case 'aras':
                    $data = DB::table('kod_aras')
                        ->where(function($q) {
                            $q->where('status', 'aktif')
                              ->orWhere('is_active', 1);
                        })
                        ->orderBy('tingkat')
                        ->get(['kod', 'nama'])
                        ->map(function ($item) {
                            return [
                                'id' => $item->kod,
                                'text' => "{$item->kod} - {$item->nama}",
                                'nama' => $item->nama
                            ];
                        });
                    break;

                case 'ruang':
                    $data = DB::table('kod_ruangs')
                        ->where(function($q) {
                            $q->where('status', 'aktif')
                              ->orWhere('is_active', 1);
                        })
                        ->orderBy('kod')
                        ->get(['kod', 'nama'])
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
            Log::error("Error in getMasterData({$type}): " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}