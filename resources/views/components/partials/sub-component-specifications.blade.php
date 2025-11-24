<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
<div class="card mb-4 mt-4">
    <div class="card-header bg-dark text-white">
        <strong>** MAKLUMAT ATRIBUT SPESIFIKASI</strong>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="jenis" class="form-label">Jenis</label>
                <input id="jenis" type="text" class="form-control" name="jenis" value="{{ old('jenis') }}">
            </div>
            <div class="col-md-6">
                <label for="bahan" class="form-label">Bahan</label>
                <input id="bahan" type="text" class="form-control" name="bahan" value="{{ old('bahan') }}">
            </div>
        </div>

        <div class="row">
            <!-- Saiz Fizikal -->
            <label for="saiz_fizikal_0" class="form-label">Saiz fizikal</label>
    </div>
    <div class="card-body">
        <div id="saizFizikalContainer">
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input id="saiz_fizikal_0" type="text" class="form-control form-control-sm" name="saiz[]" placeholder="Saiz Fizikal">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="saiz_unit[]" placeholder="Unit">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>

    <!-- Kapasiti -->
    <label for="kapasiti_0" class="form-label">Kapasiti</label>
    </div>
    <div class="card-body">
        <div id="kapasitiContainer">
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input id="kapasiti_0" type="text" class="form-control form-control-sm" name="kapasiti[]" placeholder="Kapasiti">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="kapasiti_unit[]" placeholder="Unit">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>
            </div>

            <!-- Kadaran & Gambar -->
            <label for="kadaran_0" class="form-label">Kadaran</label>
    <div class="card-body">
        <div id="kadaranContainer">
            <div class="row mb-2 related-component-row">
                <div class="col-md-5">
                    <input id="kadaran_0" type="text" class="form-control form-control-sm" name="kadaran[]" placeholder="Kadaran">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="kadaran_unit[]" placeholder="Unit">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRelatedRow(this)" style="display:none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>
    </div>

        <div class="mt-3">
            <label for="catatan_atribut" class="form-label">Catatan:</label>
            <textarea id="catatan_atribut" class="form-control" name="catatan_atribut" rows="2">{{ old('catatan_atribut') }}</textarea>
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
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_pembelian" value="{{ old('tarikh_pembelian') }}"></td>
                        </tr>
                        <tr>
                            <td>Kos Perolehan/Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ old('kos_perolehan') }}" placeholder="RM"></td>
                        </tr>
                        <tr>
                            <td>No. Pesanan Rasmi Kerajaan / Kontrak</td>
                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ old('no_pesanan_rasmi_kontrak') }}"></td>
                        </tr>
                        <tr>
                            <td>Kod PTJ</td>
                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ old('kod_ptj') }}"></td>
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
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" value="{{ old('tarikh_dipasang') }}"></td>
                        </tr>
                        <tr>
                            <td>Tarikh Waranti Tamat</td>
                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" value="{{ old('tarikh_waranti_tamat') }}"></td>
                        </tr>
                        <tr>
                            <td>Jangka Hayat</td>
                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ old('jangka_hayat') }}" placeholder="Tahun"></td>
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
                           value="{{ old('nama_pengilang') }}" placeholder="Nama">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Pembekal</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_pembekal"
                           value="{{ old('nama_pembekal') }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_pembekal"
                              rows="2" placeholder="Alamat">{{ old('alamat_pembekal') }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal"
                           value="{{ old('no_telefon_pembekal') }}" placeholder="No. Telefon">
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="fw-bold small">Kontraktor</h6>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="nama_kontraktor"
                           value="{{ old('nama_kontraktor') }}" placeholder="Nama">
                </div>
                <div class="mb-2">
                    <textarea class="form-control form-control-sm" name="alamat_kontraktor"
                              rows="2" placeholder="Alamat">{{ old('alamat_kontraktor') }}</textarea>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor"
                           value="{{ old('no_telefon_kontraktor') }}" placeholder="No. Telefon">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label for="catatan_pembelian" class="form-label">Catatan:</label>
            <textarea id="catatan_pembelian" class="form-control" name="catatan_pembelian" rows="2">{{ old('catatan_pembelian') }}</textarea>
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
            <div class="row mb-2 document-row">
                <div class="col-md-1">
                    <input type="number" class="form-control form-control-sm" name="doc_bil[]" placeholder="Bil" value="1">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="doc_nama[]" placeholder="Nama Dokumen">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="doc_rujukan[]" placeholder="No Rujukan Berkaitan">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="doc_catatan[]" placeholder="Catatan">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeDocRow(this)" style="display:none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label for="catatan_dokumen" class="form-label">Catatan:</label>
            <textarea id="catatan_dokumen" class="form-control" name="catatan_dokumen" rows="2">{{ old('catatan_dokumen') }}</textarea>
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
        <textarea id="nota" class="form-control" name="nota" rows="2">{{ old('nota') }}</textarea>
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" class="form-select" name="status" required>
            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
let docCounter = 1;

function addDocument() {
    docCounter++;
    const container = document.getElementById('documentsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 document-row';
    newRow.innerHTML = `
        <div class="col-md-1">
            <input type="number" class="form-control form-control-sm" name="doc_bil[]" placeholder="Bil" value="${docCounter}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="doc_nama[]" placeholder="Nama Dokumen">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="doc_rujukan[]" placeholder="No Rujukan Berkaitan">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control form-control-sm" name="doc_catatan[]" placeholder="Catatan">
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