@extends('layouts.app')

@section('title', 'Edit Subsistem')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Edit Subsistem</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sistem.index') }}">Sistem</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sistem.subsistems', $sistem) }}">{{ $sistem->kod }}</a></li>
                        <li class="breadcrumb-item active">Edit Subsistem</li>
                    </ol>
                </nav>
            </div>

            <!-- Sistem Info Card -->
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle fs-4 me-3"></i>
                    <div>
                        <strong>Sistem:</strong> {{ $sistem->kod }} - {{ $sistem->nama }}
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.sistem.subsistems.update', [$sistem, $subsistem]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Subsistem</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Kod -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod Subsistem <span class="text-danger">*</span></label>
                                <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror" 
                                       value="{{ old('kod', $subsistem->kod) }}" required placeholder="Contoh: {{ $sistem->kod }}-01">
                                <small class="text-muted">Kod unik untuk subsistem. Contoh: {{ $sistem->kod }}-01, {{ $sistem->kod }}-02</small>
                                @error('kod')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                           {{ old('is_active', $subsistem->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Subsistem <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $subsistem->nama) }}" required placeholder="Contoh: Chiller Plant System">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="4" placeholder="Masukkan keterangan subsistem (opsional)">{{ old('keterangan', $subsistem->keterangan) }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Kemaskini Subsistem
                    </button>
                    <a href="{{ route('admin.sistem.subsistems', $sistem) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
