<?php

namespace App\Http\Controllers;

use App\Models\SubComponent;
use App\Models\MainComponent;
use Illuminate\Http\Request;

class SubComponentController extends Controller
{
    /**
     * Show the form for creating a new sub component
     */
    public function create()
    {
        $mainComponents = MainComponent::with('component')->get();
        return view('components.create-sub-component', compact('mainComponents'));
    }

    /**
     * Store a newly created sub component
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Maklumat Utama
            'main_component_id' => 'required|exists:main_components,id',
            'nama_sub_komponen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'no_siri' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            
            // Atribut Spesifikasi
            'jenis' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'saiz' => 'nullable|array',
            'saiz_unit' => 'nullable|array',
            'kadaran' => 'nullable|array',
            'kadaran_unit' => 'nullable|array',
            'kapasiti' => 'nullable|array',
            'kapasiti_unit' => 'nullable|array',
            'catatan_atribut' => 'nullable|string',
            
            // Maklumat Pembelian
            'tarikh_pembelian' => 'nullable|date',
            'kos_perolehan' => 'nullable|numeric',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'kod_ptj' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'jangka_hayat' => 'nullable|string|max:255',
            
            // Pengilang, Pembekal, Kontraktor
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_pembelian' => 'nullable|string',
            
            // Dokumen Berkaitan
            'doc_bil' => 'nullable|array',
            'doc_nama' => 'nullable|array',
            'doc_rujukan' => 'nullable|array',
            'doc_catatan' => 'nullable|array',
            'catatan_dokumen' => 'nullable|string',
            
            // Status & Nota
            'nota' => 'nullable|string',
            'status' => 'required|string|in:aktif,tidak_aktif',
        ]);

        // Convert arrays to JSON for storage
        if (isset($validated['saiz']) && is_array($validated['saiz'])) {
            $validated['saiz'] = json_encode($validated['saiz']);
        }
        if (isset($validated['saiz_unit']) && is_array($validated['saiz_unit'])) {
            $validated['saiz_unit'] = json_encode($validated['saiz_unit']);
        }
        if (isset($validated['kadaran']) && is_array($validated['kadaran'])) {
            $validated['kadaran'] = json_encode($validated['kadaran']);
        }
        if (isset($validated['kadaran_unit']) && is_array($validated['kadaran_unit'])) {
            $validated['kadaran_unit'] = json_encode($validated['kadaran_unit']);
        }
        if (isset($validated['kapasiti']) && is_array($validated['kapasiti'])) {
            $validated['kapasiti'] = json_encode($validated['kapasiti']);
        }
        if (isset($validated['kapasiti_unit']) && is_array($validated['kapasiti_unit'])) {
            $validated['kapasiti_unit'] = json_encode($validated['kapasiti_unit']);
        }
        
        // Store documents as JSON
        if (isset($validated['doc_bil']) && is_array($validated['doc_bil'])) {
            $documents = [];
            foreach ($validated['doc_bil'] as $index => $bil) {
                if (!empty($bil) || !empty($validated['doc_nama'][$index] ?? '')) {
                    $documents[] = [
                        'bil' => $bil,
                        'nama' => $validated['doc_nama'][$index] ?? '',
                        'rujukan' => $validated['doc_rujukan'][$index] ?? '',
                        'catatan' => $validated['doc_catatan'][$index] ?? '',
                    ];
                }
            }
            $validated['dokumen_berkaitan'] = json_encode($documents);
            
            // Remove array fields
            unset($validated['doc_bil'], $validated['doc_nama'], $validated['doc_rujukan'], $validated['doc_catatan']);
        }
        
        SubComponent::create($validated);

        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya ditambah');
    }

    /**
     * Display the specified sub component
     */
    public function show(SubComponent $subComponent)
    {
        // Load relationships
        $subComponent->load(['mainComponent.component']);
        
        // Decode JSON fields for display
        if ($subComponent->saiz) {
            $subComponent->saiz_decoded = json_decode($subComponent->saiz, true);
        }
        if ($subComponent->saiz_unit) {
            $subComponent->saiz_unit_decoded = json_decode($subComponent->saiz_unit, true);
        }
        if ($subComponent->kadaran) {
            $subComponent->kadaran_decoded = json_decode($subComponent->kadaran, true);
        }
        if ($subComponent->kadaran_unit) {
            $subComponent->kadaran_unit_decoded = json_decode($subComponent->kadaran_unit, true);
        }
        if ($subComponent->kapasiti) {
            $subComponent->kapasiti_decoded = json_decode($subComponent->kapasiti, true);
        }
        if ($subComponent->kapasiti_unit) {
            $subComponent->kapasiti_unit_decoded = json_decode($subComponent->kapasiti_unit, true);
        }
        if ($subComponent->dokumen_berkaitan) {
            $subComponent->dokumen_decoded = json_decode($subComponent->dokumen_berkaitan, true);
        }
        
        return view('components.view-sub-component', compact('subComponent'));
    }

    /**
     * Show the form for editing the sub component
     */
    public function edit(SubComponent $subComponent)
    {
        $mainComponents = MainComponent::with('component')->get();
        
        // Decode JSON fields for editing
        if ($subComponent->saiz) {
            $subComponent->saiz_decoded = json_decode($subComponent->saiz, true);
        }
        if ($subComponent->saiz_unit) {
            $subComponent->saiz_unit_decoded = json_decode($subComponent->saiz_unit, true);
        }
        if ($subComponent->kadaran) {
            $subComponent->kadaran_decoded = json_decode($subComponent->kadaran, true);
        }
        if ($subComponent->kadaran_unit) {
            $subComponent->kadaran_unit_decoded = json_decode($subComponent->kadaran_unit, true);
        }
        if ($subComponent->kapasiti) {
            $subComponent->kapasiti_decoded = json_decode($subComponent->kapasiti, true);
        }
        if ($subComponent->kapasiti_unit) {
            $subComponent->kapasiti_unit_decoded = json_decode($subComponent->kapasiti_unit, true);
        }
        if ($subComponent->dokumen_berkaitan) {
            $subComponent->dokumen_decoded = json_decode($subComponent->dokumen_berkaitan, true);
        }
        if ($subComponent->specifications) {
            $subComponent->specifications_decoded = json_decode($subComponent->specifications, true);
        }
        
        return view('components.edit-sub-component', compact('subComponent', 'mainComponents'));
    }

    /**
     * Update the specified sub component
     */
    public function update(Request $request, SubComponent $subComponent)
    {
        $validated = $request->validate([
            // Maklumat Utama
            'main_component_id' => 'required|exists:main_components,id',
            'nama_sub_komponen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'no_siri' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            
            // Atribut Spesifikasi
            'jenis' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'saiz' => 'nullable|array',
            'saiz_unit' => 'nullable|array',
            'kadaran' => 'nullable|array',
            'kadaran_unit' => 'nullable|array',
            'kapasiti' => 'nullable|array',
            'kapasiti_unit' => 'nullable|array',
            'catatan_atribut' => 'nullable|string',
            
            // Maklumat Pembelian
            'tarikh_pembelian' => 'nullable|date',
            'kos_perolehan' => 'nullable|numeric',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'kod_ptj' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'jangka_hayat' => 'nullable|string|max:255',
            
            // Pengilang, Pembekal, Kontraktor
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_pembelian' => 'nullable|string',
            
            // Dokumen Berkaitan
            'doc_bil' => 'nullable|array',
            'doc_nama' => 'nullable|array',
            'doc_rujukan' => 'nullable|array',
            'doc_catatan' => 'nullable|array',
            'catatan_dokumen' => 'nullable|string',
            
            // Status & Nota
            'nota' => 'nullable|string',
            'status' => 'required|string|in:aktif,tidak_aktif',
        ]);

        // Convert arrays to JSON for storage
        if (isset($validated['saiz']) && is_array($validated['saiz'])) {
            $validated['saiz'] = json_encode($validated['saiz']);
        }
        if (isset($validated['saiz_unit']) && is_array($validated['saiz_unit'])) {
            $validated['saiz_unit'] = json_encode($validated['saiz_unit']);
        }
        if (isset($validated['kadaran']) && is_array($validated['kadaran'])) {
            $validated['kadaran'] = json_encode($validated['kadaran']);
        }
        if (isset($validated['kadaran_unit']) && is_array($validated['kadaran_unit'])) {
            $validated['kadaran_unit'] = json_encode($validated['kadaran_unit']);
        }
        if (isset($validated['kapasiti']) && is_array($validated['kapasiti'])) {
            $validated['kapasiti'] = json_encode($validated['kapasiti']);
        }
        if (isset($validated['kapasiti_unit']) && is_array($validated['kapasiti_unit'])) {
            $validated['kapasiti_unit'] = json_encode($validated['kapasiti_unit']);
        }
        
        // Store documents as JSON
        if (isset($validated['doc_bil']) && is_array($validated['doc_bil'])) {
            $documents = [];
            foreach ($validated['doc_bil'] as $index => $bil) {
                if (!empty($bil) || !empty($validated['doc_nama'][$index] ?? '')) {
                    $documents[] = [
                        'bil' => $bil,
                        'nama' => $validated['doc_nama'][$index] ?? '',
                        'rujukan' => $validated['doc_rujukan'][$index] ?? '',
                        'catatan' => $validated['doc_catatan'][$index] ?? '',
                    ];
                }
            }
            $validated['dokumen_berkaitan'] = json_encode($documents);
            
            // Remove array fields
            unset($validated['doc_bil'], $validated['doc_nama'], $validated['doc_rujukan'], $validated['doc_catatan']);
        }

        $subComponent->update($validated);

        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya dikemaskini');
    }

    /**
     * Soft delete the specified sub component
     */
    public function destroy(SubComponent $subComponent)
    {
        $subComponent->delete(); // Soft delete
        
        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya dipadam');
    }

    /**
     * Display a listing of trashed sub components
     */
    public function trashed()
    {
        $subComponents = SubComponent::onlyTrashed()
            ->with(['mainComponent.component'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('sub-components.trashed', compact('subComponents'));
    }

    /**
     * Restore a trashed sub component
     */
    public function restore($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->restore();
        
        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipulihkan');
    }

    /**
     * Permanently delete a trashed sub component
     */
    public function forceDestroy($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->forceDelete(); // Permanent delete
        
        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipadam secara kekal');
    }
}