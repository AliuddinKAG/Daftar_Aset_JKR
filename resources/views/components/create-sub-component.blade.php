@extends('layouts.app')

@section('title', 'Borang 3: Sub Komponen')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Sub Komponen</small>
            </div>
            <div class="card-body">
                <form action="{{ route('sub-components.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- MAKLUMAT SUB KOMPONEN -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            MAKLUMAT SUB KOMPONEN
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Komponen Utama <span class="text-danger">*</span></label>
                                    <select class="form-select @error('main_component_id') is-invalid @enderror" 
                                            name="main_component_id" id="mainComponentSelect" required>
                                        <option value="">-- Pilih Komponen Utama --</option>
                                        @foreach($mainComponents as $mainComp)
                                            <option value="{{ $mainComp->id }}" 
                                                    data-komponen="{{ $mainComp->component->nama_premis }}"
                                                    {{ old('main_component_id') == $mainComp->id ? 'selected' : '' }}>
                                                {{ $mainComp->nama_komponen_utama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('main_component_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Id Komponen Utama</label>
                                    <input type="text" class="form-control" id="displayKomponen" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kod Lokasi</label>
                                    <input type="text" class="form-control" id="displayKodLokasi" readonly>
                                </div>
                            </div>

                            <div class="card mb-3" style="background: #f8f9fa;">
                                <div class="card-header bg-dark text-white">
                                    <strong>Maklumat Sub Komponen</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Sub Komponen <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_sub_komponen') is-invalid @enderror" 
                                               name="nama_sub_komponen" value="{{ old('nama_sub_komponen') }}" required>
                                        @error('nama_sub_komponen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Status Komponen <span class="text-danger">*</span></label>
                                            <select class="form-select" name="status_komponen">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="operational" {{ old('status_komponen') == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                                <option value="under_maintenance" {{ old('status_komponen') == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                                <option value="rosak" {{ old('status_komponen') == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. Siri <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri') }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">No. Sijil Pendaftaran (Jika ada) </label>
                                            <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="jenama" value="{{ old('jenama') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Model<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kuantiti (Sama Jenis) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="kuantiti" value="{{ old('kuantiti', 1) }}" min="1">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan:</label>
                                        <textarea class="form-control" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button untuk next section -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-info text-white" onclick="showSpecificationSection()">
                            Seterusnya: Atribut Spesifikasi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Hidden section for specifications -->
                    <div id="specificationSection" style="display: none;">
                        @include('components.partials.sub-component-specifications')
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    // ===========================
    // Auto-fill komponen name dan kod lokasi
    // ===========================
    $('#mainComponentSelect').on('change', function() {
        const selected = this.options[this.selectedIndex];
        const komponenName = selected.getAttribute('data-komponen');
        const kodLokasi = selected.getAttribute('data-kod-lokasi');
        
        // Set nama komponen
        $('#displayKomponen').val(komponenName || '');
        
        // Set kod lokasi
        if (kodLokasi) {
            $('#displayKodLokasi').val(kodLokasi);
        } else {
            // Generate kod lokasi jika tidak ada
            const mainCompId = $(this).val();
            if (mainCompId) {
                $('#displayKodLokasi').val('LOK-' + mainCompId.padStart(4, '0'));
            } else {
                $('#displayKodLokasi').val('');
            }
        }
    });

    // Trigger on page load jika ada value (untuk validation error)
    if ($('#mainComponentSelect').val()) {
        $('#mainComponentSelect').trigger('change');
    }
});

function showSpecificationSection() {
    document.getElementById('specificationSection').style.display = 'block';
    document.querySelector('button[onclick="showSpecificationSection()"]').style.display = 'none';
    document.getElementById('specificationSection').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection