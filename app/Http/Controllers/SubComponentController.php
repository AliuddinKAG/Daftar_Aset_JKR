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

            // Convert arrays to JSON for storage
            $validated['saiz'] = $this->convertToJson($request->input('saiz'));
            $validated['saiz_unit'] = $this->convertToJson($request->input('saiz_unit'));
            $validated['kadaran'] = $this->convertToJson($request->input('kadaran'));
            $validated['kadaran_unit'] = $this->convertToJson($request->input('kadaran_unit'));
            $validated['kapasiti'] = $this->convertToJson($request->input('kapasiti'));
            $validated['kapasiti_unit'] = $this->convertToJson($request->input('kapasiti_unit'));
            
            // Store documents as JSON
            if ($request->has('doc_bil')) {
                $validated['dokumen_berkaitan'] = $this->processDokumen($request);
                unset($validated['doc_bil'], $validated['doc_nama'], $validated['doc_rujukan'], $validated['doc_catatan']);
            }
            
            SubComponent::create($validated);

            DB::commit();

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya ditambah');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving sub component: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the sub component
     */
    public function edit(SubComponent $subComponent)
    {
        $mainComponents = MainComponent::with('component')->get();
        
        // Data akan auto-decode oleh Model cast, tidak perlu decode manual
        
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

            // Convert arrays to JSON for storage
            $validated['saiz'] = $this->convertToJson($request->input('saiz'));
            $validated['saiz_unit'] = $this->convertToJson($request->input('saiz_unit'));
            $validated['kadaran'] = $this->convertToJson($request->input('kadaran'));
            $validated['kadaran_unit'] = $this->convertToJson($request->input('kadaran_unit'));
            $validated['kapasiti'] = $this->convertToJson($request->input('kapasiti'));
            $validated['kapasiti_unit'] = $this->convertToJson($request->input('kapasiti_unit'));
            
            // Store documents as JSON
            if ($request->has('doc_bil')) {
                $validated['dokumen_berkaitan'] = $this->processDokumen($request);
                unset($validated['doc_bil'], $validated['doc_nama'], $validated['doc_rujukan'], $validated['doc_catatan']);
            }

            $subComponent->update($validated);

            DB::commit();

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya dikemaskini');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating sub component: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengemaskini data: ' . $e->getMessage())
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
     * Helper: Convert input to JSON
     */
    private function convertToJson($input)
    {
        if (empty($input)) {
            return null;
        }
        
        return is_array($input) ? json_encode($input) : $input;
    }

    /**
     * Helper: Process dokumen berkaitan
     */
    private function processDokumen(Request $request)
    {
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        $documents = [];
        
        if (is_array($bils)) {
            foreach ($bils as $index => $bil) {
                if (!empty($bil) || !empty($namas[$index] ?? '')) {
                    $documents[] = [
                        'bil' => $bil,
                        'nama' => $namas[$index] ?? '',
                        'rujukan' => $rujukans[$index] ?? '',
                        'catatan' => $catatans[$index] ?? '',
                    ];
                }
            }
        }
        
        return !empty($documents) ? json_encode($documents) : null;
    }

    /**
     * Validation rules
     */
    private function validationRules(): array
    {
        return [
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
            'saiz' => 'nullable',
            'saiz_unit' => 'nullable',
            'kadaran' => 'nullable',
            'kadaran_unit' => 'nullable',
            'kapasiti' => 'nullable',
            'kapasiti_unit' => 'nullable',
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
        ];
    }
}