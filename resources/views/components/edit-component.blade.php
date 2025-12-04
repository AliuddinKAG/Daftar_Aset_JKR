@extends('layouts.app')

@section('title', 'Edit Komponen')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
}
.input-group-text {
    background-color: #e9ecef;
}
/* Highlight untuk tag baru */
.select2-results__option .badge {
    font-size: 0.875rem;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">EDIT BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                        <small class="text-white">Peringkat Komponen</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('components.update', $component) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                           name="nama_premis" value="{{ old('nama_premis', $component->nama_premis) }}" 
                                           placeholder="Contoh: PARLIMEN MALAYSIA" required>
                                    @error('nama_premis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombor DPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombor_dpa') is-invalid @enderror" 
                                           name="nombor_dpa" value="{{ old('nombor_dpa', $component->nombor_dpa) }}" 
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
                                       id="ada_blok" value="1" {{ old('ada_blok', $component->ada_blok) ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold ms-2" for="ada_blok" style="cursor: pointer; font-size: 1rem;">
                                    Blok (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="blok_section" style="display: {{ old('ada_blok', $component->ada_blok) ? 'block' : 'none' }};">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-center">Maklumat Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">Kod Blok</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-blok" name="kod_blok" id="kod_blok">
                                                    <option value="">-- Pilih atau Taip Kod Blok --</option>
                                                    @foreach($kodBloks as $blok)
                                                        <option value="{{ $blok->kod }}" {{ old('kod_blok', $component->kod_blok) == $blok->kod ? 'selected' : '' }}>
                                                            {{ $blok->kod }} - {{ $blok->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kod Aras</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras" name="kod_aras" id="kod_aras">
                                                    <option value="">-- Pilih atau Taip Kod Aras --</option>
                                                    @foreach($kodAras as $aras)
                                                        <option value="{{ $aras->kod }}" {{ old('kod_aras', $component->kod_aras) == $aras->kod ? 'selected' : '' }}>
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
                                                        <option value="{{ $ruang->kod }}" {{ old('kod_ruang', $component->kod_ruang) == $ruang->kod ? 'selected' : '' }}>
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
                                                        <option value="{{ $nama->nama }}" {{ old('nama_ruang', $component->nama_ruang) == $nama->nama ? 'selected' : '' }}>
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
                                        <td><textarea class="form-control" name="catatan_blok" rows="3">{{ old('catatan_blok', $component->catatan_blok) }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Binaan Luar Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ada_binaan_luar" 
                                       id="ada_binaan_luar" value="1" {{ old('ada_binaan_luar', $component->ada_binaan_luar) ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold" for="ada_binaan_luar">
                                    Binaan Luar (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="binaan_section" style="display: {{ old('ada_binaan_luar', $component->ada_binaan_luar) ? 'block' : 'none' }};">
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
                                                   value="{{ old('nama_binaan_luar', $component->nama_binaan_luar) }}" 
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
                                                            <option value="{{ $binaan->kod }}" {{ old('kod_binaan_luar', $component->kod_binaan_luar) == $binaan->kod ? 'selected' : '' }}>
                                                                {{ $binaan->kod }} - {{ $binaan->nama }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Koordinat GPS (WGS 84)</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_x" 
                                                           value="{{ old('koordinat_x', $component->koordinat_x) }}" placeholder="X: ( Cth 2.935905 )">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_y" 
                                                           value="{{ old('koordinat_y', $component->koordinat_y) }}" placeholder="Y: ( Cth 101.700286)">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="fw-bold">Diisi Jika Binaan Luar Mempunyai Aras dan Ruang</td>
                                    </tr>
                                    <tr>
                                        <td>Kod Aras</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras-binaan" name="kod_aras_binaan" id="kod_aras_binaan">
                                                    <option value="">-- Pilih atau Taip Kod Aras --</option>
                                                    @foreach($kodAras as $aras)
                                                        <option value="{{ $aras->kod }}" {{ old('kod_aras_binaan', $component->kod_aras_binaan) == $aras->kod ? 'selected' : '' }}>
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
                                                <select class="form-select select2-ruang-binaan" name="kod_ruang_binaan" id="kod_ruang_binaan">
                                                    <option value="">-- Pilih atau Taip Kod Ruang --</option>
                                                    @foreach($kodRuangs as $ruang)
                                                        <option value="{{ $ruang->kod }}" {{ old('kod_ruang_binaan', $component->kod_ruang_binaan) == $ruang->kod ? 'selected' : '' }}>
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
                                                <select class="form-select select2-nama-ruang-binaan" name="nama_ruang_binaan" id="nama_ruang_binaan">
                                                    <option value="">-- Pilih atau Taip Nama Ruang --</option>
                                                    @foreach($namaRuangs as $nama)
                                                        <option value="{{ $nama->nama }}" {{ old('nama_ruang_binaan', $component->nama_ruang_binaan) == $nama->nama ? 'selected' : '' }}>
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
                                        <td><textarea class="form-control" name="catatan_binaan" rows="3">{{ old('catatan_binaan', $component->catatan_binaan) }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="aktif" {{ old('status', $component->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status', $component->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Kemaskini Komponen
                        </button>
                        <a href="{{ route('components.show', $component) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
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
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 dengan clear button dan delete capability
    $('.select2-blok, .select2-aras, .select2-ruang, .select2-nama-ruang, .select2-binaan-luar, .select2-aras-binaan, .select2-ruang-binaan, .select2-nama-ruang-binaan').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Cari atau taip nilai baru',
        allowClear: true,  // Enable butang X untuk clear selection
        createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term + ' ✓ (Baru)',
                newTag: true
            }
        },
        // Highlight tag baru dengan warna berbeza
        templateResult: function(data) {
            if (data.newTag) {
                return $('<span class="badge bg-success">' + data.text + '</span>');
            }
            return data.text;
        }
    });

    // Event untuk buang option yang salah taip
    $('.select2-blok, .select2-aras, .select2-ruang, .select2-nama-ruang, .select2-binaan-luar, .select2-aras-binaan, .select2-ruang-binaan, .select2-nama-ruang-binaan').on('select2:unselecting', function(e) {
        var data = e.params.args.data;
        
        // Jika option adalah tag baru yang user taip sendiri
        if (data.newTag) {
            // Optional: uncomment jika nak confirmation dialog
            // if (!confirm('Buang "' + data.text + '"?')) {
            //     e.preventDefault();
            //     return;
            // }
            
            // Auto remove option dari dropdown
            var $select = $(this);
            setTimeout(function() {
                $select.find('option[value="' + data.id + '"]').remove();
            }, 100);
        }
    });

    // Event bila clear semua (klik X button)
    $('.select2-blok, .select2-aras, .select2-ruang, .select2-nama-ruang, .select2-binaan-luar, .select2-aras-binaan, .select2-ruang-binaan, .select2-nama-ruang-binaan').on('select2:clear', function() {
        var $select = $(this);
        // Optional: Buang semua tag baru bila clear
        $select.find('option').each(function() {
            var $option = $(this);
            // Check jika option ni bukan dari database (tag baru)
            if ($option.val() && !$option.data('original')) {
                // Uncomment line ini jika nak buang tag baru bila clear
                // $option.remove();
            }
        });
    });

    // Mark original options (dari database)
    $('.select2-blok option, .select2-aras option, .select2-ruang option, .select2-nama-ruang option, .select2-binaan-luar option, .select2-aras-binaan option, .select2-ruang-binaan option, .select2-nama-ruang-binaan option').each(function() {
        if ($(this).val()) {
            $(this).data('original', true);
        }
    });

    // Toggle Blok Section
    $('#ada_blok').on('change', function() {
        if ($(this).is(':checked')) {
            $('#blok_section').slideDown(300);
        } else {
            $('#blok_section').slideUp(300);
        }
    });

    // Toggle Binaan Luar Section
    $('#ada_binaan_luar').on('change', function() {
        if ($(this).is(':checked')) {
            $('#binaan_section').slideDown(300);
        } else {
            $('#binaan_section').slideUp(300);
        }
    });

    // Check on page load
    if ($('#ada_blok').is(':checked')) {
        $('#blok_section').show();
    }
    if ($('#ada_binaan_luar').is(':checked')) {
        $('#binaan_section').show();
    }

    // Tambah CSS untuk highlight new tags
    $('<style>')
        .text('.select2-results__option--highlighted .badge { background-color: #198754 !important; color: white !important; }')
        .appendTo('head');
});
</script>
@endsection