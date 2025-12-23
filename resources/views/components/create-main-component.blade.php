@extends('layouts.app')

@section('title', 'Borang 2: Komponen Utama')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Utama</small>
            </div>
            <div class="card-body">
                <form action="{{ route('main-components.store') }}" method="POST" enctype="multipart/form-data" id="mainComponentForm">
                    @csrf

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
                                                data-nama="{{ $component->nama_premis }}"
                                                {{ old('component_id') == $component->id ? 'selected' : '' }}>
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
                                    <input type="text" class="form-control bg-light" id="display_dpa" readonly placeholder="Auto-fill dari komponen">
                                    <small class="text-muted">Auto-fill berdasarkan komponen dipilih</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kod Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                    class="form-control @error('kod_lokasi') is-invalid @enderror" 
                                    name="kod_lokasi" 
                                    id="kod_lokasi"
                                    value="{{ old('kod_lokasi') }}" 
                                    placeholder="Contoh: KU-01-123"
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
                                               name="nama_komponen_utama" value="{{ old('nama_komponen_utama') }}" required>
                                        @error('nama_komponen_utama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                   

                                    <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            Sistem
                                            <span class="text-danger">*</span>
                                            <span id="kod-sistem-status" class="ms-2"></span>
                                        </label>
                                        <div class="input-group">
                                            <select class="form-select select2-sistem" name="sistem" id="sistem">
                                                <option value="">-- Pilih atau Taip Sistem --</option>
                                                @foreach($sistems as $sistem)
                                                    <option value="{{ $sistem->kod }}" 
                                                        data-id="{{ $sistem->id }}"
                                                        {{ old('sistem') == $sistem->kod ? 'selected' : '' }}>
                                                        {{ $sistem->kod }} - {{ $sistem->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            SubSistem
                                            <span class="text-danger">*</span>
                                            <span id="kod-subsistem-status" class="ms-2"></span>
                                        </label>
                                        <div class="input-group">
                                            <select class="form-select select2-subsistem" name="subsistem" id="subsistem">
                                                <option value="">-- Pilih atau Taip SubSistem --</option>
                                                @foreach($subsistems as $subsistem)
                                                    <option value="{{ $subsistem->kod }}" 
                                                        data-sistem-id="{{ $subsistem->sistem_id }}"
                                                        {{ old('subsistem') == $subsistem->kod ? 'selected' : '' }}>
                                                        {{ $subsistem->kod }} - {{ $subsistem->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Kuantiti<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="kuantiti" value="{{ old('kuantiti', 1) }}" min="1">
                                        <small class="form-text text-muted">(Komponen yang sama jenis)</small>
                                    </div>
                                </div>

                                <!-- Hidden row untuk Nama Sistem (auto-populated) -->
                                <div class="row mb-3" id="nama-sistem-row" style="display: none;">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Sistem</label>
                                        <div class="nama-field-wrapper">
                                            <input type="text" class="form-control" id="nama_sistem" name="nama_sistem" 
                                                value="{{ old('nama_sistem') }}"
                                                placeholder="Nama akan dijana automatik atau anda boleh edit">
                                            <span class="autofill-indicator" id="autofill-indicator-sistem" style="display: none;">
                                                <i class="bi bi-magic"></i> Auto
                                            </span>
                                        </div>
                                        <small class="text-success" id="nama-sistem-hint"></small>
                                    </div>
                                </div>

                                <!-- Hidden row untuk Nama SubSistem (auto-populated) -->
                                <div class="row mb-3" id="nama-subsistem-row" style="display: none;">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama SubSistem</label>
                                        <div class="nama-field-wrapper">
                                            <input type="text" class="form-control" id="nama_subsistem" name="nama_subsistem" 
                                                value="{{ old('nama_subsistem') }}"
                                                placeholder="Nama akan dijana automatik atau anda boleh edit">
                                            <span class="autofill-indicator" id="autofill-indicator-subsistem" style="display: none;">
                                                <i class="bi bi-magic"></i> Auto
                                            </span>
                                        </div>
                                        <small class="text-success" id="nama-subsistem-hint"></small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">No. Perolehan (1GFMAS)<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_perolehan_1gfmas" value="{{ old('no_perolehan_1gfmas') }}">
                                    </div>
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
                                                <input class="form-check-input" type="checkbox" name="awam_arkitek" id="awam" value="1" {{ old('awam_arkitek') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="awam">Awam/Arkitek</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="elektrikal" id="elektrikal" value="1" {{ old('elektrikal') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="elektrikal">Elektrikal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="elv_ict" id="elv" value="1" {{ old('elv_ict') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="elv">ELV/ICT</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mekanikal" id="mekanikal" value="1" {{ old('mekanikal') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mekanikal">Mekanikal</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="bio_perubatan" id="bio" value="1" {{ old('bio_perubatan') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bio">Bio Perubatan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="lain_lain" placeholder="Lain-lain:" value="{{ old('lain_lain') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan" rows="2">{{ old('catatan') }}</textarea>
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
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_perolehan" value="{{ old('tarikh_perolehan') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kos Perolehan/Kontrak (RM)</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ old('kos_perolehan') }}" placeholder="contoh: 20000.00"></td>
                                        </tr>
                                        <tr>
                                            <td>No. Pesanan Rasmi Kerajaan/Kontrak</td>
                                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ old('no_pesanan_rasmi_kontrak') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kod PTJ</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ old('kod_ptj') }}"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="50%">Tarikh Dipasang</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" value="{{ old('tarikh_dipasang') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Waranti Tamat</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" value="{{ old('tarikh_waranti_tamat') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Tamat DLP</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_tamat_dlp" value="{{ old('tarikh_tamat_dlp') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Jangka Hayat</td>
                                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ old('jangka_hayat') }}" placeholder="Tahun"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Pengilang, Pembekal, Kontraktor -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pengilang</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pengilang" value="{{ old('nama_pengilang') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pembekal</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pembekal" value="{{ old('nama_pembekal') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_pembekal" rows="2">{{ old('alamat_pembekal') }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal" value="{{ old('no_telefon_pembekal') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Kontraktor</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_kontraktor" value="{{ old('nama_kontraktor') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_kontraktor" rows="2">{{ old('alamat_kontraktor') }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor" value="{{ old('no_telefon_kontraktor') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan_maklumat" rows="2">{{ old('catatan_maklumat') }}</textarea>
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
                                    <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">Status Komponen</label>
                                        <select class="form-select" name="status_komponen">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="operational" {{ old('status_komponen') == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                            <option value="under_maintenance" {{ old('status_komponen') == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                            <option value="rosak" {{ old('status_komponen') == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="retired" {{ old('status_komponen') == 'retired' ? 'selected' : '' }}>Dilupuskan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenama" value="{{ old('jenama') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Model<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Siri<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">No. Tag / Label (Jika berkenaan)</label>
                                    <input type="text" class="form-control" name="no_tag_label" value="{{ old('no_tag_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Sijil Pendaftaran (Jika ada)</label>
                                    <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran') }}">
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
                    <div id="attributesSection" style="display: none; margin-top: 20px;">
                        @include('components.partials.main-component-attributes')
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- Inline script untuk show attributes --}}
<script>
function showAttributesSection() {
    document.getElementById('attributesSection').style.display = 'block';
    document.getElementById('mainButtons').style.display = 'none';
    document.getElementById('attributesSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // CSRF Token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ===========================
    // Initialize Select2 untuk Sistem dengan Tags
    // ===========================
    $('.select2-sistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip kod baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            
            return {
                id: term,
                text: term,
                newTag: true
            }
        },
        templateResult: function(data) {
            if (data.newTag) {
                return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
            }
            return data.text;
        }
    });

    // ===========================
    // Initialize Select2 untuk SubSistem dengan Tags
    // ===========================
    $('.select2-subsistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip kod baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            
            return {
                id: term,
                text: term,
                newTag: true
            }
        },
        templateResult: function(data) {
            if (data.newTag) {
                return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
            }
            return data.text;
        }
    });

    // ===========================
    // AUTOFILL MAGIC - Sistem
    // ===========================
    let typingTimerSistem;
    const doneTypingInterval = 500; // 0.5 second

    $('#sistem').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerSistem);
        
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-sistem-row').hide();
            $('#kod-sistem-status').html('');
            return;
        }

        typingTimerSistem = setTimeout(function() {
            checkKodSistem(kodValue);
        }, doneTypingInterval);
    });

    function checkKodSistem(kod) {
        if (!kod) return;

        // Show loading
        $('#kod-sistem-status').html('<span class="badge bg-secondary">Menyemak...</span>');
        $('#nama-sistem-row').show();
        $('#nama_sistem').prop('readonly', true).val('Menyemak kod...');

        $.ajax({
            url: '/api/check-kod-sistem',
            method: 'POST',
            data: { kod: kod },
            success: function(response) {
                if (response.exists) {
                    // Kod already exists
                    $('#kod-sistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama_sistem').val(response.data.nama).prop('readonly', true);
                    $('#nama-sistem-hint').text('✓ Kod ini sudah wujud dalam database');
                    $('#autofill-indicator-sistem').hide();
                } else {
                    // New kod - show suggestion
                    $('#kod-sistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_sistem').val(response.suggestion).prop('readonly', false);
                    $('#nama-sistem-hint').text('💡 Nama disarankan. Anda boleh edit jika perlu.');
                    $('#autofill-indicator-sistem').show();
                }
            },
            error: function() {
                $('#kod-sistem-status').html('<span class="badge bg-danger">Ralat</span>');
                $('#nama_sistem').val('').prop('readonly', false);
                $('#nama-sistem-hint').text('');
            }
        });
    }

    // Allow user to edit auto-filled name for Sistem
    $('#nama_sistem').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-sistem').hide();
    });

    // ===========================
    // AUTOFILL MAGIC - SubSistem
    // ===========================
    let typingTimerSubSistem;

    $('#subsistem').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerSubSistem);
        
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-subsistem-row').hide();
            $('#kod-subsistem-status').html('');
            return;
        }

        typingTimerSubSistem = setTimeout(function() {
            checkKodSubSistem(kodValue);
        }, doneTypingInterval);
    });

    function checkKodSubSistem(kod) {
        if (!kod) return;

        // Get selected sistem_id if available
        var sistemId = $('#sistem').find(':selected').data('id') || null;

        // Show loading
        $('#kod-subsistem-status').html('<span class="badge bg-secondary">Menyemak...</span>');
        $('#nama-subsistem-row').show();
        $('#nama_subsistem').prop('readonly', true).val('Menyemak kod...');

        $.ajax({
            url: '/api/check-kod-subsistem',
            method: 'POST',
            data: { 
                kod: kod,
                sistem_id: sistemId
            },
            success: function(response) {
                if (response.exists) {
                    // Kod already exists
                    $('#kod-subsistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama_subsistem').val(response.data.nama).prop('readonly', true);
                    
                    var hintText = '✓ Kod ini sudah wujud dalam database';
                    if (response.data.sistem_nama) {
                        hintText += ' (Sistem: ' + response.data.sistem_nama + ')';
                    }
                    $('#nama-subsistem-hint').text(hintText);
                    $('#autofill-indicator-subsistem').hide();
                } else {
                    // New kod - show suggestion
                    $('#kod-subsistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_subsistem').val(response.suggestion).prop('readonly', false);
                    $('#nama-subsistem-hint').text('💡 Nama disarankan. Anda boleh edit jika perlu.');
                    $('#autofill-indicator-subsistem').show();
                }
            },
            error: function() {
                $('#kod-subsistem-status').html('<span class="badge bg-danger">Ralat</span>');
                $('#nama_subsistem').val('').prop('readonly', false);
                $('#nama-subsistem-hint').text('');
            }
        });
    }

    // Allow user to edit auto-filled name for SubSistem
    $('#nama_subsistem').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-subsistem').hide();
    });

    // ===========================
    // Filter SubSistem berdasarkan Sistem yang dipilih
    // ===========================
    $('#sistem').on('change', function() {
        var sistemId = $(this).find(':selected').data('id');
        var $subsistem = $('#subsistem');
        
        // Clear subsistem when sistem changes
        if (sistemId) {
            // Filter subsistem options based on sistem_id
            $subsistem.find('option').each(function() {
                var optionSistemId = $(this).data('sistem-id');
                if (optionSistemId && optionSistemId != sistemId) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        } else {
            // Show all options if no sistem selected
            $subsistem.find('option').show();
        }
        
        // Reset subsistem selection and hide nama row
        $subsistem.val('').trigger('change');
        $('#nama-subsistem-row').hide();
        $('#kod-subsistem-status').html('');
    });

    // ===========================
    // Auto-fill DPA sahaja (tanpa kod lokasi)
    // ===========================
    $('#component_id').on('change', function() {
        var $selected = $(this).find(':selected');
        // Hanya auto-fill DPA
        $('#display_dpa').val($selected.data('dpa') || '');
    });
    
    // Trigger on page load if component already selected
    if ($('#component_id').val()) {
        $('#component_id').trigger('change');
    }

    // ===========================
    // FORMAT KOS PEROLEHAN
    // ===========================
    
    // Format input kos perolehan - hanya angka dan titik
    $('input[name="kos_perolehan"]').on('input', function() {
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
    $('input[name="kos_perolehan"]').on('blur', function() {
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
    $('input[name="kos_perolehan"]').on('focus', function() {
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

    // ===========================
    // Check on page load for old values
    // ===========================
    const sistemValue = $('#sistem').val();
    if (sistemValue) {
        checkKodSistem(sistemValue);
    }

    const subsistemValue = $('#subsistem').val();
    if (subsistemValue) {
        checkKodSubSistem(subsistemValue);
    }
});
</script>
@endsection