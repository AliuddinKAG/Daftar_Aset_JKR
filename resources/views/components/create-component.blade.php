{{-- File: resources/views/components/create-component.blade.php (ENHANCED) --}}

@extends('layouts.app')

@section('title', 'Borang Pengumpulan Data - Peringkat Komponen')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
}
.input-group-text {
    background-color: #e9ecef;
}
.new-tag-badge {
    background: #10b981;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 5px;
}
.existing-tag-badge {
    background: #3b82f6;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 5px;
}
.nama-blok-wrapper {
    position: relative;
}
.nama-blok-wrapper .autofill-indicator {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.875rem;
    color: #10b981;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small class="text-white">Peringkat Komponen</small>
            </div>
            <div class="card-body">
                <form action="{{ route('components.store') }}" method="POST">
                    @csrf

                    <!-- Maklumat Lokasi Komponen -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">MAKLUMAT LOKASI KOMPONEN</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Premis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_premis') is-invalid @enderror" 
                                           name="nama_premis" value="{{ old('nama_premis') }}" 
                                           placeholder="Contoh: PARLIMEN MALAYSIA" required>
                                    @error('nama_premis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombor DPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombor_dpa') is-invalid @enderror" 
                                           name="nombor_dpa" value="{{ old('nombor_dpa') }}" 
                                           placeholder="Contoh: 1610MYS.140144.BD0001" required>
                                    @error('nombor_dpa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blok Section -->
                    <div class="card mb-4">
                        <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ada_blok" 
                                       id="ada_blok" value="1" {{ old('ada_blok') ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold ms-2" for="ada_blok" style="cursor: pointer; font-size: 1rem;">
                                    Blok (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="blok_section" style="display: none;">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-center">Maklumat Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">
                                            Kod Blok
                                            <span id="kod-blok-status" class="ms-2"></span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-blok" name="kod_blok" id="kod_blok">
                                                    <option value="">-- Pilih atau Taip Kod Blok --</option>
                                                    @foreach($kodBloks as $blok)
                                                        <option value="{{ $blok->kod }}" 
                                                            data-nama="{{ $blok->nama }}"
                                                            {{ old('kod_blok') == $blok->kod ? 'selected' : '' }}>
                                                            {{ $blok->kod }} - {{ $blok->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                            <small class="text-muted">Taip kod baru untuk tambah (contoh: B01, UTARA, ADMIN)</small>
                                        </td>
                                    </tr>
                                    <tr id="nama-blok-row" style="display: none;">
                                        <td>Nama Blok</td>
                                        <td>
                                            <div class="nama-blok-wrapper">
                                                <input type="text" class="form-control" id="nama_blok" name="nama_blok" 
                                                       placeholder="Nama akan dijana automatik atau anda boleh edit">
                                                <span class="autofill-indicator" id="autofill-indicator" style="display: none;">
                                                    <i class="bi bi-magic"></i> Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-blok-hint"></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kod Aras</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras" name="kod_aras" id="kod_aras">
                                                    <option value="">-- Pilih atau Taip Kod Aras --</option>
                                                    @foreach($kodAras as $aras)
                                                        <option value="{{ $aras->kod }}" {{ old('kod_aras') == $aras->kod ? 'selected' : '' }}>
                                                            {{ $aras->kod }} - {{ $aras->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kod Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-ruang" name="kod_ruang" id="kod_ruang">
                                                    <option value="">-- Pilih atau Taip Kod Ruang --</option>
                                                    @foreach($kodRuangs as $ruang)
                                                        <option value="{{ $ruang->kod }}" {{ old('kod_ruang') == $ruang->kod ? 'selected' : '' }}>
                                                            {{ $ruang->kod }} - {{ $ruang->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-nama-ruang" name="nama_ruang" id="nama_ruang">
                                                    <option value="">-- Pilih atau Taip Nama Ruang --</option>
                                                    @foreach($namaRuangs as $nama)
                                                        <option value="{{ $nama->nama }}" {{ old('nama_ruang') == $nama->nama ? 'selected' : '' }}>
                                                            {{ $nama->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Catatan:</td>
                                        <td><textarea class="form-control" name="catatan_blok" rows="3">{{ old('catatan_blok') }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Binaan Luar Section (sama seperti sebelum) -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ada_binaan_luar" 
                                       id="ada_binaan_luar" value="1" {{ old('ada_binaan_luar') ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold" for="ada_binaan_luar">
                                    Binaan Luar (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="binaan_section" style="display: none;">
                            {{-- Binaan luar content sama seperti original --}}
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-center">Maklumat Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">Nama Binaan Luar</td>
                                        <td><input type="text" class="form-control" name="nama_binaan_luar" 
                                                   value="{{ old('nama_binaan_luar') }}" 
                                                   placeholder="Contoh: Kolam Renang A"></td>
                                    </tr>
                                    <tr>
                                        <td>Kod Binaan Luar</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-binaan-luar" name="kod_binaan_luar" id="kod_binaan_luar">
                                                    <option value="">-- Pilih atau Taip Kod Binaan Luar --</option>
                                                    @if(isset($kodBinaanLuar))
                                                        @foreach($kodBinaanLuar as $binaan)
                                                            <option value="{{ $binaan->kod }}" {{ old('kod_binaan_luar') == $binaan->kod ? 'selected' : '' }}>
                                                                {{ $binaan->kod }} - {{ $binaan->nama }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Rest of binaan luar fields... --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Komponen
                        </button>
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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

    // Initialize Select2 dengan tags support
    $('.select2-blok').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip kod baru',
        allowClear: true,
        createTag: function (params) {
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

    // Initialize other Select2 dropdowns
    $('.select2-aras, .select2-ruang, .select2-nama-ruang, .select2-binaan-luar').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip nilai baru',
        allowClear: true,
        createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return {
                id: term,
                text: term + ' (Baru)',
                newTag: true
            }
        }
    });

    // ========================================
    // AUTOFILL MAGIC - Kod Blok
    // ========================================
    let typingTimer;
    const doneTypingInterval = 500; // 0.5 second

    $('#kod_blok').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimer);
        
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-blok-row').hide();
            $('#kod-blok-status').html('');
            return;
        }

        typingTimer = setTimeout(function() {
            checkKodBlok(kodValue);
        }, doneTypingInterval);
    });

    function checkKodBlok(kod) {
        if (!kod) return;

        // Show loading
        $('#kod-blok-status').html('<span class="badge bg-secondary">Menyemak...</span>');
        $('#nama-blok-row').show();
        $('#nama_blok').prop('readonly', true).val('Menyemak kod...');

        $.ajax({
            url: '{{ route("api.check-kod-blok") }}',
            method: 'POST',
            data: { kod: kod },
            success: function(response) {
                if (response.exists) {
                    // Kod already exists
                    $('#kod-blok-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama_blok').val(response.data.nama).prop('readonly', true);
                    $('#nama-blok-hint').text('✓ Kod ini sudah wujud dalam database');
                    $('#autofill-indicator').hide();
                } else {
                    // New kod - show suggestion
                    $('#kod-blok-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_blok').val(response.suggestion).prop('readonly', false);
                    $('#nama-blok-hint').text('💡 Nama disarankan. Anda boleh edit jika perlu.');
                    $('#autofill-indicator').show();
                }
            },
            error: function() {
                $('#kod-blok-status').html('<span class="badge bg-danger">Ralat</span>');
                $('#nama_blok').val('').prop('readonly', false);
                $('#nama-blok-hint').text('');
            }
        });
    }

    // Allow user to edit auto-filled name
    $('#nama_blok').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator').hide();
    });

    // Toggle sections
    $('#ada_blok').on('change', function() {
        $('#blok_section').slideToggle(300);
    });

    $('#ada_binaan_luar').on('change', function() {
        $('#binaan_section').slideToggle(300);
    });

    // Check on page load
    if ($('#ada_blok').is(':checked')) {
        $('#blok_section').show();
        const kodBlokValue = $('#kod_blok').val();
        if (kodBlokValue) {
            checkKodBlok(kodBlokValue);
        }
    }
    
    if ($('#ada_binaan_luar').is(':checked')) {
        $('#binaan_section').show();
    }
});
</script>
@endsection