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
            'nama_blok' => 'nullable|string|max:255', // Accept nama from form
            'kod_aras' => 'nullable|string|max:50',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:100',
            'koordinat_x' => 'nullable|string|max:50',
            'koordinat_y' => 'nullable|string|max:50',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        DB::beginTransaction();
        try {
            // Auto-create master records with nama support
            $this->autoCreateMasterRecords($request);

            // Remove nama_blok from validated data before creating component
            $componentData = collect($validated)->except('nama_blok')->toArray();

            // Create component
            Component::create($componentData);

            DB::commit();

            return redirect()->route('components.index')
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
     */
    public function update(Request $request, Component $component)
    {
        $validated = $request->validate([
            'nama_premis' => 'required|string|max:255',
            'nombor_dpa' => 'required|string|max:255',
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:100',
            'nama_blok' => 'nullable|string|max:255', // Accept nama from form
            'kod_aras' => 'nullable|string|max:50',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:100',
            'koordinat_x' => 'nullable|string|max:50',
            'koordinat_y' => 'nullable|string|max:50',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        DB::beginTransaction();
        try {
            // Auto-create master records
            $this->autoCreateMasterRecords($request);

            // Remove nama_blok before update
            $componentData = collect($validated)->except('nama_blok')->toArray();

            // Update component
            $component->update($componentData);

            DB::commit();

            return redirect()->route('components.index')
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
        // Kod Aras - simple auto-create
        // ========================================
        if ($request->filled('kod_aras')) {
            $kodAras = trim($request->kod_aras);
            
            KodAras::firstOrCreate(
                ['kod' => $kodAras],
                [
                    'nama' => $kodAras,
                    'tingkat' => 0, // Default tingkat
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
        // Binaan: Kod Aras
        // ========================================
        if ($request->filled('kod_aras_binaan')) {
            $kodArasBinaan = trim($request->kod_aras_binaan);
            
            KodAras::firstOrCreate(
                ['kod' => $kodArasBinaan],
                [
                    'nama' => $kodArasBinaan,
                    'tingkat' => 0,
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
}