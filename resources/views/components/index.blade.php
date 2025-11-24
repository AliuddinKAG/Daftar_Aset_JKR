@extends('layouts.app')

@section('title', 'Dashboard Sistem Komponen')

@section('content')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .stats-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0.5rem 0;
    }

    .stats-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s;
        text-decoration: none;
        display: block;
        color: inherit;
    }

    .action-card:hover {
        border-color: #2563eb;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .component-item {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .component-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
    }

    .nested-item {
        border-left: 3px solid #e2e8f0;
        padding: 1rem;
        margin: 0.75rem 0;
        border-radius: 6px;
        background: #f8fafc;
    }

    .nested-item.level-2 {
        border-left-color: #10b981;
    }

    .nested-item.level-3 {
        border-left-color: #06b6d4;
    }

    .info-row {
        display: flex;
        gap: 1rem;
        margin: 0.5rem 0;
        flex-wrap: wrap;
    }

    .info-item {
        font-size: 0.85rem;
    }

    .info-label {
        color: #64748b;
        margin-right: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        color: #1e293b;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .empty-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <h1 class="page-title">Dashboard Sistem</h1>
    <p class="text-muted">Sistem Pengumpulan Data Daftar Aset Khusus</p>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stats-number">{{ $components->count() }}</div>
            <div class="stats-label">Total Komponen</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #d1fae5; color: #10b981;">
                <i class="bi bi-layers"></i>
            </div>
            <div class="stats-number">{{ $components->sum(fn($c) => $c->mainComponents->count()) }}</div>
            <div class="stats-label">Komponen Utama</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #cffafe; color: #06b6d4;">
                <i class="bi bi-diagram-3"></i>
            </div>
            <div class="stats-number">{{ $components->sum(fn($c) => $c->mainComponents->sum(fn($m) => $m->subComponents->count())) }}</div>
            <div class="stats-label">Sub Komponen</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="{{ route('components.create') }}" class="action-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #dbeafe; color: #2563eb; width: 56px; height: 56px;">
                    <i class="bi bi-plus-lg"></i>
                </div>
                <div>
                    <h6 class="mb-0">Borang 1</h6>
                    <small class="text-muted">Tambah Komponen</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('main-components.create') }}" class="action-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #d1fae5; color: #10b981; width: 56px; height: 56px;">
                    <i class="bi bi-plus-lg"></i>
                </div>
                <div>
                    <h6 class="mb-0">Borang 2</h6>
                    <small class="text-muted">Tambah Komponen Utama</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('sub-components.create') }}" class="action-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: #cffafe; color: #06b6d4; width: 56px; height: 56px;">
                    <i class="bi bi-plus-lg"></i>
                </div>
                <div>
                    <h6 class="mb-0">Borang 3</h6>
                    <small class="text-muted">Tambah Sub Komponen</small>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Components List -->
@forelse($components as $component)
<div class="component-item">
    <div class="component-header">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <div class="mb-2">
                    <span class="badge bg-primary">Komponen</span>
                    <span class="badge {{ $component->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $component->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <h5 class="mb-2">{{ $component->nama_premis }}</h5>
                <div class="text-muted small">
                    <i class="bi bi-hash"></i> {{ $component->nombor_dpa }}
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('components.edit', $component) }}" class="btn btn-light btn-icon">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('components.delete', $component) }}" method="POST" 
                      onsubmit="return confirm('Padam komponen ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-icon">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Location Info -->
        @if($component->ada_blok || $component->ada_binaan_luar)
        <div class="info-row mb-3">
            @if($component->kod_blok)
            <div class="info-item">
                <span class="info-label"><i class="bi bi-building"></i> Blok:</span>
                <span class="info-value">{{ $component->kod_blok }}</span>
            </div>
            @endif
            @if($component->nama_ruang)
            <div class="info-item">
                <span class="info-label"><i class="bi bi-door-open"></i> Ruang:</span>
                <span class="info-value">{{ $component->nama_ruang }}</span>
            </div>
            @endif
            @if($component->nama_binaan_luar)
            <div class="info-item">
                <span class="info-label"><i class="bi bi-geo-alt"></i> Binaan:</span>
                <span class="info-value">{{ $component->nama_binaan_luar }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Main Components -->
        @if($component->mainComponents->count() > 0)
            <h6 class="text-muted mb-3">
                <i class="bi bi-layers"></i> Komponen Utama ({{ $component->mainComponents->count() }})
            </h6>
            
            @foreach($component->mainComponents as $mainComponent)
                <div class="nested-item level-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <div class="mb-2">
                                <span class="badge bg-success small">Komponen Utama</span>
                                <span class="badge {{ $mainComponent->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} small">
                                    {{ $mainComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <h6 class="mb-1">{{ $mainComponent->nama_komponen_utama }}</h6>
                            @if($mainComponent->jenama || $mainComponent->model)
                            <div class="text-muted small">
                                @if($mainComponent->jenama)
                                    <span><i class="bi bi-tag"></i> {{ $mainComponent->jenama }}</span>
                                @endif
                                @if($mainComponent->model)
                                    <span class="ms-2"><i class="bi bi-box"></i> {{ $mainComponent->model }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('main-components.edit', $mainComponent) }}" class="btn btn-success btn-sm btn-icon">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('main-components.delete', $mainComponent) }}" method="POST"
                                  onsubmit="return confirm('Padam komponen utama ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sub Components -->
                    @if($mainComponent->subComponents->count() > 0)
                        <div class="mt-3 ms-3">
                            <div class="text-muted small mb-2">
                                <i class="bi bi-diagram-3"></i> Sub Komponen ({{ $mainComponent->subComponents->count() }})
                            </div>
                            
                            @foreach($mainComponent->subComponents as $subComponent)
                                <div class="nested-item level-3 mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="mb-1">
                                                <span class="badge bg-info small">Sub Komponen</span>
                                                <span class="badge {{ $subComponent->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} small">
                                                    {{ $subComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </div>
                                            <div class="fw-semibold small">{{ $subComponent->nama_sub_komponen }}</div>
                                            @if($subComponent->jenama || $subComponent->model)
                                            <div class="text-muted small">
                                                @if($subComponent->jenama){{ $subComponent->jenama }}@endif
                                                @if($subComponent->model) · {{ $subComponent->model }}@endif
                                            </div>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sub-components.edit', $subComponent) }}" class="btn btn-info btn-sm btn-icon">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('sub-components.delete', $subComponent) }}" method="POST"
                                                  onsubmit="return confirm('Padam sub komponen ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light mt-3 mb-0 py-2 small">
                            <i class="bi bi-info-circle"></i> Tiada sub komponen. 
                            <a href="{{ route('sub-components.create') }}">Tambah</a>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="alert alert-light mb-0">
                <i class="bi bi-info-circle"></i> Tiada komponen utama. 
                <a href="{{ route('main-components.create') }}">Tambah komponen utama</a>
            </div>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <div class="empty-icon">
        <i class="bi bi-inbox"></i>
    </div>
    <h5>Tiada Data</h5>
    <p class="text-muted mb-3">Belum ada komponen ditambah.</p>
    <a href="{{ route('components.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Komponen
    </a>
</div>
@endforelse

@endsection