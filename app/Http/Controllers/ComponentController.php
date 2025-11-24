<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

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
        $kodBloks = \App\Models\KodBlok::active()->get();
        $kodAras = \App\Models\KodAras::active()->get();
        $kodRuangs = \App\Models\KodRuang::active()->get();
        $namaRuangs = \App\Models\NamaRuang::active()->get();
        
        return view('components.create-component', compact(
            'kodBloks', 'kodAras', 'kodRuangs', 'namaRuangs'
        ));
    }

    /**
     * Store a newly created component
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_premis' => 'required|string|max:255',
            'nombor_dpa' => 'required|string|max:255',
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:100',
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

        Component::create($validated);

        return redirect()->route('components.index')
            ->with('success', 'Komponen berjaya ditambah');
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
        $kodBloks = \App\Models\KodBlok::active()->get();
        $kodAras = \App\Models\KodAras::active()->get();
        $kodRuangs = \App\Models\KodRuang::active()->get();
        $namaRuangs = \App\Models\NamaRuang::active()->get();
        
        return view('components.edit-component', compact(
            'component', 'kodBloks', 'kodAras', 'kodRuangs', 'namaRuangs'
        ));
    }

    /**
     * Update the specified component
     */
    public function update(Request $request, Component $component)
    {
        $validated = $request->validate([
            'nama_premis' => 'required|string|max:255',
            'nombor_dpa' => 'required|string|max:255',
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:100',
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

        $component->update($validated);

        return redirect()->route('components.index')
            ->with('success', 'Komponen berjaya dikemaskini');
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
}