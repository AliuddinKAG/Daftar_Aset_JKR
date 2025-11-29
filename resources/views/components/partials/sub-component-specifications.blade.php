@php
    // Decode specifications if editing
    $specs = isset($subComponent) && $subComponent->specifications 
        ? json_decode($subComponent->specifications, true) 
        : [];
    
    // Helper function to get old value or existing value
    function getSpecValue($key, $specs, $default = '') {
        return old($key, $specs[$key] ?? $default);
    }
    
    function getSpecArray($key, $specs, $default = []) {
        return old($key, $specs[$key] ?? $default);
    }
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
                <input id="jenis" type="text" class="form-control" name="jenis" value="{{ getSpecValue('jenis', $specs) }}">
            </div>
            <div class="col-md-6">
                <label for="bahan" class="form-label">Bahan</label>
                <input id="bahan" type="text" class="form-control" name="bahan" value="{{ getSpecValue('bahan', $specs) }}">
            </div>
        </div>

        <div class="row">
            <!-- Saiz Fizikal -->
            <label for="saiz_fizikal_0" class="form-label">Saiz fizikal</label>
    </div>
    <div class="card-body">
        <div id="saizFizikalContainer">
            @php
                $saizArray = getSpecArray('saiz', $specs, ['']);
                $saizUnitArray = getSpecArray('saiz_unit', $specs, ['']);
            @endphp
            
            @foreach($saizArray as $index => $saiz)
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" name="saiz" placeholder="Saiz Fizikal" value="{{ $saiz }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="saiz_unit" placeholder="Unit" value="{{ $saizUnitArray[$index] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:{{ $index > 0 ? 'block' : 'none' }};">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addSaizFizikal()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>

    <!-- Kapasiti -->
    <label for="kapasiti_0" class="form-label">Kapasiti</label>
    </div>
    <div class="card-body">
        <div id="kapasitiContainer">
            @php
                $kapasitiArray = getSpecArray('kapasiti', $specs, ['']);
                $kapasitiUnitArray = getSpecArray('kapasiti_unit', $specs, ['']);
            @endphp
            
            @foreach($kapasitiArray as $index => $kapasiti)
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" name="kapasiti" placeholder="Kapasiti" value="{{ $kapasiti }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="kapasiti_unit" placeholder="Unit" value="{{ $kapasitiUnitArray[$index] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:{{ $index > 0 ? 'block' : 'none' }};">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addKapasiti()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>
            </div>

            <!-- Kadaran & Gambar -->
            <label for="kadaran_0" class="form-label">Kadaran</label>
    <div class="card-body">
        <div id="kadaranContainer">
            @php
                $kadaranArray = getSpecArray('kadaran', $specs, ['']);
                $kadaranUnitArray = getSpecArray('kadaran_unit', $specs, ['']);
            @endphp
            
            @foreach($kadaranArray as $index => $kadaran)
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" name="kadaran" placeholder="Kadaran" value="{{ $kadaran }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="kadaran_unit" placeholder="Unit" value="{{ $kadaranUnitArray[$index] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:{{ $index > 0 ? 'block' : 'none' }};">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addKadaran()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>

        <div class="mt-3">
            <label for="catatan_atribut" class="form-label">Catatan:</label>
            <textarea id="catatan_atribut" class="form-control" name="catatan_atribut" rows="2">{{ getSpecValue('catatan_atribut', $specs) }}</textarea>
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
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_pembelian" value="{{ getSpecValue('tarikh_pembelian', $specs) }}"></td>
                        </tr>
                        <tr>
                            <td>Kos Perolehan/Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ getSpecValue('kos_perolehan', $specs) }}" placeholder="RM"></td>
                        </tr>
                        <tr>
                            <td>No. Pesanan Rasmi Kerajaan / Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ getSpecValue('no_pesanan_rasmi_kontrak', $specs) }}"></td>
                        </tr>
                        <tr>
                            <td>Kod PTJ</td>
                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ getSpecValue('kod_ptj', $specs) }}"></td>
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
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" value="{{ getSpecValue('tarikh_dipasang', $specs) }}"></td>
                        </tr>
                        <tr>
                            <td>Tarikh Waranti Tamat</td>
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" value="{{ getSpecValue('tarikh_waranti_tamat', $specs) }}"></td>
                        </tr>
                        <tr>
                            <td>Jangka Hayat</td>
                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ getSpecValue('jangka_hayat', $specs) }}" placeholder="Tahun"></td>
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
                           value="{{ getSpecValue('nama_pengilang', $specs) }}" placeholder="Nama">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Pembekal</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_pembekal"
                           value="{{ getSpecValue('nama_pembekal', $specs) }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_pembekal"
                              rows="2" placeholder="Alamat">{{ getSpecValue('alamat_pembekal', $specs) }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal"
                           value="{{ getSpecValue('no_telefon_pembekal', $specs) }}" placeholder="No. Telefon">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Kontraktor</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_kontraktor"
                           value="{{ getSpecValue('nama_kontraktor', $specs) }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_kontraktor"
                              rows="2" placeholder="Alamat">{{ getSpecValue('alamat_kontraktor', $specs) }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor"
                           value="{{ getSpecValue('no_telefon_kontraktor', $specs) }}" placeholder="No. Telefon">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label for="catatan_pembelian" class="form-label">Catatan:</label>
            <textarea id="catatan_pembelian" class="form-control" name="catatan_pembelian" rows="2">{{ getSpecValue('catatan_pembelian', $specs) }}</textarea>
        </div>
    </div>
</div>

<!-- DOKUMEN BERKAITAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <strong>Dokumen Berkaitan (Jika Ada)</strong>
    </div>
    <div class="card-body">
        <div id="documentsContainer">
            @php
                $docBilArray = getSpecArray('doc_bil', $specs, [1]);
                $docNamaArray = getSpecArray('doc_nama', $specs, ['']);
                $docRujukanArray = getSpecArray('doc_rujukan', $specs, ['']);
                $docCatatanArray = getSpecArray('doc_catatan', $specs, ['']);
            @endphp
            
            @foreach($docBilArray as $index => $bil)
            <div class="row mb-2 document-row">
                <div class="col-md-1">
                    <input type="number" class="form-control form-control-sm" name="doc_bil" placeholder="Bil" value="{{ $bil }}">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="doc_nama" placeholder="Nama Dokumen" value="{{ $docNamaArray[$index] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="doc_rujukan" placeholder="No Rujukan Berkaitan" value="{{ $docRujukanArray[$index] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="doc_catatan" placeholder="Catatan" value="{{ $docCatatanArray[$index] ?? '' }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeDocRow(this)" style="display:{{ $index > 0 ? 'block' : 'none' }};">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label for="catatan_dokumen" class="form-label">Catatan:</label>
            <textarea id="catatan_dokumen" class="form-control" name="catatan_dokumen" rows="2">{{ getSpecValue('catatan_dokumen', $specs) }}</textarea>
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
        <textarea id="nota" class="form-control" name="nota" rows="2">{{ getSpecValue('nota', $specs) }}</textarea>
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" class="form-select" name="status" required>
            <option value="aktif" {{ getSpecValue('status', $specs, 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ getSpecValue('status', $specs) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
let docCounter = {{ count($docBilArray ?? [1]) }};

function addSaizFizikal() {
    const container = document.getElementById('saizFizikalContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 related-component-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="saiz" placeholder="Saiz Fizikal">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="saiz_unit" placeholder="Unit">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function addKapasiti() {
    const container = document.getElementById('kapasitiContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 related-component-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="kapasiti" placeholder="Kapasiti">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="kapasiti_unit" placeholder="Unit">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function addKadaran() {
    const container = document.getElementById('kadaranContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 related-component-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="kadaran" placeholder="Kadaran">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="kadaran_unit" placeholder="Unit">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function removeRelatedRow(btn) {
    btn.closest('.related-component-row').remove();
}

function addDocument() {
    docCounter++;
    const container = document.getElementById('documentsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 document-row';
    newRow.innerHTML = `
        <div class="col-md-1">
            <input type="number" class="form-control form-control-sm" name="doc_bil" placeholder="Bil" value="${docCounter}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="doc_nama" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="doc_rujukan" placeholder="No Rujukan Berkaitan">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="doc_catatan" placeholder="Catatan">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeDocRow(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function removeDocRow(btn) {
    btn.closest('.document-row').remove();
}
</script>