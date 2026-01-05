<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\KodBlok;
use App\Models\KodAras;
use App\Models\KodRuang;
use App\Models\NamaRuang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComponentController extends Controller
{
    /**
     * Display a listing of components (Dashboard)
     */
    public function index()
    {
        $components = Component::with(['mainComponents.subComponents'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('components.index', compact('components'));
    }

    /**
     * Show the form for creating a new component
     */
    public function create()
    {
        // Load reference data untuk dropdown
        $kodBloks = KodBlok::active()->get();
        $kodAras = KodAras::active()->get();
        $kodRuangs = KodRuang::active()->get();
        $namaRuangs = NamaRuang::active()->get();
        
        // Untuk binaan luar - sama reference data
        $kodBinaanLuar = \App\Models\KodBinaanLuar::active()->get();
        
        return view('components.create-component', compact(
            'kodBloks', 'kodAras', 'kodRuangs', 'namaRuangs', 'kodBinaanLuar'
        ));
    }

    /**
     * Store a newly created component with auto-create master records
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_premis' => 'required|string|max:255',
            'nombor_dpa' => 'required|string|max:255',
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:100',
            'nama_blok' => 'nullable|string|max:255',
            'kod_aras' => 'nullable|string|max:50',
            'nama_aras' => 'nullable|string|max:255',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:100',
            'koordinat_x' => 'nullable|string|max:50',
            'koordinat_y' => 'nullable|string|max:50',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'nama_aras_binaan' => 'nullable|string|max:255',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        DB::beginTransaction();
        try {
            // Auto-create master records with nama support
            $this->autoCreateMasterRecords($request);

            // Convert checkboxes to boolean
            $validated['ada_blok'] = $request->has('ada_blok') ? 1 : 0;
            $validated['ada_binaan_luar'] = $request->has('ada_binaan_luar') ? 1 : 0;

            // Create component
            $component = Component::create($validated);

            DB::commit();

            return redirect()->route('components.show', $component)
                ->with('success', 'Komponen berjaya ditambah');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified component
     */
    public function show(Component $component)
    {
        $component->load(['mainComponents.subComponents']);
        return view('components.view-component', compact('component'));
    }

    /**
     * Show the form for editing the component
     */
    public function edit(Component $component)
    {
        // Load reference data untuk dropdown
        $kodBloks = KodBlok::active()->get();
        $kodAras = KodAras::active()->get();
        $kodRuangs = KodRuang::active()->get();
        $namaRuangs = NamaRuang::active()->get();
        
        // Untuk binaan luar
        $kodBinaanLuar = \App\Models\KodBinaanLuar::active()->get();
        
        return view('components.edit-component', compact(
            'component', 'kodBloks', 'kodAras', 'kodRuangs', 'namaRuangs', 'kodBinaanLuar'
        ));
    }

    /**
     * Update the specified component with auto-create master records
     * ✅ FIXED: Guna $component->update() instead of Component::create()
     */
    public function update(Request $request, Component $component)
    {
        $validated = $request->validate([
            'nama_premis' => 'required|string|max:255',
            'nombor_dpa' => 'required|string|max:255',
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:100',
            'nama_blok' => 'nullable|string|max:255',
            'kod_aras' => 'nullable|string|max:50',
            'nama_aras' => 'nullable|string|max:255',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:100',
            'koordinat_x' => 'nullable|string|max:50',
            'koordinat_y' => 'nullable|string|max:50',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'nama_aras_binaan' => 'nullable|string|max:255',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        DB::beginTransaction();
        try {
            // Auto-create master records
            $this->autoCreateMasterRecords($request);

            // Convert checkboxes to boolean
            $validated['ada_blok'] = $request->has('ada_blok') ? 1 : 0;
            $validated['ada_binaan_luar'] = $request->has('ada_binaan_luar') ? 1 : 0;

            // ✅ UPDATE component yang sedia ada (BUKAN create baru!)
            $component->update($validated);

            DB::commit();

            return redirect()->route('components.show', $component)
                ->with('success', 'Komponen berjaya dikemaskini');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete the specified component
     */
    public function destroy(Component $component)
    {
        $component->delete(); // Soft delete
        
        return redirect()->route('components.index')
            ->with('success', 'Komponen berjaya dipadam');
    }

    /**
     * Display a listing of trashed components
     */
    public function trashed()
    {
        $components = Component::onlyTrashed()
            ->with(['mainComponents.subComponents'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('components.trashed', compact('components'));
    }

    /**
     * Restore a trashed component
     */
    public function restore($id)
    {
        $component = Component::onlyTrashed()->findOrFail($id);
        $component->restore();
        
        return redirect()->route('components.trashed')
            ->with('success', 'Komponen berjaya dipulihkan');
    }

    /**
     * Permanently delete a trashed component
     */
    public function forceDestroy($id)
    {
        $component = Component::onlyTrashed()->findOrFail($id);
        $component->forceDelete(); // Permanent delete
        
        return redirect()->route('components.trashed')
            ->with('success', 'Komponen berjaya dipadam secara kekal');
    }

    /**
     * Check if Kod Blok exists and return suggestion
     * Called via AJAX from edit/create forms
     */
    public function checkKodBlok(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'suggestion' => ''
                ]);
            }

            $existing = KodBlok::where('kod', $kod)->first();

            if ($existing) {
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'kod' => $existing->kod,
                        'nama' => $existing->nama
                    ]
                ]);
            }

            // Generate suggestion for new kod
            $suggestion = $this->generateBlokNamaSuggestion($kod);

            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if Kod Aras exists and return suggestion
     * Called via AJAX from edit/create forms
     */
    public function checkKodAras(Request $request)
    {
        try {
            $kod = trim($request->input('kod'));
            
            if (empty($kod)) {
                return response()->json([
                    'exists' => false,
                    'suggestion' => ''
                ]);
            }

            $existing = KodAras::where('kod', $kod)->first();

            if ($existing) {
                return response()->json([
                    'exists' => true,
                    'data' => [
                        'kod' => $existing->kod,
                        'nama' => $existing->nama,
                        'tingkat' => $existing->tingkat
                    ]
                ]);
            }

            // Generate suggestion for new kod
            $suggestion = $this->generateArasNamaSuggestion($kod);

            return response()->json([
                'exists' => false,
                'suggestion' => $suggestion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save or Update Kod Blok
     * Called via AJAX when user types new kod blok
     */
    public function saveKodBlok(Request $request)
    {
        try {
            $request->validate([
                'kod' => 'required|string|max:50',
                'nama' => 'required|string|max:255'
            ]);

            $existingKod = KodBlok::where('kod', $request->kod)->first();

            if ($existingKod) {
                $existingKod->update([
                    'nama' => $request->nama,
                    'updated_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Kod blok berjaya dikemaskini',
                    'data' => $existingKod,
                    'action' => 'updated'
                ]);
            } else {
                $newKod = KodBlok::create([
                    'kod' => $request->kod,
                    'nama' => $request->nama,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Kod blok baru berjaya disimpan',
                    'data' => $newKod,
                    'action' => 'created'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save or Update Kod Aras
     * Called via AJAX when user types new kod aras
     */
    public function saveKodAras(Request $request)
    {
        try {
            $request->validate([
                'kod' => 'required|string|max:50',
                'nama' => 'required|string|max:255'
            ]);

            $existingKod = KodAras::where('kod', $request->kod)->first();

            if ($existingKod) {
                $existingKod->update([
                    'nama' => $request->nama,
                    'updated_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Kod aras berjaya dikemaskini',
                    'data' => $existingKod,
                    'action' => 'updated'
                ]);
            } else {
                // Extract tingkat from kod
                $tingkat = $this->extractTingkatFromKod($request->kod);
                
                $newKod = KodAras::create([
                    'kod' => $request->kod,
                    'nama' => $request->nama,
                    'tingkat' => $tingkat,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Kod aras baru berjaya disimpan',
                    'data' => $newKod,
                    'action' => 'created'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Auto-create master records with proper nama handling
     * This method checks if user typed new values and creates them in master tables
     */
    private function autoCreateMasterRecords(Request $request)
    {
        // ========================================
        // Kod Blok - with nama support
        // ========================================
        if ($request->filled('kod_blok')) {
            $kodBlok = trim($request->kod_blok);
            
            // Use provided nama_blok or fallback to kod
            $namaBlok = $request->filled('nama_blok') 
                ? trim($request->nama_blok) 
                : $kodBlok;
            
            KodBlok::firstOrCreate(
                ['kod' => $kodBlok],
                [
                    'nama' => $namaBlok,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Kod Aras (Blok Section) - with nama support
        // ========================================
        if ($request->filled('kod_aras')) {
            $kodAras = trim($request->kod_aras);
            
            // ✅ Use provided nama_aras or fallback to kod
            $namaAras = $request->filled('nama_aras') 
                ? trim($request->nama_aras) 
                : $kodAras;
            
            $tingkat = $this->extractTingkatFromKod($kodAras);
            
            KodAras::firstOrCreate(
                ['kod' => $kodAras],
                [
                    'nama' => $namaAras,
                    'tingkat' => $tingkat,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Kod Ruang - simple auto-create
        // ========================================
        if ($request->filled('kod_ruang')) {
            $kodRuang = trim($request->kod_ruang);
            
            KodRuang::firstOrCreate(
                ['kod' => $kodRuang],
                [
                    'nama' => $kodRuang,
                    'kategori' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Nama Ruang
        // ========================================
        if ($request->filled('nama_ruang')) {
            $namaRuang = trim($request->nama_ruang);
            
            NamaRuang::firstOrCreate(
                ['nama' => $namaRuang],
                [
                    'jenis' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Kod Binaan Luar
        // ========================================
        if ($request->filled('kod_binaan_luar')) {
            $kodBinaanLuar = trim($request->kod_binaan_luar);
            
            \App\Models\KodBinaanLuar::firstOrCreate(
                ['kod' => $kodBinaanLuar],
                [
                    'nama' => $kodBinaanLuar,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Binaan: Kod Aras - with nama support
        // ========================================
        if ($request->filled('kod_aras_binaan')) {
            $kodArasBinaan = trim($request->kod_aras_binaan);
            
            // ✅ Use provided nama_aras_binaan or fallback
            $namaArasBinaan = $request->filled('nama_aras_binaan') 
                ? trim($request->nama_aras_binaan) 
                : $kodArasBinaan;
            
            $tingkat = $this->extractTingkatFromKod($kodArasBinaan);
            
            KodAras::firstOrCreate(
                ['kod' => $kodArasBinaan],
                [
                    'nama' => $namaArasBinaan,
                    'tingkat' => $tingkat,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Binaan: Kod Ruang
        // ========================================
        if ($request->filled('kod_ruang_binaan')) {
            $kodRuangBinaan = trim($request->kod_ruang_binaan);
            
            KodRuang::firstOrCreate(
                ['kod' => $kodRuangBinaan],
                [
                    'nama' => $kodRuangBinaan,
                    'kategori' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // ========================================
        // Binaan: Nama Ruang
        // ========================================
        if ($request->filled('nama_ruang_binaan')) {
            $namaRuangBinaan = trim($request->nama_ruang_binaan);
            
            NamaRuang::firstOrCreate(
                ['nama' => $namaRuangBinaan],
                [
                    'jenis' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    /**
     * Generate nama suggestion for Blok
     */
    private function generateBlokNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Common patterns
        $patterns = [
            '/^[A-Z]$/' => 'Blok ' . $kod,
            '/^BLK[A-Z]$/' => 'Blok ' . substr($kod, 3),
            '/^\d+$/' => 'Blok ' . $kod,
        ];
        
        foreach ($patterns as $pattern => $format) {
            if (preg_match($pattern, $kod)) {
                return $format;
            }
        }
        
        return 'Blok ' . $kod;
    }

    /**
     * Generate nama suggestion for Aras
     */
    private function generateArasNamaSuggestion($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Basement
        if (preg_match('/^B(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? $matches[1] : '1';
            return 'Tingkat Bawah Tanah ' . $num;
        }
        
        // Ground floor
        if (in_array($kod, ['G', 'GF', 'GROUND', 'TB', '0'])) {
            return 'Tingkat Bawah';
        }
        
        // Numeric
        if (preg_match('/^(\d+)$/', $kod, $matches)) {
            return 'Tingkat ' . $matches[1];
        }
        
        // L1, F1, T1, TK1
        if (preg_match('/^[LFT]K?(\d+)$/i', $kod, $matches)) {
            return 'Tingkat ' . $matches[1];
        }
        
        // Roof
        if (in_array($kod, ['R', 'RF', 'ROOF', 'ROOFTOP'])) {
            return 'Tingkat Bumbung';
        }
        
        // Mezzanine
        if (preg_match('/^M[Z]?(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? ' ' . $matches[1] : '';
            return 'Tingkat Mezanin' . $num;
        }
        
        return 'Tingkat ' . $kod;
    }

    /**
     * Helper: Extract tingkat number from kod
     * Used for auto-creating Kod Aras records
     */
    private function extractTingkatFromKod($kod)
    {
        $kod = strtoupper(trim($kod));
        
        // Basement levels (negative)
        if (preg_match('/^B(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? (int)$matches[1] : 1;
            return -$num;
        }
        
        // Ground floor
        if (in_array($kod, ['G', 'GF', 'GROUND', 'TB', '0'])) {
            return 0;
        }
        
        // Numeric levels
        if (preg_match('/^(\d+)$/', $kod, $matches)) {
            return (int)$matches[1];
        }
        
        // L1, F1, T1, TK1 patterns
        if (preg_match('/^[LFT]K?(\d+)$/i', $kod, $matches)) {
            return (int)$matches[1];
        }
        
        // Roof (usually highest floor)
        if (in_array($kod, ['R', 'RF', 'ROOF', 'ROOFTOP'])) {
            return 99; // Arbitrary high number
        }
        
        // Mezzanine (between floors)
        if (preg_match('/^M[Z]?(\d*)$/i', $kod, $matches)) {
            $num = $matches[1] !== '' ? (int)$matches[1] : 1;
            return $num;
        }
        
        // Default
        return 0;
    }
}