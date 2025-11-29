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
     * Helper: Process array field to JSON array (structured)
     */
    private function processArrayFieldToJson($values, $units): ?string
    {
        if (empty($values) && empty($units)) {
            return null;
        }
        
        $result = [];
        $valuesArray = is_array($values) ? $values : [$values];
        $unitsArray = is_array($units) ? $units : [$units];
        
        foreach ($valuesArray as $index => $value) {
            if ($value !== null && $value !== '') {
                $result[] = [
                    'nilai' => $value,
                    'unit' => $unitsArray[$index] ?? null
                ];
            }
        }
        
        return !empty($result) ? json_encode($result) : null;
    }

    /**
     * Helper: Decode JSON field for editing
     */
    private function decodeJsonField($jsonString)
    {
        if (empty($jsonString)) {
            return ['nilai' => '', 'unit' => ''];
        }
        
        $data = is_string($jsonString) ? json_decode($jsonString, true) : $jsonString;
        
        if (is_array($data) && !empty($data)) {
            return [
                'nilai' => $data[0]['nilai'] ?? '',
                'unit' => $data[0]['unit'] ?? ''
            ];
        }
        
        return ['nilai' => '', 'unit' => ''];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // Handle checkboxes
        $validated['awam_arkitek'] = $request->has('awam_arkitek') ? 1 : 0;
        $validated['elektrikal'] = $request->has('elektrikal') ? 1 : 0;
        $validated['elv_ict'] = $request->has('elv_ict') ? 1 : 0;
        $validated['mekanikal'] = $request->has('mekanikal') ? 1 : 0;
        $validated['bio_perubatan'] = $request->has('bio_perubatan') ? 1 : 0;

        // Handle Saiz - simpan sebagai string sahaja
        $validated['saiz'] = $request->input('saiz'); // contoh: "1200*400*200"
        $validated['saiz_unit'] = $request->input('saiz_unit'); // contoh: "MM"
    
        // Handle Kadaran - simpan sebagai string sahaja
        $validated['kadaran'] = $request->input('kadaran'); // contoh: "240"
        $validated['kadaran_unit'] = $request->input('kadaran_unit'); // contoh: "V"
    
        // Handle Kapasiti - simpan sebagai string sahaja
        $validated['kapasiti'] = $request->input('kapasiti'); // contoh: "5000"
        $validated['kapasiti_unit'] = $request->input('kapasiti_unit'); // contoh: "BTU"

        // Atribut tambahan
        $validated['jenis'] = $request->input('jenis');
        $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
        $validated['bahan'] = $request->input('bahan');
        $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
        $validated['catatan_atribut'] = $request->input('catatan_atribut');
        $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
        $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
        $validated['nota'] = $request->input('nota');

        // Save Sistem & Subsistem
        if (!empty($validated['sistem'])) {
            $this->saveSistem($validated['sistem']);
        }
        
        if (!empty($validated['subsistem'])) {
            $this->saveSubsistem($validated['subsistem'], $validated['sistem'] ?? null);
        }

        $validated['status'] = $request->input('status', 'aktif');
        
        $mainComponent = MainComponent::create($validated);

        $this->saveRelatedComponents($mainComponent, $request);
        $this->saveRelatedDocuments($mainComponent, $request);

        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya ditambah');
    }

    public function update(Request $request, MainComponent $mainComponent)
    {
        $validated = $request->validate($this->validationRules());

        // Handle checkboxes
        $validated['awam_arkitek'] = $request->has('awam_arkitek') ? 1 : 0;
        $validated['elektrikal'] = $request->has('elektrikal') ? 1 : 0;
        $validated['elv_ict'] = $request->has('elv_ict') ? 1 : 0;
        $validated['mekanikal'] = $request->has('mekanikal') ? 1 : 0;
        $validated['bio_perubatan'] = $request->has('bio_perubatan') ? 1 : 0;

        // Handle Saiz - simpan sebagai string sahaja
        $validated['saiz'] = $request->input('saiz');
        $validated['saiz_unit'] = $request->input('saiz_unit');
    
        // Handle Kadaran - simpan sebagai string sahaja
        $validated['kadaran'] = $request->input('kadaran');
        $validated['kadaran_unit'] = $request->input('kadaran_unit');
    
        // Handle Kapasiti - simpan sebagai string sahaja
        $validated['kapasiti'] = $request->input('kapasiti');
        $validated['kapasiti_unit'] = $request->input('kapasiti_unit');

        // Atribut tambahan
        $validated['jenis'] = $request->input('jenis');
        $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
        $validated['bahan'] = $request->input('bahan');
        $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
        $validated['catatan_atribut'] = $request->input('catatan_atribut');
        $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
        $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
        $validated['nota'] = $request->input('nota');

        if (!empty($validated['sistem'])) {
            $this->saveSistem($validated['sistem']);
        }
        
        if (!empty($validated['subsistem'])) {
            $this->saveSubsistem($validated['subsistem'], $validated['sistem'] ?? null);
        }

        $mainComponent->update($validated);

        $mainComponent->relatedComponents()->delete();
        $this->saveRelatedComponents($mainComponent, $request);

        $mainComponent->relatedDocuments()->delete();
        $this->saveRelatedDocuments($mainComponent, $request);

        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya dikemaskini');
    }

    public function edit(MainComponent $mainComponent)
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();

    return view('components.edit-main-component', compact(
        'mainComponent', 'components', 'sistems', 'subsistems'
    ));
    }

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

    private function saveRelatedComponents(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('related_bil', []);
        $namas = $request->input('related_nama', []);
        $dpas = $request->input('related_dpa', []);
        $tags = $request->input('related_tag', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
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

    private function saveRelatedDocuments(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
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

    public function generateKodLokasi(Request $request)
    {
        $componentId = $request->get('component_id');
        $component = Component::find($componentId);
        
        if (!$component) {
            return response()->json(['kod_lokasi' => ''], 400);
        }
        
        $count = MainComponent::where('component_id', $componentId)->count() + 1;
        $kodLokasi = 'KU-' . $componentId . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        
        return response()->json(['kod_lokasi' => $kodLokasi]);
    }

    public function create()
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();
        
        return view('components.create-main-component', compact(
            'components', 'sistems', 'subsistems'
        ));
    }

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

    public function destroy(MainComponent $mainComponent)
    {
        $mainComponent->delete();
        
        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya dipadam');
    }

    public function trashed()
    {
        $mainComponents = MainComponent::onlyTrashed()
            ->with(['component', 'subComponents'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('main-components.trashed', compact('mainComponents'));
    }

    public function restore($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->restore();
        
        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipulihkan');
    }

    public function forceDestroy($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->forceDelete();
        
        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipadam secara kekal');
    }
}