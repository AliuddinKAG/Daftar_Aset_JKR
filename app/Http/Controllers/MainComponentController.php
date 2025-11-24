<?php

namespace App\Http\Controllers;

use App\Models\MainComponent;
use App\Models\Component;
use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;

class MainComponentController extends Controller
{
    /**
     * Generate Kod Lokasi automatically
     */
    public function generateKodLokasi(Request $request)
    {
        $componentId = $request->get('component_id');
        $component = Component::find($componentId);
        
        if (!$component) {
            return response()->json(['kod_lokasi' => ''], 400);
        }
        
        // Count existing main components for this component + 1
        $count = MainComponent::where('component_id', $componentId)->count() + 1;
        
        // Format: KU-[ComponentID]-[XXX]
        $kodLokasi = 'KU-' . $componentId . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        
        return response()->json(['kod_lokasi' => $kodLokasi]);
    }

    /**
     * Show the form for creating a new main component
     */
    public function create()
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();
        
        return view('components.create-main-component', compact(
            'components', 'sistems', 'subsistems'
        ));
    }

    /**
     * Store a newly created main component
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // Handle checkboxes - convert to boolean
        $validated['awam_arkitek'] = $request->has('awam_arkitek') ? 1 : 0;
        $validated['elektrikal'] = $request->has('elektrikal') ? 1 : 0;
        $validated['elv_ict'] = $request->has('elv_ict') ? 1 : 0;
        $validated['mekanikal'] = $request->has('mekanikal') ? 1 : 0;
        $validated['bio_perubatan'] = $request->has('bio_perubatan') ? 1 : 0;

        // Handle array fields - gabungkan dengan comma
        $validated['saiz'] = $this->processArrayField($request->input('saiz'));
        $validated['saiz_unit'] = $this->processArrayField($request->input('saiz_unit'));
        $validated['kadaran'] = $this->processArrayField($request->input('kadaran'));
        $validated['kadaran_unit'] = $this->processArrayField($request->input('kadaran_unit'));
        $validated['kapasiti'] = $this->processArrayField($request->input('kapasiti'));
        $validated['kapasiti_unit'] = $this->processArrayField($request->input('kapasiti_unit'));

        // Atribut tambahan dari partial
        $validated['jenis'] = $request->input('jenis');
        $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
        $validated['bahan'] = $request->input('bahan');
        $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
        $validated['catatan_atribut'] = $request->input('catatan_atribut');
        $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
        $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
        $validated['nota'] = $request->input('nota');

        // Save new Sistem if doesn't exist
        if (!empty($validated['sistem'])) {
            $this->saveSistem($validated['sistem']);
        }
        
        // Save new Subsistem if doesn't exist
        if (!empty($validated['subsistem'])) {
            $this->saveSubsistem($validated['subsistem'], $validated['sistem'] ?? null);
        }

        $validated['status'] = $request->input('status', 'aktif');
        
        $mainComponent = MainComponent::create($validated);

        // Save Related Components
        $this->saveRelatedComponents($mainComponent, $request);

        // Save Related Documents
        $this->saveRelatedDocuments($mainComponent, $request);

        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya ditambah');
    }

    /**
     * Display the specified main component
     */
    public function show(MainComponent $mainComponent)
    {
        $mainComponent->load([
            'component', 
            'subComponents', 
            'relatedComponents', 
            'relatedDocuments'
        ]);
        
        return view('components.view-main-component', compact('mainComponent'));
    }

    /**
     * Show the form for editing the main component
     */
    public function edit(MainComponent $mainComponent)
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();
        
        return view('components.edit-main-component', compact(
            'mainComponent', 'components', 'sistems', 'subsistems'
        ));
    }

    /**
     * Update the specified main component
     */
    public function update(Request $request, MainComponent $mainComponent)
    {
        $validated = $request->validate($this->validationRules());

        // Handle checkboxes - convert to boolean
        $validated['awam_arkitek'] = $request->has('awam_arkitek') ? 1 : 0;
        $validated['elektrikal'] = $request->has('elektrikal') ? 1 : 0;
        $validated['elv_ict'] = $request->has('elv_ict') ? 1 : 0;
        $validated['mekanikal'] = $request->has('mekanikal') ? 1 : 0;
        $validated['bio_perubatan'] = $request->has('bio_perubatan') ? 1 : 0;

        // Handle array fields - gabungkan dengan comma
        $validated['saiz'] = $this->processArrayField($request->input('saiz'));
        $validated['saiz_unit'] = $this->processArrayField($request->input('saiz_unit'));
        $validated['kadaran'] = $this->processArrayField($request->input('kadaran'));
        $validated['kadaran_unit'] = $this->processArrayField($request->input('kadaran_unit'));
        $validated['kapasiti'] = $this->processArrayField($request->input('kapasiti'));
        $validated['kapasiti_unit'] = $this->processArrayField($request->input('kapasiti_unit'));

        // Atribut tambahan dari partial
        $validated['jenis'] = $request->input('jenis');
        $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
        $validated['bahan'] = $request->input('bahan');
        $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
        $validated['catatan_atribut'] = $request->input('catatan_atribut');
        $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
        $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
        $validated['nota'] = $request->input('nota');

        // Save new Sistem if doesn't exist
        if (!empty($validated['sistem'])) {
            $this->saveSistem($validated['sistem']);
        }
        
        // Save new Subsistem if doesn't exist
        if (!empty($validated['subsistem'])) {
            $this->saveSubsistem($validated['subsistem'], $validated['sistem'] ?? null);
        }

        $mainComponent->update($validated);

        // Update Related Components
        $mainComponent->relatedComponents()->delete();
        $this->saveRelatedComponents($mainComponent, $request);

        // Update Related Documents
        $mainComponent->relatedDocuments()->delete();
        $this->saveRelatedDocuments($mainComponent, $request);

        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya dikemaskini');
    }

    /**
     * Soft delete the specified main component
     */
    public function destroy(MainComponent $mainComponent)
    {
        $mainComponent->delete();
        
        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya dipadam');
    }

    /**
     * Display a listing of trashed main components
     */
    public function trashed()
    {
        $mainComponents = MainComponent::onlyTrashed()
            ->with(['component', 'subComponents'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('main-components.trashed', compact('mainComponents'));
    }

    /**
     * Restore a trashed main component
     */
    public function restore($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->restore();
        
        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipulihkan');
    }

    /**
     * Permanently delete a trashed main component
     */
    public function forceDestroy($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->forceDelete();
        
        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipadam secara kekal');
    }

    /**
     * Get validation rules for store and update
     */
    private function validationRules(): array
    {
        return [
            'component_id' => 'required|exists:components,id',
            'kod_lokasi' => 'required|string|max:100',
            'nama_komponen_utama' => 'required|string|max:255',
            'sistem' => 'nullable|string|max:255',
            'subsistem' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'awam_arkitek' => 'nullable',
            'elektrikal' => 'nullable',
            'elv_ict' => 'nullable',
            'mekanikal' => 'nullable',
            'bio_perubatan' => 'nullable',
            'lain_lain' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'tarikh_perolehan' => 'nullable|date',
            'kos_perolehan' => 'nullable|string|max:100',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'tarikh_tamat_dlp' => 'nullable|date',
            'jangka_hayat' => 'nullable|string|max:50',
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_maklumat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'no_siri' => 'nullable|string|max:255',
            'no_tag_label' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            // Atribut Spesifikasi
            'jenis' => 'nullable|string|max:255',
            'bekalan_elektrik' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'kaedah_pemasangan' => 'nullable|string|max:255',
            'saiz' => 'nullable',
            'saiz_unit' => 'nullable',
            'kadaran' => 'nullable',
            'kadaran_unit' => 'nullable',
            'kapasiti' => 'nullable',
            'kapasiti_unit' => 'nullable',
            'catatan_atribut' => 'nullable|string',
            'catatan_komponen_berhubung' => 'nullable|string',
            'catatan_dokumen' => 'nullable|string',
            'nota' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }

    /**
     * Helper: Save Sistem if doesn't exist
     */
    private function saveSistem(string $kod): void
    {
        $exists = Sistem::where('kod', $kod)->exists();
        
        if (!$exists) {
            Sistem::create([
                'kod' => $kod,
                'nama' => $kod,
            ]);
        }
    }

    /**
     * Helper: Save Subsistem if doesn't exist
     */
    private function saveSubsistem(string $kod, ?string $sistemKod = null): void
    {
        $exists = Subsistem::where('kod', $kod)->exists();
        
        if (!$exists) {
            $sistemId = null;
            if ($sistemKod) {
                $sistem = Sistem::where('kod', $sistemKod)->first();
                $sistemId = $sistem?->id;
            }
            
            Subsistem::create([
                'kod' => $kod,
                'nama' => $kod,
                'sistem_id' => $sistemId,
            ]);
        }
    }

    /**
     * Helper: Process array field to string (comma separated)
     */
    private function processArrayField($input): ?string
    {
        if (empty($input)) {
            return null;
        }
        
        if (is_array($input)) {
            // Filter empty values and join with comma
            $filtered = array_filter($input, function($v) {
                return $v !== null && $v !== '';
            });
            return !empty($filtered) ? implode(', ', $filtered) : null;
        }
        
        return $input;
    }

    /**
     * Helper: Save Related Components
     */
    private function saveRelatedComponents(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('related_bil', []);
        $namas = $request->input('related_nama', []);
        $dpas = $request->input('related_dpa', []);
        $tags = $request->input('related_tag', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
                // Skip jika nama kosong
                if (empty(trim($nama ?? ''))) {
                    continue;
                }
                
                \App\Models\RelatedComponent::create([
                    'main_component_id' => $mainComponent->id,
                    'bil' => $bils[$index] ?? ($index + 1),
                    'nama_komponen' => $nama,
                    'no_dpa_kod_ruang' => $dpas[$index] ?? null,
                    'no_tag_label' => $tags[$index] ?? null,
                ]);
            }
        }
    }

    /**
     * Helper: Save Related Documents
     */
    private function saveRelatedDocuments(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
                // Skip jika nama kosong
                if (empty(trim($nama ?? ''))) {
                    continue;
                }
                
                \App\Models\RelatedDocument::create([
                    'main_component_id' => $mainComponent->id,
                    'bil' => $bils[$index] ?? ($index + 1),
                    'nama_dokumen' => $nama,
                    'no_rujukan_berkaitan' => $rujukans[$index] ?? null,
                    'catatan' => $catatans[$index] ?? null,
                ]);
            }
        }
    }
}