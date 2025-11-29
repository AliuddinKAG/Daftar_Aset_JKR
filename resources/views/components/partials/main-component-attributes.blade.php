@php
    // Decode specifications if editing
    $specs = isset($mainComponent) && $mainComponent->specifications_decoded 
        ? $mainComponent->specifications_decoded 
        : [];
    
    // Get related components
    $relatedComps = isset($mainComponent) && isset($mainComponent->relatedComponents) 
        ? $mainComponent->relatedComponents 
        : [];
    
    // Get related documents
    $relatedDocs = isset($mainComponent) && isset($mainComponent->relatedDocuments) 
        ? $mainComponent->relatedDocuments 
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
            <div class="col-md-4">
                <label class="form-label">Jenis</label>
                <input type="text" class="form-control" name="jenis" value="{{ getSpecValue('jenis', $specs) }}" placeholder="Contoh: WALL MOUNTED">
            </div>
            <div class="col-md-4">
                <label class="form-label">Bekalan Elektrik</label>
                <input type="text" class="form-control" name="bekalan_elektrik" value="{{ getSpecValue('bekalan_elektrik', $specs) }}" placeholder="MSB/SSB/PP/DB...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Bahan</label>
                <input type="text" class="form-control" name="bahan" value="{{ getSpecValue('bahan', $specs) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Kaedah Pemasangan</label>
                <input type="text" class="form-control" name="kaedah_pemasangan" value="{{ getSpecValue('kaedah_pemasangan', $specs) }}">
            </div>
        </div>

        <!-- Saiz Fizikal -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Saiz Fizikal</strong>
                <small class="text-muted ms-2">(Contoh: 1200x400x500 untuk Panjang x Lebar x Tinggi)</small>
            </div>
            <div class="card-body">
                <div id="saizContainer">
                    @php
                        $saizArray = getSpecArray('saiz', $specs, ['']);
                        $saizUnitArray = getSpecArray('saiz_unit', $specs, ['']);
                    @endphp
                    
                    @foreach($saizArray as $index => $saiz)
                    <div class="row mb-2 saiz-row">
                        <div class="col-md-5">
                            <input type="text" class="form-control form-control-sm" name="saiz" value="{{ $saiz }}" placeholder="Contoh: 1200x400x500 atau 1200">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="saiz_unit" value="{{ $saizUnitArray[$index] ?? '' }}" placeholder="Unit (mm/cm/m)">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-sm btn-danger btn-remove-row" onclick="this.closest('.saiz-row').remove()" style="display:{{ $index > 0 ? 'inline-block' : 'none' }};">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-success mt-2" onclick="addSaizRow()">
                    <i class="bi bi-plus"></i> Tambah Saiz
                </button>
            </div>
        </div>

        <!-- Kadaran -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Kadaran</strong>
            </div>
            <div class="card-body">
                <div id="kadaranContainer">
                    @php
                        $kadaranArray = getSpecArray('kadaran', $specs, ['']);
                        $kadaranUnitArray = getSpecArray('kadaran_unit', $specs, ['']);
                    @endphp
                    
                    @foreach($kadaranArray as $index => $kadaran)
                    <div class="row mb-2 kadaran-row">
                        <div class="col-md-5">
                            <input type="text" class="form-control form-control-sm" name="kadaran" value="{{ $kadaran }}" placeholder="Nilai">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="kadaran_unit" value="{{ $kadaranUnitArray[$index] ?? '' }}" placeholder="Unit (kW/HP/A)">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-sm btn-danger btn-remove-row" onclick="this.closest('.kadaran-row').remove()" style="display:{{ $index > 0 ? 'inline-block' : 'none' }};">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-success mt-2" onclick="addKadaranRow()">
                    <i class="bi bi-plus"></i> Tambah Kadaran
                </button>
            </div>
        </div>

        <!-- Kapasiti -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>Kapasiti</strong>
            </div>
            <div class="card-body">
                <div id="kapasitiContainer">
                    @php
                        $kapasitiArray = getSpecArray('kapasiti', $specs, ['']);
                        $kapasitiUnitArray = getSpecArray('kapasiti_unit', $specs, ['']);
                    @endphp
                    
                    @foreach($kapasitiArray as $index => $kapasiti)
                    <div class="row mb-2 kapasiti-row">
                        <div class="col-md-5">
                            <input type="text" class="form-control form-control-sm" name="kapasiti" value="{{ $kapasiti }}" placeholder="Nilai">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="kapasiti_unit" value="{{ $kapasitiUnitArray[$index] ?? '' }}" placeholder="Unit (L/kg/ton)">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-sm btn-danger btn-remove-row" onclick="this.closest('.kapasiti-row').remove()" style="display:{{ $index > 0 ? 'inline-block' : 'none' }};">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-success mt-2" onclick="addKapasitiRow()">
                    <i class="bi bi-plus"></i> Tambah Kapasiti
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Atribut:</label>
            <textarea class="form-control" name="catatan_atribut" rows="2">{{ getSpecValue('catatan_atribut', $specs) }}</textarea>
        </div>
    </div>
</div>

<!-- KOMPONEN YANG BERHUBUNGKAIT -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <strong>** Komponen Yang Berhubungkait (Jika Ada)</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th width="5%">Bil</th>
                    <th width="40%">Nama Komponen</th>
                    <th width="30%">No. DPA / Kod Ruang</th>
                    <th width="20%">No. Tag / Label</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="relatedComponentsContainer">
                @if(count($relatedComps) > 0)
                    @foreach($relatedComps as $index => $related)
                    <tr class="related-component-row">
                        <td><input type="number" class="form-control form-control-sm" name="related_bil" value="{{ $related['bil'] ?? ($index + 1) }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="related_nama" value="{{ $related['nama_komponen'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="related_dpa" value="{{ $related['no_dpa_kod_ruang'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="related_tag" value="{{ $related['no_tag_label'] ?? '' }}"></td>
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
                <tr class="related-component-row">
                    <td><input type="number" class="form-control form-control-sm" name="related_bil" value="1"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_nama" placeholder="Nama Komponen"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_dpa" placeholder="No. DPA / Kod Ruang"></td>
                    <td><input type="text" class="form-control form-control-sm" name="related_tag" placeholder="No. Tag / Label"></td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" onclick="addRelatedComponent()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label class="form-label">Catatan:</label>
            <textarea class="form-control" name="catatan_komponen_berhubung" rows="2">{{ getSpecValue('catatan_komponen_berhubung', $specs) }}</textarea>
        </div>
    </div>
</div>

<!-- DOKUMEN BERKAITAN -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <strong>** Dokumen Berkaitan (Jika Ada)</strong>
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
                @if(count($relatedDocs) > 0)
                    @foreach($relatedDocs as $index => $doc)
                    <tr class="document-row">
                        <td><input type="number" class="form-control form-control-sm" name="doc_bil" value="{{ $doc['bil'] ?? ($index + 1) }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_nama" value="{{ $doc['nama_dokumen'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan" value="{{ $doc['no_rujukan_berkaitan'] ?? '' }}"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_catatan" value="{{ $doc['catatan'] ?? '' }}"></td>
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
                    <td><input type="number" class="form-control form-control-sm" name="doc_bil" value="1"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_nama" placeholder="Nama Dokumen"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_rujukan" placeholder="No Rujukan"></td>
                    <td><input type="text" class="form-control form-control-sm" name="doc_catatan" placeholder="Catatan"></td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-sm btn-success" onclick="addDocument()">
            <i class="bi bi-plus"></i> Tambah Baris
        </button>

        <div class="mt-3">
            <label class="form-label">Catatan:</label>
            <textarea class="form-control" name="catatan_dokumen" rows="2">{{ getSpecValue('catatan_dokumen', $specs) }}</textarea>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <small><strong>Nota:</strong></small><br>
            <small>* Sila gunakan lampiran jika Maklumat Aset / Komponen diperolehi bagi kuantiti yang melebihi 1.</small><br>
            <small>** Maklumat Spesifikasi merujuk kepada Kategori Aset Khusus yang berkaitan sahaja.</small>
        </div>
    </div>
</div>

<!-- Nota & Status -->
<div class="row mb-4">
    <div class="col-md-9">
        <label class="form-label">Nota Tambahan:</label>
        <textarea class="form-control" name="nota" rows="3">{{ getSpecValue('nota', $specs) }}</textarea>
    </div>
    <div class="col-md-3">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" name="status" required>
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
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan Komponen Utama
    </button>
</div>

<script>
let relatedCounter = {{ count($relatedComps) > 0 ? count($relatedComps) : 1 }};
let docCounter = {{ count($relatedDocs) > 0 ? count($relatedDocs) : 1 }};

// Saiz Fizikal
function addSaizRow() {
    const container = document.getElementById('saizContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 saiz-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="saiz" placeholder="Contoh: 1200x400x500">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="saiz_unit" placeholder="Unit">
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.saiz-row').remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Kadaran
function addKadaranRow() {
    const container = document.getElementById('kadaranContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 kadaran-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="kadaran" placeholder="Nilai">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="kadaran_unit" placeholder="Unit">
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.kadaran-row').remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Kapasiti
function addKapasitiRow() {
    const container = document.getElementById('kapasitiContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 kapasiti-row';
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="kapasiti" placeholder="Nilai">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="kapasiti_unit" placeholder="Unit">
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.kapasiti-row').remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Komponen Berhubungkait
function addRelatedComponent() {
    relatedCounter++;
    const container = document.getElementById('relatedComponentsContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'related-component-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="related_bil" value="${relatedCounter}"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_nama" placeholder="Nama Komponen"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_dpa" placeholder="No. DPA / Kod Ruang"></td>
        <td><input type="text" class="form-control form-control-sm" name="related_tag" placeholder="No. Tag / Label"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    container.appendChild(newRow);
}

// Dokumen Berkaitan
function addDocument() {
    docCounter++;
    const container = document.getElementById('documentsContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil" value="${docCounter}"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_nama" placeholder="Nama Dokumen"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan" placeholder="No Rujukan"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_catatan" placeholder="Catatan"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    container.appendChild(newRow);
}
</script>