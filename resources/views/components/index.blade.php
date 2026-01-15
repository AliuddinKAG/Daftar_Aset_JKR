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

    .table-container {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }

    .data-table {
        margin-bottom: 0;
    }

    .data-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem;
    }

    .data-table tbody tr {
        transition: background-color 0.15s;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .data-table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .expand-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 1.1rem;
        padding: 0.25rem 0.5rem;
        transition: transform 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 4px;
    }

    .expand-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .expand-btn.expanded {
        transform: rotate(90deg);
    }

    .nested-row {
        display: none;
        background: #f8fafc;
    }

    .nested-row.show {
        display: table-row;
    }

    .nested-row td {
        padding: 0 !important;
        border: none;
    }

    .nested-table {
        width: 100%;
        margin: 0;
        background: #f8fafc;
    }

    .nested-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        background: white;
    }

    .nested-table.level-2 td {
        padding-left: 3rem;
        background: #fefefe;
    }

    .nested-table.level-3 td {
        padding-left: 5rem;
        background: #f9fafb;
    }

    .row-level-2 {
        border-left: 3px solid #10b981;
    }

    .row-level-3 {
        border-left: 3px solid #06b6d4;
    }
    
    /* Main component row border */
    .main-component-row td {
        border-top: 2px solid #e2e8f0;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
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

    .location-info {
        font-size: 0.85rem;
        color: #64748b;
    }

    /* User Info Card Styles */
    .user-info-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 0.125rem;
    }

    .user-meta {
        font-size: 0.85rem;
        color: #64748b;
    }

    .role-badge-card {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .logout-btn {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .logout-btn:hover {
        background: #fecaca;
        border-color: #fca5a5;
        color: #b91c1c;
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
            <div class="stats-label">Komponen</div>
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
                    <small class="text-muted">Peringkat Komponen</small>
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
                    <small class="text-muted">Peringkat Komponen Utama</small>
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
                    <small class="text-muted">Peringkat Sub Komponen</small>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Components Table -->
@if($components->count() > 0)
<div class="table-container">
    <table class="table data-table">
        <thead>
            <tr>
                <th width="50"></th>
                <th>Komponen / Lokasi</th>
                <th>Status</th>
                <th>Nombor DPA</th>
                <th width="120">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
                <!-- Component Row -->
                <tr>
                    <td>
                        @if($component->mainComponents->count() > 0)
                            <button class="expand-btn" onclick="toggleRow('comp-{{ $component->id }}', this)">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        @endif
                    </td>
                    <td>
                        <div>
                            <strong>{{ $component->nama_premis }}</strong>
                            <div class="location-info mt-1">
                                @if($component->kod_blok)
                                    <i class="bi bi-building"></i> {{ $component->kod_blok }}
                                @endif
                                @if($component->nama_ruang)
                                    · <i class="bi bi-door-open"></i> {{ $component->nama_ruang }}
                                @endif
                                @if($component->nama_binaan_luar)
                                    · <i class="bi bi-geo-alt"></i> {{ $component->nama_binaan_luar }}
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $component->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $component->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>{{ $component->nombor_dpa }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('components.show', $component) }}" class="btn btn-info btn-sm btn-icon" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('components.edit', $component) }}" class="btn btn-light btn-sm btn-icon" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('components.delete', $component) }}" method="POST" 
                                  onsubmit="return confirm('Padam komponen ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Padam">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Main Components Nested Rows -->
                @foreach($component->mainComponents as $mainComponent)
                    <tr class="nested-row" data-parent="comp-{{ $component->id }}">
                        <td colspan="5">
                            <table class="nested-table level-2">
                                <tr class="row-level-2">
                                    <td width="50">
                                        @if($mainComponent->subComponents->count() > 0)
                                            <button class="expand-btn" onclick="toggleRow('main-{{ $mainComponent->id }}', this)">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-success small me-2">Komponen Utama</span>
                                            <strong>{{ $mainComponent->nama_komponen_utama }}</strong>
                                            @if($mainComponent->jenama || $mainComponent->model)
                                                <div class="location-info mt-1">
                                                    @if($mainComponent->jenama)
                                                        <i class="bi bi-tag"></i> {{ $mainComponent->jenama }}
                                                    @endif
                                                    @if($mainComponent->model)
                                                        · <i class="bi bi-box"></i> {{ $mainComponent->model }}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td width="100">
                                        <span class="badge {{ $mainComponent->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} small">
                                            {{ $mainComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td width="120"></td>
                                    <td width="120">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('main-components.show', $mainComponent) }}" class="btn btn-info btn-sm btn-icon" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('main-components.edit', $mainComponent) }}" class="btn btn-light btn-sm btn-icon" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('main-components.delete', $mainComponent) }}" method="POST"
                                                  onsubmit="return confirm('Padam komponen utama ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Padam">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Sub Components Nested Rows -->
                                @foreach($mainComponent->subComponents as $subComponent)
                                    <tr class="nested-row" data-parent="main-{{ $mainComponent->id }}">
                                        <td colspan="5">
                                            <table class="nested-table level-3">
                                                <tr class="row-level-3">
                                                    <td width="50"></td>
                                                    <td>
                                                        <div>
                                                            <span class="badge bg-info small me-2">Sub Komponen</span>
                                                            <strong>{{ $subComponent->nama_sub_komponen }}</strong>
                                                            @if($subComponent->jenama || $subComponent->model)
                                                                <div class="location-info mt-1">
                                                                    @if($subComponent->jenama){{ $subComponent->jenama }}@endif
                                                                    @if($subComponent->model) · {{ $subComponent->model }}@endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td width="100">
                                                        <span class="badge {{ $subComponent->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} small">
                                                            {{ $subComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                        </span>
                                                    </td>
                                                    <td width="120"></td>
                                                    <td width="120">
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('sub-components.show', $subComponent) }}" class="btn btn-info btn-sm btn-icon" title="Lihat">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="{{ route('sub-components.edit', $subComponent) }}" class="btn btn-light btn-sm btn-icon" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('sub-components.delete', $subComponent) }}" method="POST"
                                                                  onsubmit="return confirm('Padam sub komponen ini?')" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Padam">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@else
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
@endif

<script>
function toggleRow(parentId, button) {
    // Toggle button rotation
    button.classList.toggle('expanded');
    
    // Find all rows with matching parent
    const rows = document.querySelectorAll(`[data-parent="${parentId}"]`);
    
    rows.forEach(row => {
        row.classList.toggle('show');
        
        // If closing, also close all nested children
        if (!row.classList.contains('show')) {
            const nestedButtons = row.querySelectorAll('.expand-btn.expanded');
            nestedButtons.forEach(btn => {
                btn.classList.remove('expanded');
            });
            
            const childRows = row.querySelectorAll('.nested-row.show');
            childRows.forEach(child => {
                child.classList.remove('show');
            });
        }
    });
}
</script>

@endsection