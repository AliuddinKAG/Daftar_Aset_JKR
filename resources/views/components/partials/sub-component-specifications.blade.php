@php
    // ========================================
    // BASIC FIELDS
    // ========================================
    $jenis = old('jenis', $subComponent->jenis ?? '');
    $bahan = old('bahan', $subComponent->bahan ?? '');
    
    // ========================================
    // SPESIFIKASI - SAIZ
    // Load dari measurements table via relationship
    // ========================================
    $saizList = old('saiz', []);
    $saizUnitList = old('saiz_unit', []);
    
    if (empty($saizList) && isset($subComponent) && $subComponent->exists) {
        // Guna relationship saizMeasurements() dari model
        $saizMeasurements = $subComponent->saizMeasurements;
        
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
    
    if (empty($kapasitiList) && isset($subComponent) && $subComponent->exists) {
        $kapasitiMeasurements = $subComponent->kapasitiMeasurements;
        
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
    
    if (empty($kadaranList) && isset($subComponent) && $subComponent->exists) {
        $kadaranMeasurements = $subComponent->kadaranMeasurements;
        
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
    // PURCHASE INFO - Format tarikh untuk input type="date"
    // ========================================
    $tarikhPembelian = old('tarikh_pembelian');
    if (!$tarikhPembelian && isset($subComponent->tarikh_pembelian)) {
        try {
            $tarikhPembelian = $subComponent->tarikh_pembelian instanceof \Carbon\Carbon 
                ? $subComponent->tarikh_pembelian->format('Y-m-d')
                : \Carbon\Carbon::parse($subComponent->tarikh_pembelian)->format('Y-m-d');
        } catch (\Exception $e) {
            $tarikhPembelian = '';
        }
    }
    
    $tarikhDipasang = old('tarikh_dipasang');
    if (!$tarikhDipasang && isset($subComponent->tarikh_dipasang)) {
        try {
            $tarikhDipasang = $subComponent->tarikh_dipasang instanceof \Carbon\Carbon 
                ? $subComponent->tarikh_dipasang->format('Y-m-d')
                : \Carbon\Carbon::parse($subComponent->tarikh_dipasang)->format('Y-m-d');
        } catch (\Exception $e) {
            $tarikhDipasang = '';
        }
    }
    
    $tarikhWaranti = old('tarikh_waranti_tamat');
    if (!$tarikhWaranti && isset($subComponent->tarikh_waranti_tamat)) {
        try {
            $tarikhWaranti = $subComponent->tarikh_waranti_tamat instanceof \Carbon\Carbon 
                ? $subComponent->tarikh_waranti_tamat->format('Y-m-d')
                : \Carbon\Carbon::parse($subComponent->tarikh_waranti_tamat)->format('Y-m-d');
        } catch (\Exception $e) {
            $tarikhWaranti = '';
        }
    }
    
    $kosPerolehan = old('kos_perolehan', $subComponent->kos_perolehan ?? '');
    $noPesananRasmi = old('no_pesanan_rasmi_kontrak', $subComponent->no_pesanan_rasmi_kontrak ?? '');
    $kodPtj = old('kod_ptj', $subComponent->kod_ptj ?? '');
    $jangkaHayat = old('jangka_hayat', $subComponent->jangka_hayat ?? '');
    
    // ========================================
    // SUPPLIER INFO
    // ========================================
    $namaPengilang = old('nama_pengilang', $subComponent->nama_pengilang ?? '');
    $namaPembekal = old('nama_pembekal', $subComponent->nama_pembekal ?? '');
    $alamatPembekal = old('alamat_pembekal', $subComponent->alamat_pembekal ?? '');
    $noTelPembekal = old('no_telefon_pembekal', $subComponent->no_telefon_pembekal ?? '');
    $namaKontraktor = old('nama_kontraktor', $subComponent->nama_kontraktor ?? '');
    $alamatKontraktor = old('alamat_kontraktor', $subComponent->alamat_kontraktor ?? '');
    $noTelKontraktor = old('no_telefon_kontraktor', $subComponent->no_telefon_kontraktor ?? '');
    
    // ========================================
    // DOCUMENTS - organized by category
    // ========================================
    $dokumenByCategory = [];
    if (isset($subComponent) && $subComponent->dokumen_berkaitan) {
        if (is_array($subComponent->dokumen_berkaitan)) {
            foreach ($subComponent->dokumen_berkaitan as $doc) {
                $category = $doc['kategori'] ?? 'umum';
                if (!isset($dokumenByCategory[$category])) {
                    $dokumenByCategory[$category] = [];
                }
                $dokumenByCategory[$category][] = $doc;
            }
        }
    }
    
    // ========================================
    // NOTES
    // ========================================
    $catatanAtribut = old('catatan_atribut', $subComponent->catatan_atribut ?? '');
    $catatanPembelian = old('catatan_pembelian', $subComponent->catatan_pembelian ?? '');
    $catatanDokumen = old('catatan_dokumen', $subComponent->catatan_dokumen ?? '');
    $nota = old('nota', $subComponent->nota ?? '');
@endphp

{{-- HTML form sama seperti yang ada sekarang --}}
{{-- Kod HTML tidak perlu diubah --}}

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
                                <input type="text" class="form-control" name="kadaran_unit[]" value="{{ $kadaranUnitList[$index] ?? '' }}" placeholder="Unit (kW/HP/A)">
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
                                <input type="text" class="form-control" name="kapasiti_unit[]" value="{{ $kapasitiUnitList[$index] ?? '' }}" placeholder="Unit (L/kg/ton)">
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

<!-- MAKLUMAT PEMBELIAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <strong>Maklumat Pembelian</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th width="50%">Maklumat</th>
                            <th>Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%">Tarikh Pembelian</td>
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_pembelian" value="{{ $tarikhPembelian }}"></td>
                        </tr>
                        <tr>
                            <td>Kos Perolehan/Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ $kosPerolehan }}" placeholder="Contoh: 20000.00"></td>
                        </tr>
                        <tr>
                            <td>No. Pesanan Rasmi Kerajaan / Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ $noPesananRasmi }}"></td>
                        </tr>
                        <tr>
                            <td>Kod PTJ</td>
                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ $kodPtj }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Maklumat</th>
                            <th>Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%">Tarikh Dipasang</td>
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" value="{{ $tarikhDipasang }}"></td>
                        </tr>
                        <tr>
                            <td>Tarikh Waranti Tamat</td>
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" value="{{ $tarikhWaranti }}"></td>
                        </tr>
                        <tr>
                            <td>Jangka Hayat</td>
                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ $jangkaHayat }}" placeholder="Tahun"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pengilang, Pembekal, Kontraktor -->
        <div class="row mt-3">
            <div class="col-md-4">
                <h6 class="fw-bold small">Pengilang</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_pengilang"
                           value="{{ $namaPengilang }}" placeholder="Nama">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Pembekal</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_pembekal"
                           value="{{ $namaPembekal }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_pembekal"
                              rows="2" placeholder="Alamat">{{ $alamatPembekal }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal"
                           value="{{ $noTelPembekal }}" placeholder="No. Telefon">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Kontraktor</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_kontraktor"
                           value="{{ $namaKontraktor }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_kontraktor"
                              rows="2" placeholder="Alamat">{{ $alamatKontraktor }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor"
                           value="{{ $noTelKontraktor }}" placeholder="No. Telefon">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label for="catatan_pembelian" class="form-label">Catatan:</label>
            <textarea id="catatan_pembelian" class="form-control" name="catatan_pembelian" rows="2">{{ $catatanPembelian }}</textarea>
        </div>
    </div>
</div>

<!-- DOKUMEN BERKAITAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <strong>Dokumen Berkaitan (Jika Ada)</strong>
        
    </div>
    <div class="card-body">
        <div id="documentCategoriesContainer">
            @if(count($dokumenByCategory) > 0)
                @foreach($dokumenByCategory as $category => $documents)
                <div class="document-category-card card mb-3" data-category="{{ $category }}">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <strong>Kategori:</strong>
                            <input type="text" class="form-control form-control-sm d-inline-block" style="width: 200px;" name="doc_category[]" value="{{ $category }}" placeholder="Nama Kategori">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-success me-2" onclick="addDocumentToCategory(this)">
                                <i class="bi bi-plus"></i> Tambah Dokumen
                            </button>
                            @if($loop->index > 0)
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCategory(this)">
                                <i class="bi bi-x"></i>
                            </button>
                            @endif
                        </div>
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
                            <tbody class="documents-tbody">
                                @foreach($documents as $index => $doc)
                                <tr class="document-row">
                                    <td><input type="number" class="form-control form-control-sm" name="doc_bil[{{ $category }}][]" value="{{ $doc['bil'] ?? ($index + 1) }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_nama[{{ $category }}][]" value="{{ $doc['nama'] ?? '' }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[{{ $category }}][]" value="{{ $doc['rujukan'] ?? '' }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan[{{ $category }}][]" value="{{ $doc['catatan'] ?? '' }}"></td>
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
                    </div>
                </div>
                @endforeach
            @else
                <div class="document-category-card card mb-3" data-category="umum">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        
                        <div>
                            <button type="button" class="btn btn-sm btn-success me-2" onclick="addDocumentToCategory(this)">
                                <i class="bi bi-plus"></i> Tambah Dokumen
                            </button>
                        </div>
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
                            <tbody class="documents-tbody">
                                <tr class="document-row">
                                    <td><input type="number" class="form-control form-control-sm" name="doc_bil[umum][]" value="1"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_nama[umum][]" placeholder="Nama Dokumen"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[umum][]" placeholder="No Rujukan"></td>
                                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan[umum][]" placeholder="Catatan"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-3">
            <label for="catatan_dokumen" class="form-label">Catatan:</label>
            <textarea id="catatan_dokumen" class="form-control" name="catatan_dokumen" rows="2">{{ $catatanDokumen }}</textarea>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small><strong>Nota:</strong></small><br>
            <small>* Sila gunakan lampiran jika Maklumat Sub Komponen diperolehi bagi kuantiti yang melebihi 1.</small><br>
            <small>** Maklumat Spesifikasi diisi merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.</small><br>
            <small>*** Dokumen boleh dikategorikan mengikut jenis (cth: Waranti, Manual, Sijil, Kontrak, dll).</small>
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
            <option value="aktif" {{ old('status', $subComponent->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ old('status', $subComponent->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>
</div>

<!-- Submit Buttons -->
<div class="d-flex justify-content-between">
    <a href="{{ route('components.index') }}" class="btn btn-secondary">
        <i class="bi bi-x-circle"></i> Batal
    </a>
    <button type="submit" class="btn btn-info text-white">
        <i class="bi bi-save"></i> Simpan Sub Komponen
    </button>
</div>

<script>
let categoryCounter = 0;

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
        placeholderUnit = 'Unit (kW/HP/A)';
    } else if (type === 'kapasiti') {
        placeholderValue = 'Nilai';
        placeholderUnit = 'Unit (L/kg/ton)';
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

// Fungsi untuk tambah kategori dokumen baru
function addDocumentCategory() {
    categoryCounter++;
    const categoryName = 'kategori_' + categoryCounter;
    const container = document.getElementById('documentCategoriesContainer');
    
    const categoryCard = document.createElement('div');
    categoryCard.className = 'document-category-card card mb-3';
    categoryCard.setAttribute('data-category', categoryName);
    
    categoryCard.innerHTML = `
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <strong>Kategori:</strong>
                <input type="text" class="form-control form-control-sm d-inline-block" style="width: 200px;" name="doc_category[]" value="${categoryName}" placeholder="Nama Kategori">
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-success me-2" onclick="addDocumentToCategory(this)">
                    <i class="bi bi-plus"></i> Tambah Dokumen
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeCategory(this)">
                    <i class="bi bi-x"></i>
                </button>
            </div>
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
                <tbody class="documents-tbody">
                    <tr class="document-row">
                        <td><input type="number" class="form-control form-control-sm" name="doc_bil[${categoryName}][]" value="1"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_nama[${categoryName}][]" placeholder="Nama Dokumen"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[${categoryName}][]" placeholder="No Rujukan"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[${categoryName}][]" placeholder="Catatan"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;
    
    container.appendChild(categoryCard);
}

// Fungsi untuk tambah dokumen dalam kategori tertentu
function addDocumentToCategory(button) {
    const categoryCard = button.closest('.document-category-card');
    const tbody = categoryCard.querySelector('.documents-tbody');
    const categoryInput = categoryCard.querySelector('input[name="doc_category[]"]');
    const categoryName = categoryInput.value || 'umum';
    
    const rowCount = tbody.querySelectorAll('.document-row').length;
    const newBil = rowCount + 1;
    
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil[${categoryName}][]" value="${newBil}"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_nama[${categoryName}][]" placeholder="Nama Dokumen"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[${categoryName}][]" placeholder="No Rujukan"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[${categoryName}][]" placeholder="Catatan"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(newRow);
}

// Fungsi untuk buang kategori dokumen
function removeCategory(button) {
    if (confirm('Adakah anda pasti mahu membuang kategori dokumen ini?')) {
        button.closest('.document-category-card').remove();
    }
}
</script>