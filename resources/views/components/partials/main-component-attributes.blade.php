@php
    // ========================================
    // BASIC FIELDS
    // ========================================
    $jenis = old('jenis', $mainComponent->jenis ?? '');
    $bahan = old('bahan', $mainComponent->bahan ?? '');
    $bekalanElektrik = old('bekalan_elektrik', $mainComponent->bekalan_elektrik ?? '');
    
    // ========================================
    // SPESIFIKASI - SAIZ
    // Load dari measurements table via relationship
    // ========================================
    $saizList = old('saiz', []);
    $saizUnitList = old('saiz_unit', []);
    
    if (empty($saizList) && isset($mainComponent) && $mainComponent->exists) {
        // Guna relationship saizMeasurements() dari model
        $saizMeasurements = $mainComponent->saizMeasurements;
        
        foreach ($saizMeasurements as $measurement) {
            $saizList[] = $measurement->value;
            $saizUnitList[] = $measurement->unit ?? '';
        }
    }
    
    // Default: sekurang-kurangnya 1 empty row
    if (empty($saizList)) {
        $saizList = [''];
        $saizUnitList = [''];
    }
    
    // ========================================
    // SPESIFIKASI - KAPASITI
    // ========================================
    $kapasitiList = old('kapasiti', []);
    $kapasitiUnitList = old('kapasiti_unit', []);
    
    if (empty($kapasitiList) && isset($mainComponent) && $mainComponent->exists) {
        $kapasitiMeasurements = $mainComponent->kapasitiMeasurements;
        
        foreach ($kapasitiMeasurements as $measurement) {
            $kapasitiList[] = $measurement->value;
            $kapasitiUnitList[] = $measurement->unit ?? '';
        }
    }
    
    if (empty($kapasitiList)) {
        $kapasitiList = [''];
        $kapasitiUnitList = [''];
    }
    
    // ========================================
    // SPESIFIKASI - KADARAN
    // ========================================
    $kadaranList = old('kadaran', []);
    $kadaranUnitList = old('kadaran_unit', []);
    
    if (empty($kadaranList) && isset($mainComponent) && $mainComponent->exists) {
        $kadaranMeasurements = $mainComponent->kadaranMeasurements;
        
        foreach ($kadaranMeasurements as $measurement) {
            $kadaranList[] = $measurement->value;
            $kadaranUnitList[] = $measurement->unit ?? '';
        }
    }
    
    if (empty($kadaranList)) {
        $kadaranList = [''];
        $kadaranUnitList = [''];
    }
    
    // ========================================
    // PURCHASE INFO
    // ========================================
    $tarikhPembelian = old('tarikh_pembelian', $mainComponent->tarikh_pembelian ?? '');
    $kosPerolehan = old('kos_perolehan', $mainComponent->kos_perolehan ?? '');
    $noPesananRasmi = old('no_pesanan_rasmi_kontrak', $mainComponent->no_pesanan_rasmi_kontrak ?? '');
    $tarikhDipasang = old('tarikh_dipasang', $mainComponent->tarikh_dipasang ?? '');
    $tarikhWaranti = old('tarikh_waranti_tamat', $mainComponent->tarikh_waranti_tamat ?? '');
    $jangkaHayat = old('jangka_hayat', $mainComponent->jangka_hayat ?? '');
    
    // ========================================
    // SUPPLIER INFO
    // ========================================
    $namaPengilang = old('nama_pengilang', $mainComponent->nama_pengilang ?? '');
    $namaPembekal = old('nama_pembekal', $mainComponent->nama_pembekal ?? '');
    $alamatPembekal = old('alamat_pembekal', $mainComponent->alamat_pembekal ?? '');
    $noTelPembekal = old('no_telefon_pembekal', $mainComponent->no_telefon_pembekal ?? '');
    $namaKontraktor = old('nama_kontraktor', $mainComponent->nama_kontraktor ?? '');
    $alamatKontraktor = old('alamat_kontraktor', $mainComponent->alamat_kontraktor ?? '');
    $noTelKontraktor = old('no_telefon_kontraktor', $mainComponent->no_telefon_kontraktor ?? '');
    
    // ========================================
    // RELATED COMPONENTS
    // Load dari relatedComponents relationship
    // ========================================
    $komponenBerkaitan = [];
    if (isset($mainComponent) && $mainComponent->exists) {
        $relatedComps = $mainComponent->relatedComponents ?? collect();
        foreach ($relatedComps as $rc) {
            $komponenBerkaitan[] = [
                'bil' => $rc->bil,
                'nama' => $rc->nama_komponen,
                'no_siri' => $rc->no_dpa_kod_ruang,
                'catatan' => $rc->no_tag_label
            ];
        }
    }
    
    // Default: sekurang-kurangnya 1 empty row
    if (count($komponenBerkaitan) == 0) {
        $komponenBerkaitan = [['bil' => 1, 'nama' => '', 'no_siri' => '', 'catatan' => '']];
    }
    
    // ========================================
    // RELATED DOCUMENTS
    // Load dari relatedDocuments relationship
    // ========================================
    $dokumenList = [];
    if (isset($mainComponent) && $mainComponent->exists) {
        $relatedDocs = $mainComponent->relatedDocuments ?? collect();
        foreach ($relatedDocs as $rd) {
            $dokumenList[] = [
                'bil' => $rd->bil,
                'nama' => $rd->nama_dokumen,
                'rujukan' => $rd->no_rujukan_berkaitan,
                'catatan' => $rd->catatan
            ];
        }
    }
    
    // Default: sekurang-kurangnya 1 empty row
    if (count($dokumenList) == 0) {
        $dokumenList = [['bil' => 1, 'nama' => '', 'rujukan' => '', 'catatan' => '']];
    }
    
    // ========================================
    // NOTES/CATATAN
    // ========================================
    $catatanAtribut = old('catatan_atribut', $mainComponent->catatan_atribut ?? '');
    $catatanKomponen = old('catatan_komponen_berhubung', $mainComponent->catatan_komponen_berhubung ?? '');
    $catatanDokumen = old('catatan_dokumen', $mainComponent->catatan_dokumen ?? '');
    $nota = old('nota', $mainComponent->nota ?? '');
@endphp

{{-- Letakkan HTML form anda di bawah sini --}}
{{-- Form code sama seperti yang ada sekarang --}}

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
<div class="card mb-4 mt-4">
    <div class="card-header bg-dark text-white">
        <strong>** MAKLUMAT ATRIBUT SPESIFIKASI</strong>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="jenis" class="form-label">Jenis<span class="text-danger">*</span></label>
                <input id="jenis" type="text" class="form-control" name="jenis" value="{{ $jenis }}">
            </div>
            <div class="col-md-6">
                <label for="bahan" class="form-label">Bahan<span class="text-danger">*</span></label>
                <input id="bahan" type="text" class="form-control" name="bahan" value="{{ $bahan }}">
            </div>
            <div class="col-md-6">
                <label for="bekalan_elektrik" class="form-label">Bekalan Elektrik(MSB/SSB/FP/DB.....)<span class="text-danger">*</span></label>
                <input id="bekalan_elektrik" type="text" class="form-control" name="bekalan_elektrik" value="">
            </div>
        </div>

        <!-- SPESIFIKASI CONTAINER -->
        <div id="spesifikasiContainer">
            <!-- Saiz Fizikal -->
            <div class="card mb-3 spesifikasi-card" data-type="saiz">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Saiz Fizikal</strong>
                        <small class="text-muted ms-2">(Contoh: 1200x400x500 untuk Panjang x Lebar x Tinggi)</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-success" onclick="addSpesifikasi('saiz')">
                        <i class="bi bi-plus"></i> Tambah Saiz
                    </button>
                </div>
                <div class="card-body">
                    <div class="spesifikasi-rows">
                        @foreach($saizList as $index => $saiz)
                        <div class="row mb-2 spesifikasi-row">
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="saiz[]" value="{{ $saiz }}" placeholder="Contoh: 1200x400x500 atau 1200">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="saiz_unit[]" value="{{ $saizUnitList[$index] ?? '' }}" placeholder="Unit (mm/cm/m)">
                            </div>
                            <div class="col-md-1">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeSpesifikasi(this)">
                                    <i class="bi bi-x"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kadaran -->
            <div class="card mb-3 spesifikasi-card" data-type="kadaran">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong>Kadaran</strong>
                    <button type="button" class="btn btn-sm btn-success" onclick="addSpesifikasi('kadaran')">
                        <i class="bi bi-plus"></i> Tambah Kadaran
                    </button>
                </div>
                <div class="card-body">
                    <div class="spesifikasi-rows">
                        @foreach($kadaranList as $index => $kadaran)
                        <div class="row mb-2 spesifikasi-row">
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="kadaran[]" value="{{ $kadaran }}" placeholder="Nilai">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="kadaran_unit[]" value="{{ $kadaranUnitList[$index] ?? '' }}" placeholder="Unit (kW/HP/A/V)">
                            </div>
                            <div class="col-md-1">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeSpesifikasi(this)">
                                    <i class="bi bi-x"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kapasiti -->
            <div class="card mb-3 spesifikasi-card" data-type="kapasiti">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong>Kapasiti</strong>
                    <button type="button" class="btn btn-sm btn-success" onclick="addSpesifikasi('kapasiti')">
                        <i class="bi bi-plus"></i> Tambah Kapasiti
                    </button>
                </div>
                <div class="card-body">
                    <div class="spesifikasi-rows">
                        @foreach($kapasitiList as $index => $kapasiti)
                        <div class="row mb-2 spesifikasi-row">
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="kapasiti[]" value="{{ $kapasiti }}" placeholder="Nilai">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="kapasiti_unit[]" value="{{ $kapasitiUnitList[$index] ?? '' }}" placeholder="Unit (L/kg/ton/BTU)">
                            </div>
                            <div class="col-md-1">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeSpesifikasi(this)">
                                    <i class="bi bi-x"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label for="catatan_atribut" class="form-label">Catatan:</label>
            <textarea id="catatan_atribut" class="form-control" name="catatan_atribut" rows="2">{{ $catatanAtribut }}</textarea>
        </div>
    </div>
</div>

<!-- KOMPONEN YANG BERHUBUNGKAIT -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <strong>Komponen Yang Berhubungkait (Jika Ada)</strong>
        <button type="button" class="btn btn-sm btn-success" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Komponen
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th width="5%">Bil</th>
                    <th width="40%">Nama Komponen</th>
                    <th width="25%">No DPA / Kod Ruang</th>
                    <th width="25%">No Tag / Label</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="relatedComponentsContainer">
                @foreach($komponenBerkaitan as $index => $komponen)
                <tr class="component-row">
                    <td><input type="number" class="form-control form-control-sm" name="related_bil[]" value="{{ $komponen['bil'] ?? ($index + 1) }}"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_nama[]" value="{{ $komponen['nama'] ?? '' }}" placeholder="Nama Komponen"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_dpa[]" value="{{ $komponen['no_siri'] ?? '' }}" placeholder="No DPA / Kod Ruang"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_tag[]" value="{{ $komponen['catatan'] ?? '' }}" placeholder="No Tag / Label"></td>
                    <td>
                        @if($index > 0)
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                            <i class="bi bi-x"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <label for="catatan_komponen" class="form-label">Catatan:</label>
            <textarea id="catatan_komponen" class="form-control" name="catatan_komponen_berhubung" rows="2">{{ $catatanKomponen }}</textarea>
        </div>
    </div>
</div>

<!-- DOKUMEN BERKAITAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <strong>Dokumen Berkaitan (Jika Ada)</strong>
        <button type="button" class="btn btn-sm btn-success" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Dokumen
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th width="5%">Bil</th>
                    <th width="35%">Nama Dokumen</th>
                    <th width="30%">No Rujukan</th>
                    <th width="25%">Catatan</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="documentsContainer">
                @foreach($dokumenList as $index => $doc)
                <tr class="document-row">
                    <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="{{ $doc['bil'] ?? ($index + 1) }}"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_nama[]" value="{{ $doc['nama'] ?? '' }}" placeholder="Nama Dokumen"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]" value="{{ $doc['rujukan'] ?? '' }}" placeholder="No Rujukan"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]" value="{{ $doc['catatan'] ?? '' }}" placeholder="Catatan"></td>
                    <td>
                        @if($index > 0)
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                            <i class="bi bi-x"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <label for="catatan_dokumen" class="form-label">Catatan:</label>
            <textarea id="catatan_dokumen" class="form-control" name="catatan_dokumen" rows="2">{{ $catatanDokumen }}</textarea>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small><strong>Nota:</strong></small><br>
            <small>* Sila gunakan lampiran jika Maklumat Komponen Utama diperolehi bagi kuantiti yang melebihi 1.</small><br>
            <small>** Maklumat Spesifikasi diisi merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.</small>
        </div>
    </div>
</div>

<!-- Nota & Status -->
<div class="row mb-4">
    <div class="col-md-9">
        <label for="nota" class="form-label">Nota Tambahan:</label>
        <textarea id="nota" class="form-control" name="nota" rows="2">{{ $nota }}</textarea>
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" class="form-select" name="status" required>
            <option value="aktif" {{ old('status', $mainComponent->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ old('status', $mainComponent->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
</div>

<!-- Submit Buttons -->
<div class="d-flex justify-content-between">
    <a href="{{ route('components.index') }}" class="btn btn-secondary">
        <i class="bi bi-x-circle"></i> Batal
    </a>
    <button type="submit" class="btn btn-info text-white">
        <i class="bi bi-save"></i> Simpan Komponen Utama
    </button>
</div>

<script>
// Fungsi untuk tambah spesifikasi (saiz/kadaran/kapasiti)
function addSpesifikasi(type) {
    const card = document.querySelector(`.spesifikasi-card[data-type="${type}"]`);
    const container = card.querySelector('.spesifikasi-rows');
    
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 spesifikasi-row';
    
    let placeholderValue = '';
    let placeholderUnit = '';
    
    if (type === 'saiz') {
        placeholderValue = 'Contoh: 1200x400x500 atau 1200';
        placeholderUnit = 'Unit (mm/cm/m)';
    } else if (type === 'kadaran') {
        placeholderValue = 'Nilai';
        placeholderUnit = 'Unit (kW/HP/A/V)';
    } else if (type === 'kapasiti') {
        placeholderValue = 'Nilai';
        placeholderUnit = 'Unit (L/kg/ton/BTU)';
    }
    
    newRow.innerHTML = `
        <div class="col-md-7">
            <input type="text" class="form-control" name="${type}[]" placeholder="${placeholderValue}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="${type}_unit[]" placeholder="${placeholderUnit}">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeSpesifikasi(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    
    container.appendChild(newRow);
}

// Fungsi untuk buang baris spesifikasi
function removeSpesifikasi(button) {
    button.closest('.spesifikasi-row').remove();
}

// Fungsi untuk tambah komponen berkaitan
function addRelatedComponent() {
    const container = document.getElementById('relatedComponentsContainer');
    const rowCount = container.querySelectorAll('.component-row').length;
    const newBil = rowCount + 1;
    
    const newRow = document.createElement('tr');
    newRow.className = 'component-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="related_bil[]" value="${newBil}"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_nama[]" placeholder="Nama Komponen"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_dpa[]" placeholder="No DPA / Kod Ruang"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_tag[]" placeholder="No Tag / Label"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    
    container.appendChild(newRow);
}

// Fungsi untuk tambah dokumen
function addDocument() {
    const container = document.getElementById('documentsContainer');
    const rowCount = container.querySelectorAll('.document-row').length;
    const newBil = rowCount + 1;
    
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="${newBil}"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_nama[]" placeholder="Nama Dokumen"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]" placeholder="No Rujukan"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]" placeholder="Catatan"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    
    container.appendChild(newRow);
}
</script>