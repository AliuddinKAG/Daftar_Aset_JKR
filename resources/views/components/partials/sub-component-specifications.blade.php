@php
    // Get existing values for edit mode
    $jenis = old('jenis', $subComponent->jenis ?? '');
    $bahan = old('bahan', $subComponent->bahan ?? '');
    
    // Simple string values - NO JSON, NO ARRAY
    // Kalau database ada JSON/array lama, bersihkan
    $saiz = old('saiz', $subComponent->saiz ?? '');
    if (is_array($saiz)) {
        $saiz = $saiz[0] ?? '';
    } elseif (is_string($saiz) && (str_starts_with($saiz, '[') || str_starts_with($saiz, '{"'))) {
        $decoded = json_decode($saiz, true);
        $saiz = is_array($decoded) ? ($decoded[0] ?? '') : $saiz;
    }
    $saiz = trim($saiz, '[]"');
    
    $saizUnit = old('saiz_unit', $subComponent->saiz_unit ?? '');
    if (is_array($saizUnit)) {
        $saizUnit = $saizUnit[0] ?? '';
    } elseif (is_string($saizUnit) && (str_starts_with($saizUnit, '[') || str_starts_with($saizUnit, '{"'))) {
        $decoded = json_decode($saizUnit, true);
        $saizUnit = is_array($decoded) ? ($decoded[0] ?? '') : $saizUnit;
    }
    $saizUnit = trim($saizUnit, '[]"');
    
    $kapasiti = old('kapasiti', $subComponent->kapasiti ?? '');
    if (is_array($kapasiti)) {
        $kapasiti = $kapasiti[0] ?? '';
    } elseif (is_string($kapasiti) && (str_starts_with($kapasiti, '[') || str_starts_with($kapasiti, '{"'))) {
        $decoded = json_decode($kapasiti, true);
        $kapasiti = is_array($decoded) ? ($decoded[0] ?? '') : $kapasiti;
    }
    $kapasiti = trim($kapasiti, '[]"');
    
    $kapasitiUnit = old('kapasiti_unit', $subComponent->kapasiti_unit ?? '');
    if (is_array($kapasitiUnit)) {
        $kapasitiUnit = $kapasitiUnit[0] ?? '';
    } elseif (is_string($kapasitiUnit) && (str_starts_with($kapasitiUnit, '[') || str_starts_with($kapasitiUnit, '{"'))) {
        $decoded = json_decode($kapasitiUnit, true);
        $kapasitiUnit = is_array($decoded) ? ($kapasitiUnit[0] ?? '') : $kapasitiUnit;
    }
    $kapasitiUnit = trim($kapasitiUnit, '[]"');
    
    $kadaran = old('kadaran', $subComponent->kadaran ?? '');
    if (is_array($kadaran)) {
        $kadaran = $kadaran[0] ?? '';
    } elseif (is_string($kadaran) && (str_starts_with($kadaran, '[') || str_starts_with($kadaran, '{"'))) {
        $decoded = json_decode($kadaran, true);
        $kadaran = is_array($decoded) ? ($decoded[0] ?? '') : $kadaran;
    }
    $kadaran = trim($kadaran, '[]"');
    
    $kadaranUnit = old('kadaran_unit', $subComponent->kadaran_unit ?? '');
    if (is_array($kadaranUnit)) {
        $kadaranUnit = $kadaranUnit[0] ?? '';
    } elseif (is_string($kadaranUnit) && (str_starts_with($kadaranUnit, '[') || str_starts_with($kadaranUnit, '{"'))) {
        $decoded = json_decode($kadaranUnit, true);
        $kadaranUnit = is_array($decoded) ? ($decoded[0] ?? '') : $kadaranUnit;
    }
    $kadaranUnit = trim($kadaranUnit, '[]"');
    
    // Purchase info
    $tarikhPembelian = old('tarikh_pembelian', $subComponent->tarikh_pembelian ?? '');
    $kosPerolehan = old('kos_perolehan', $subComponent->kos_perolehan ?? '');
    $noPesananRasmi = old('no_pesanan_rasmi_kontrak', $subComponent->no_pesanan_rasmi_kontrak ?? '');
    $kodPtj = old('kod_ptj', $subComponent->kod_ptj ?? '');
    $tarikhDipasang = old('tarikh_dipasang', $subComponent->tarikh_dipasang ?? '');
    $tarikhWaranti = old('tarikh_waranti_tamat', $subComponent->tarikh_waranti_tamat ?? '');
    $jangkaHayat = old('jangka_hayat', $subComponent->jangka_hayat ?? '');
    
    // Supplier info
    $namaPengilang = old('nama_pengilang', $subComponent->nama_pengilang ?? '');
    $namaPembekal = old('nama_pembekal', $subComponent->nama_pembekal ?? '');
    $alamatPembekal = old('alamat_pembekal', $subComponent->alamat_pembekal ?? '');
    $noTelPembekal = old('no_telefon_pembekal', $subComponent->no_telefon_pembekal ?? '');
    $namaKontraktor = old('nama_kontraktor', $subComponent->nama_kontraktor ?? '');
    $alamatKontraktor = old('alamat_kontraktor', $subComponent->alamat_kontraktor ?? '');
    $noTelKontraktor = old('no_telefon_kontraktor', $subComponent->no_telefon_kontraktor ?? '');
    
    // Documents
    $dokumenList = isset($subComponent) && $subComponent->dokumen_berkaitan 
        ? $subComponent->dokumen_berkaitan 
        : [];
    
    // Notes
    $catatanAtribut = old('catatan_atribut', $subComponent->catatan_atribut ?? '');
    $catatanPembelian = old('catatan_pembelian', $subComponent->catatan_pembelian ?? '');
    $catatanDokumen = old('catatan_dokumen', $subComponent->catatan_dokumen ?? '');
    $nota = old('nota', $subComponent->nota ?? '');
@endphp

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
<div class="card mb-4 mt-4">
    <div class="card-header bg-dark text-white">
        <strong>** MAKLUMAT ATRIBUT SPESIFIKASI</strong>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="jenis" class="form-label">Jenis</label>
                <input id="jenis" type="text" class="form-control" name="jenis" value="{{ $jenis }}">
            </div>
            <div class="col-md-6">
                <label for="bahan" class="form-label">Bahan</label>
                <input id="bahan" type="text" class="form-control" name="bahan" value="{{ $bahan }}">
            </div>
        </div>

        <!-- Saiz Fizikal -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Saiz Fizikal</strong>
                <small class="text-muted ms-2">(Contoh: 1200x400x500 untuk Panjang x Lebar x Tinggi)</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="saiz" value="{{ $saiz }}" placeholder="Contoh: 1200x400x500 atau 1200">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="saiz_unit" value="{{ $saizUnit }}" placeholder="Unit (mm/cm/m)">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kadaran -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Kadaran</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="kadaran" value="{{ $kadaran }}" placeholder="Nilai">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="kadaran_unit" value="{{ $kadaranUnit }}" placeholder="Unit (kW/HP/A)">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kapasiti -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Kapasiti</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="kapasiti" value="{{ $kapasiti }}" placeholder="Nilai">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="kapasiti_unit" value="{{ $kapasitiUnit }}" placeholder="Unit (L/kg/ton)">
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
                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ $kosPerolehan }}" placeholder="RM"></td>
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
    <div class="card-header bg-dark text-white">
        <strong>Dokumen Berkaitan (Jika Ada)</strong>
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
                @if(count($dokumenList) > 0)
                    @foreach($dokumenList as $index => $doc)
                    <tr class="document-row">
                        <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="{{ $doc['bil'] ?? ($index + 1) }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_nama[]" value="{{ $doc['nama'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]" value="{{ $doc['rujukan'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]" value="{{ $doc['catatan'] ?? '' }}"></td>
                        <td>
                            @if($index > 0)
                            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                                <i class="bi bi-x"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr class="document-row">
                    <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="1"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_nama[]" placeholder="Nama Dokumen"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]" placeholder="No Rujukan"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]" placeholder="Catatan"></td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label for="catatan_dokumen" class="form-label">Catatan:</label>
            <textarea id="catatan_dokumen" class="form-control" name="catatan_dokumen" rows="2">{{ $catatanDokumen }}</textarea>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small><strong>Nota:</strong></small><br>
            <small>* Sila gunakan lampiran jika Maklumat Sub Komponen diperolehi bagi kuantiti yang melebihi 1.</small><br>
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
let docCounter = {{ count($dokumenList) > 0 ? count($dokumenList) : 1 }};

// Dokumen Berkaitan
function addDocument() {
    docCounter++;
    const container = document.getElementById('documentsContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="${docCounter}"></td>
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