@extends('layouts.app')

@section('title', 'Edit Komponen')

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
                    <!-- Quick Export Dropdown
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-download"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('export.component.pdf', $component) }}" target="_blank">
                                <i class="bi bi-file-pdf text-danger"></i> PDF
                            </a></li> -->
                            <!--<li><a class="dropdown-item" href="{{ route('export.component.excel', $component) }}">
                                <i class="bi bi-file-excel text-success"></i> Excel
                            </a></li> -->
                        </ul>
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
                                    <!-- Kod Blok -->
                                    <tr>
                                    <td width="30%">Kod Blok</td>
                                    <td>
                                        <div class="input-group">
                                                <select class="form-select select2-blok" name="kod_blok" id="kod_blok">
                                            <option value="">-- Pilih Kod Blok --</option>
                                                @foreach($kodBloks as $blok)
                                            <option value="{{ $blok->kod }}"
                                                {{ old('kod_blok', $component->kod_blok) == $blok->kod ? 'selected' : '' }}>
                                                {{ $blok->kod }} - {{ $blok->nama }}
                                            </option>
                                                @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>

                                        <!-- Kod Aras -->
                                    <tr>
                                        <td>Kod Aras</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras" name="kod_aras" id="kod_aras">
                                            <option value="">-- Pilih Kod Aras --</option>
                                                @foreach($kodAras as $aras)
                                            <option value="{{ $aras->kod }}"
                                                {{ old('kod_aras', $component->kod_aras) == $aras->kod ? 'selected' : '' }}>
                                                {{ $aras->kod }} - {{ $aras->nama }}
                                            </option>
                                                @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>

                                        <!-- Kod Ruang -->
                                    <tr>
                                        <td>Kod Ruang</td>
                                            <td>
                                            <div class="input-group">
                                                <select class="form-select select2-ruang" name="kod_ruang" id="kod_ruang">
                                            <option value="">-- Pilih Kod Ruang --</option>
                                                @foreach($kodRuangs as $ruang)
                                            <option value="{{ $ruang->kod }}"
                                                {{ old('kod_ruang', $component->kod_ruang) == $ruang->kod ? 'selected' : '' }}>
                                                {{ $ruang->kod }} - {{ $ruang->nama }}
                                            </option>
                                                @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>

                                            <!-- Nama Ruang -->
                                    <tr>
                                        <td>Nama Ruang</td>
                                            <td>
                                            <div class="input-group">
                                                <select class="form-select select2-nama-ruang" name="nama_ruang" id="nama_ruang">
                                            <option value="">-- Pilih Nama Ruang --</option>
                                                @foreach($namaRuangs as $nama)
                                            <option value="{{ $nama->nama }}"
                                                {{ old('nama_ruang', $component->nama_ruang) == $nama->nama ? 'selected' : '' }}>
                                                {{ $nama->nama }}
                                            </option>
                                                @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>

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
                                       id="ada_binaan_luar" value="1" {{ old('ada_binaan_luar', $component->ada_binaan_luar) ? 'checked' : '' }}>
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
                                                   value="{{ old('nama_binaan_luar', $component->nama_binaan_luar) }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Kod Binaan Luar</td>
                                        <td><input type="text" class="form-control" name="kod_binaan_luar" 
                                                   value="{{ old('kod_binaan_luar', $component->kod_binaan_luar) }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Koordinat GPS (WGS 84)</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_x" 
                                                           value="{{ old('koordinat_x', $component->koordinat_x) }}" placeholder="X: ( Cth X: 2.935905 )">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_y" 
                                                           value="{{ old('koordinat_y', $component->koordinat_y) }}" placeholder="Y: ( Cth Y: 101.700286)">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="fw-bold">Diisi Jika Binaan Luar Mempunyai Aras dan Ruang</td>
                                    </tr>
                                    <tr>
                                        <td>Kod Aras</td>
                                        <td><input type="text" class="form-control" name="kod_aras_binaan" 
                                                   value="{{ old('kod_aras_binaan', $component->kod_aras_binaan) }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Kod Ruang</td>
                                        <td><input type="text" class="form-control" name="kod_ruang_binaan" 
                                                   value="{{ old('kod_ruang_binaan', $component->kod_ruang_binaan) }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ruang</td>
                                        <td><input type="text" class="form-control" name="nama_ruang_binaan" 
                                                   value="{{ old('nama_ruang_binaan', $component->nama_ruang_binaan) }}"></td>
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
<script>
    // Toggle Blok Section
    document.getElementById('ada_blok').addEventListener('change', function() {
        document.getElementById('blok_section').style.display = this.checked ? 'block' : 'none';
    });

    // Toggle Binaan Luar Section
    document.getElementById('ada_binaan_luar').addEventListener('change', function() {
        document.getElementById('binaan_section').style.display = this.checked ? 'block' : 'none';
    });

    // Check on page load if already checked (for validation errors)
    if (document.getElementById('ada_blok').checked) {
        document.getElementById('blok_section').style.display = 'block';
    }
    if (document.getElementById('ada_binaan_luar').checked) {
        document.getElementById('binaan_section').style.display = 'block';
    }
</script>
@endsection