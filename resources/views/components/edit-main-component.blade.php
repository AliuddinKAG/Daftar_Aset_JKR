@extends('layouts.app')

@section('title', 'Edit Komponen Utama')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">EDIT BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Utama - {{ $mainComponent->nama_komponen_utama }}</small>
            </div>
            <div class="card-body">
                <form action="{{ route('main-components.update', $mainComponent) }}" method="POST" enctype="multipart/form-data" id="mainComponentForm">
                    @csrf
                    @method('PUT')

                    <!-- MAKLUMAT KOMPONEN UTAMA -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            MAKLUMAT KOMPONEN UTAMA
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama Premis <span class="text-danger">*</span></label>
                                    <select class="form-select @error('component_id') is-invalid @enderror" name="component_id" id="component_id" required>
                                        <option value="">-- Pilih Komponen --</option>
                                        @foreach($components as $component)
                                            <option value="{{ $component->id }}" 
                                                data-dpa="{{ $component->nombor_dpa }}"
                                                {{ old('component_id', $mainComponent->component_id) == $component->id ? 'selected' : '' }}>
                                                {{ $component->nama_premis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('component_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombor DPA</label>
                                    <input type="text" class="form-control bg-light" id="display_dpa" readonly 
                                           value="{{ $mainComponent->component->nombor_dpa ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kod Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                        class="form-control @error('kod_lokasi') is-invalid @enderror" 
                                        name="kod_lokasi" 
                                        id="kod_lokasi"
                                        value="{{ old('kod_lokasi', $mainComponent->kod_lokasi) }}" 
                                        required>
                                    @error('kod_lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card mb-3" style="background: #f8f9fa;">
                                <div class="card-header bg-dark text-white">
                                    <strong>Maklumat Utama</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Komponen Utama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_komponen_utama') is-invalid @enderror" 
                                               name="nama_komponen_utama" value="{{ old('nama_komponen_utama', $mainComponent->nama_komponen_utama) }}" required>
                                        @error('nama_komponen_utama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                   

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Sistem<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select select2-sistem" name="sistem" id="sistem">
                                                    <option value="">-- Pilih atau Taip Sistem --</option>
                                                    @foreach($sistems as $sistem)
                                                        <option value="{{ $sistem->kod }}" 
                                                            data-id="{{ $sistem->id }}"
                                                            {{ old('sistem', $mainComponent->sistem) == $sistem->kod ? 'selected' : '' }}>
                                                            {{ $sistem->kod }} - {{ $sistem->nama }}
                                                        </option>
                                                    @endforeach
                                                    @if($mainComponent->sistem && !$sistems->contains('kod', $mainComponent->sistem))
                                                        <option value="{{ $mainComponent->sistem }}" selected>{{ $mainComponent->sistem }}</option>
                                                    @endif
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">SubSistem<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-select select2-subsistem" name="subsistem" id="subsistem">
                                                    <option value="">-- Pilih atau Taip SubSistem --</option>
                                                    @foreach($subsistems as $subsistem)
                                                        <option value="{{ $subsistem->kod }}" 
                                                            data-sistem-id="{{ $subsistem->sistem_id }}"
                                                            {{ old('subsistem', $mainComponent->subsistem) == $subsistem->kod ? 'selected' : '' }}>
                                                            {{ $subsistem->kod }} - {{ $subsistem->nama }}
                                                        </option>
                                                    @endforeach
                                                    @if($mainComponent->subsistem && !$subsistems->contains('kod', $mainComponent->subsistem))
                                                        <option value="{{ $mainComponent->subsistem }}" selected>{{ $mainComponent->subsistem }}</option>
                                                    @endif
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Kuantiti<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="kuantiti" value="{{ old('kuantiti', $mainComponent->kuantiti ?? 1) }}" min="1">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">No. Perolehan (1GFMAS)<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="no_perolehan_1gfmas" value="{{ old('no_perolehan_1gfmas', $mainComponent->no_perolehan_1gfmas) }}"> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bidang Kejuruteraan -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Bidang Kejuruteraan Komponen:</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="awam_arkitek" id="awam" value="1" {{ old('awam_arkitek', $mainComponent->awam_arkitek) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="awam">Awam/Arkitek</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="elektrikal" id="elektrikal" value="1" {{ old('elektrikal', $mainComponent->elektrikal) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="elektrikal">Elektrikal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="elv_ict" id="elv" value="1" {{ old('elv_ict', $mainComponent->elv_ict) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="elv">ELV/ICT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mekanikal" id="mekanikal" value="1" {{ old('mekanikal', $mainComponent->mekanikal) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mekanikal">Mekanikal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="bio_perubatan" id="bio" value="1" {{ old('bio_perubatan', $mainComponent->bio_perubatan) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bio">Bio Perubatan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="lain_lain" placeholder="Lain-lain:" value="{{ old('lain_lain', $mainComponent->lain_lain) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan" rows="2">{{ old('catatan', $mainComponent->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- MAKLUMAT PEROLEHAN -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            MAKLUMAT PEROLEHAN
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="50%">Tarikh Perolehan</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_perolehan" 
                                                value="{{ old('tarikh_perolehan', $mainComponent->tarikh_perolehan ? \Carbon\Carbon::parse($mainComponent->tarikh_perolehan)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kos Perolehan/Kontrak (RM)</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ old('kos_perolehan', $mainComponent->kos_perolehan) }}" placeholder="contoh: 20000.00"></td>
                                        </tr>
                                        <tr>
                                            <td>No. Pesanan Rasmi Kerajaan/Kontrak</td>
                                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ old('no_pesanan_rasmi_kontrak', $mainComponent->no_pesanan_rasmi_kontrak) }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kod PTJ</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ old('kod_ptj', $mainComponent->kod_ptj) }}"></td> 
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Tarikh Dipasang</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" 
                                                value="{{ old('tarikh_dipasang', $mainComponent->tarikh_dipasang ? \Carbon\Carbon::parse($mainComponent->tarikh_dipasang)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Waranti Tamat</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" 
                                                value="{{ old('tarikh_waranti_tamat', $mainComponent->tarikh_waranti_tamat ? \Carbon\Carbon::parse($mainComponent->tarikh_waranti_tamat)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Tamat DLP</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_tamat_dlp" 
                                                value="{{ old('tarikh_tamat_dlp', $mainComponent->tarikh_tamat_dlp ? \Carbon\Carbon::parse($mainComponent->tarikh_tamat_dlp)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jangka Hayat</td>
                                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ old('jangka_hayat', $mainComponent->jangka_hayat) }}" placeholder="Tahun"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Pengilang, Pembekal, Kontraktor -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pengilang</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pengilang" value="{{ old('nama_pengilang', $mainComponent->nama_pengilang) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pembekal</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pembekal" value="{{ old('nama_pembekal', $mainComponent->nama_pembekal) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_pembekal" rows="2">{{ old('alamat_pembekal', $mainComponent->alamat_pembekal) }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal" value="{{ old('no_telefon_pembekal', $mainComponent->no_telefon_pembekal) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Kontraktor</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_kontraktor" value="{{ old('nama_kontraktor', $mainComponent->nama_kontraktor) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_kontraktor" rows="2">{{ old('alamat_kontraktor', $mainComponent->alamat_kontraktor) }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor" value="{{ old('no_telefon_kontraktor', $mainComponent->no_telefon_kontraktor) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan_maklumat" rows="2">{{ old('catatan_maklumat', $mainComponent->catatan_maklumat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- MAKLUMAT KOMPONEN -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            MAKLUMAT KOMPONEN
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $mainComponent->deskripsi) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">Status Komponen<span class="text-danger">*</span></label>
                                        <select class="form-select" name="status_komponen">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="operational" {{ old('status_komponen', $mainComponent->status_komponen) == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                            <option value="under_maintenance" {{ old('status_komponen', $mainComponent->status_komponen) == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                            <option value="rosak" {{ old('status_komponen', $mainComponent->status_komponen) == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="retired" {{ old('status_komponen', $mainComponent->status_komponen) == 'retired' ? 'selected' : '' }}>Dilupuskan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenama" value="{{ old('jenama', $mainComponent->jenama) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Model<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model', $mainComponent->model) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Siri<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri', $mainComponent->no_siri) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">No. Tag / Label</label>
                                    <input type="text" class="form-control" name="no_tag_label" value="{{ old('no_tag_label', $mainComponent->no_tag_label) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Sijil Pendaftaran</label>
                                    <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran', $mainComponent->no_sijil_pendaftaran) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button to show attributes section -->
                    <div class="d-flex justify-content-between" id="mainButtons">
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-info text-white" onclick="showAttributesSection()">
                            Seterusnya: Atribut Spesifikasi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Hidden section for attributes -->
                    <div id="attributesSection" style="display: none;">
                        @include('components.partials.main-component-attributes')
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAttributesSection() {
    document.getElementById('attributesSection').style.display = 'block';
    document.getElementById('mainButtons').style.display = 'none';
    document.getElementById('attributesSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // ===========================
    // Initialize Select2 untuk Sistem
    // ===========================
    $('.select2-sistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Cari atau taip sistem baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return { id: term, text: term + ' ✓ (Baru)', newTag: true };
        }
    });

    // ===========================
    // Initialize Select2 untuk SubSistem
    // ===========================
    $('.select2-subsistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Cari atau taip subsistem baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return { id: term, text: term + ' ✓ (Baru)', newTag: true };
        }
    });

    // ===========================
    // Filter SubSistem berdasarkan Sistem yang dipilih
    // ===========================
    $('#sistem').on('change', function() {
        var sistemId = $(this).find(':selected').data('id');
        var $subsistem = $('#subsistem');
        
        if (sistemId) {
            $subsistem.find('option').each(function() {
                var optionSistemId = $(this).data('sistem-id');
                $(this).toggle(!optionSistemId || optionSistemId == sistemId);
            });
        } else {
            $subsistem.find('option').show();
        }
        $subsistem.val('').trigger('change');
    });

    // ===========================
    // Auto-fill DPA
    // ===========================
    $('#component_id').on('change', function() {
        var $selected = $(this).find(':selected');
        $('#display_dpa').val($selected.data('dpa') || '');
    });

    // ===========================
    // FORMAT KOS PEROLEHAN
    // ===========================
    
    // Format initial value on page load
    var kosInput = $('input[name="kos_perolehan"]');
    var initialValue = kosInput.val();
    if (initialValue) {
        // Remove RM prefix and any formatting
        var cleanValue = initialValue.replace(/RM\s*/g, '').replace(/,/g, '').trim();
        var number = parseFloat(cleanValue);
        
        if (!isNaN(number)) {
            // Display with formatting
            var formatted = number.toLocaleString('en-MY', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            kosInput.val('RM ' + formatted);
        }
    }

    // Format input kos perolehan - hanya angka dan titik
    kosInput.on('input', function() {
        let value = $(this).val();
        
        // Remove non-numeric characters except dots
        value = value.replace(/[^0-9.]/g, '');
        
        // Remove multiple dots
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        $(this).val(value);
    });

    // Format dengan comma separator dan RM prefix ketika blur
    kosInput.on('blur', function() {
        let value = $(this).val();
        
        if (value) {
            // Remove any existing RM and spaces
            value = value.replace(/RM\s*/g, '').trim();
            
            // Parse as number
            let number = parseFloat(value);
            
            if (!isNaN(number)) {
                // Format dengan 2 decimal places dan thousand separator
                let formatted = number.toLocaleString('en-MY', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                
                $(this).val(formatted);

            }
        }
    });

    // Remove formatting ketika focus untuk mudah edit
    kosInput.on('focus', function() {
        let value = $(this).val();
        if (value) {
            // Remove RM prefix and commas
            value = value.replace(/RM\s*/g, '').replace(/,/g, '');
            $(this).val(value);
        }
    });

    // ===========================
    // FORM SUBMIT - Clean format untuk database
    // ===========================
    $('#mainComponentForm').on('submit', function(e) {
        let kosInput = $('input[name="kos_perolehan"]');
        let value = kosInput.val();
        
        if (value) {
            // Clean value untuk database: RM20000.00
            value = value.replace(/RM\s*/g, '').replace(/,/g, '');
            let number = parseFloat(value);
            
            if (!isNaN(number)) {
                // Format: RM20000.00 (no comma, with RM prefix)
                kosInput.val('RM' + number.toFixed(2));
            }
        }
    });
});
</script>
@endsection