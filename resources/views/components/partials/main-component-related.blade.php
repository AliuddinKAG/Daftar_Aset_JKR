<!-- KOMPONEN YANG BERHUBUNGKAIT -->
<div class="card mb-4 mt-4">
    <div class="card-header bg-dark text-white">
        <strong>** Komponen Yang Berhubungkait (Jika Ada)</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="5%">Bil</th>
                    <th width="40%">Nama Komponen</th>
                    <th width="30%">No. DPA / Kod Ruang / Kod Binaan Luar</th>
                    <th width="20%">No. Tag / Label</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="relatedComponentsContainer">
                <tr class="related-component-row">
                    <td><input type="number" class="form-control form-control-sm" name="related_bil[]" value="1"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_nama[]"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_dpa[]"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_tag[]"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label class="form-label">Catatan:</label>
            <textarea class="form-control" name="catatan_komponen_berhubung" rows="2">{{ old('catatan_komponen_berhubung') }}</textarea>
        </div>
    </div>
</div>

<!-- DOKUMEN BERKAITAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <strong>** Dokumen Berkaitan (Jika Ada)</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="5%">Bil</th>
                    <th width="35%">Nama Dokumen</th>
                    <th width="30%">No Rujukan Berkaitan</th>
                    <th width="25%">Catatan</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="documentsContainer">
                <tr class="document-row">
                    <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="1"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_nama[]"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label class="form-label">Catatan:</label>
            <textarea class="form-control" name="catatan_dokumen" rows="2">{{ old('catatan_dokumen') }}</textarea>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small><strong>Nota:</strong></small><br>
            <small>* Sila gunakan lampiran jika Maklumat Aset / Komponen diperolehi bagi kuantiti yang melebihi 1.</small><br>
            <small>** Maklumat Spesifikasi itu merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.</small>
        </div>
    </div>
</div>

<!-- Nota & Status -->
<div class="row mb-4">
    <div class="col-md-9">
        <label class="form-label">Nota Tambahan:</label>
        <textarea class="form-control" name="nota" rows="3">{{ old('nota') }}</textarea>
    </div>
    <div class="col-md-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" name="status" required>
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
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan Komponen Utama
    </button>
</div>

<script>
let relatedCounter = 1;
let docCounter = 1;

function addRelatedComponent() {
    relatedCounter++;
    const container = document.getElementById('relatedComponentsContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'related-component-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="related_bil[]" value="${relatedCounter}"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_nama[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_dpa[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_tag[]"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    container.appendChild(newRow);
}

function addDocument() {
    docCounter++;
    const container = document.getElementById('documentsContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil[]" value="${docCounter}"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_nama[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[]"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    container.appendChild(newRow);
}
</script>