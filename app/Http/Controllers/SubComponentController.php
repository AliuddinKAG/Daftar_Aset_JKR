<?php

namespace App\Http\Controllers;

use App\Models\SubComponent;
use App\Models\MainComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            $validated = $request->validate($this->validationRules());

            DB::beginTransaction();

            // SIMPLE STRING - NO JSON ENCODING untuk saiz, kadaran, kapasiti
            $validated['saiz'] = $request->input('saiz') ?: null;
            $validated['saiz_unit'] = $request->input('saiz_unit') ?: null;
            $validated['kadaran'] = $request->input('kadaran') ?: null;
            $validated['kadaran_unit'] = $request->input('kadaran_unit') ?: null;
            $validated['kapasiti'] = $request->input('kapasiti') ?: null;
            $validated['kapasiti_unit'] = $request->input('kapasiti_unit') ?: null;

            // Handle dokumen berkaitan - HANYA ini yang JSON array
            $validated['dokumen_berkaitan'] = $this->processDokumenBerkaitan($request);

            $validated['status'] = $request->input('status', 'aktif');
            
            SubComponent::create($validated);

            DB::commit();

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya ditambah');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating sub component: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menyimpan Sub Komponen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified sub component
     */
    public function show(SubComponent $subComponent)
    {
        // Load hanya relationships yang wujud
        $subComponent->load(['mainComponent.component']);
        
        return view('components.view-sub-component', compact('subComponent'));
    }

    /**
     * Show the form for editing the sub component
     */
    public function edit(SubComponent $subComponent)
    {
        $mainComponents = MainComponent::with('component')->get();
        
        return view('components.edit-sub-component', compact('subComponent', 'mainComponents'));
    }

    /**
     * Update the specified sub component
     */
    public function update(Request $request, SubComponent $subComponent)
    {
        try {
            $validated = $request->validate($this->validationRules());

            DB::beginTransaction();

            // SIMPLE STRING - NO JSON ENCODING untuk saiz, kadaran, kapasiti
            $validated['saiz'] = $request->input('saiz') ?: null;
            $validated['saiz_unit'] = $request->input('saiz_unit') ?: null;
            $validated['kadaran'] = $request->input('kadaran') ?: null;
            $validated['kadaran_unit'] = $request->input('kadaran_unit') ?: null;
            $validated['kapasiti'] = $request->input('kapasiti') ?: null;
            $validated['kapasiti_unit'] = $request->input('kapasiti_unit') ?: null;

            // Handle dokumen berkaitan - HANYA ini yang JSON array
            $validated['dokumen_berkaitan'] = $this->processDokumenBerkaitan($request);

            $subComponent->update($validated);

            DB::commit();

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya dikemaskini');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating sub component: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal mengemaskini Sub Komponen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Soft delete the specified sub component
     */
    public function destroy(SubComponent $subComponent)
    {
        $subComponent->delete();
        
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
        $subComponent->forceDelete();
        
        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipadam secara kekal');
    }

    /**
     * Helper: Process dokumen berkaitan as array (will be auto JSON by cast)
     */
    private function processDokumenBerkaitan(Request $request)
    {
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        $documents = [];

        if (is_array($namas)) {
            foreach ($namas as $index => $nama) {
                if (!empty(trim($nama ?? ''))) {
                    $documents[] = [
                        'bil' => $bils[$index] ?? ($index + 1),
                        'nama' => $nama,
                        'rujukan' => $rujukans[$index] ?? null,
                        'catatan' => $catatans[$index] ?? null,
                    ];
                }
            }
        }

        // Return array - akan auto convert ke JSON oleh cast dalam model
        return !empty($documents) ? $documents : null;
    }

    /**
     * Validation rules
     */
    private function validationRules(): array
    {
        return [
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
            
            // Atribut Spesifikasi - SIMPLE STRING
            'jenis' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'saiz' => 'nullable|string|max:255',
            'saiz_unit' => 'nullable|string|max:255',
            'kadaran' => 'nullable|string|max:255',
            'kadaran_unit' => 'nullable|string|max:255',
            'kapasiti' => 'nullable|string|max:255',
            'kapasiti_unit' => 'nullable|string|max:255',
            'catatan_atribut' => 'nullable|string',
            
            // Maklumat Pembelian
            'tarikh_pembelian' => 'nullable|date',
            'kos_perolehan' => 'nullable|numeric',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'kod_ptj' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'jangka_hayat' => 'nullable|integer',
            
            // Pengilang, Pembekal, Kontraktor
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_pembelian' => 'nullable|string',
            
            // Dokumen - array inputs
            'doc_bil' => 'nullable|array',
            'doc_nama' => 'nullable|array',
            'doc_rujukan' => 'nullable|array',
            'doc_catatan' => 'nullable|array',
            'catatan_dokumen' => 'nullable|string',
            
            // Status & Nota
            'nota' => 'nullable|string',
            'status' => 'required|string|in:aktif,tidak_aktif',
        ];
    }
}