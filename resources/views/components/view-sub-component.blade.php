@extends('layouts.app')

@section('title', 'Paparan Sub Komponen')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">PAPARAN DETAIL SUB KOMPONEN</h5>
                        <small>Peringkat Sub Komponen</small>
                    </div>
                    <div>
                        @if($subComponent->status_komponen)
                            <span class="badge bg-light text-dark fs-6">
                                {{ strtoupper(str_replace('_', ' ', $subComponent->status_komponen)) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <!-- Action Buttons -->
                <div class="mb-4">
                    <a href="{{ route('components.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('main-components.show', $subComponent->mainComponent) }}" class="btn btn-success">
                        <i class="bi bi-eye"></i> Lihat Komponen Utama
                    </a>
                    <a href="{{ route('sub-components.edit', $subComponent) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    
                    <!-- Export Buttons -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download"></i> Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('export.sub-component.pdf', $subComponent) }}" target="_blank">
                                    <i class="bi bi-file-pdf text-danger"></i> Export PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('export.sub-component.excel', $subComponent) }}">
                                    <i class="bi bi-file-excel text-success"></i> Export Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <form action="{{ route('sub-components.delete', $subComponent) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Adakah anda pasti ingin memadam sub komponen ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Padam
                        </button>
                    </form>
                </div>

                <!-- Rest of the content remains the same -->
                <!-- BREADCRUMB HIERARCHY -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light p-3 rounded">
                        <li class="breadcrumb-item">
                            <a href="{{ route('components.show', $subComponent->mainComponent->component) }}">
                                <i class="bi bi-box-seam"></i> {{ $subComponent->mainComponent->component->nama_premis }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('main-components.show', $subComponent->mainComponent) }}">
                                <i class="bi bi-layers"></i> {{ $subComponent->mainComponent->nama_komponen_utama }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="bi bi-diagram-3"></i> {{ $subComponent->nama_sub_komponen }}
                        </li>
                    </ol>
                </nav>

                <!-- MAKLUMAT SUB KOMPONEN -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> MAKLUMAT SUB KOMPONEN</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%" class="fw-bold bg-light">Nama Komponen</td>
                                <td>{{ $subComponent->mainComponent->component->nama_premis }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nama Komponen Utama</td>
                                <td>{{ $subComponent->mainComponent->nama_komponen_utama }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nama Sub Komponen</td>
                                <td><strong class="text-info">{{ $subComponent->nama_sub_komponen }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- DESKRIPSI -->
                @if($subComponent->deskripsi)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-file-text"></i> DESKRIPSI</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $subComponent->deskripsi }}</p>
                    </div>
                </div>
                @endif

                <!-- MAKLUMAT DETAIL -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-card-list"></i> MAKLUMAT DETAIL</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%" class="fw-bold bg-light">Status Komponen</td>
                                <td>
                                    @if($subComponent->status_komponen == 'operational')
                                        <span class="badge bg-success">Operational</span>
                                    @elseif($subComponent->status_komponen == 'under_maintenance')
                                        <span class="badge bg-warning text-dark">Under Maintenance</span>
                                    @elseif($subComponent->status_komponen == 'rosak')
                                        <span class="badge bg-danger">Rosak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $subComponent->status_komponen ?? 'N/A' }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Jenama</td>
                                <td>{{ $subComponent->jenama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Model</td>
                                <td>{{ $subComponent->model ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">No. Siri</td>
                                <td>{{ $subComponent->no_siri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">No. Sijil Pendaftaran</td>
                                <td>{{ $subComponent->no_sijil_pendaftaran ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kuantiti (Sama Jenis)</td>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $subComponent->kuantiti }}</span>
                                    @if($subComponent->kuantiti > 1)
                                        <small class="text-muted ms-2">unit</small>
                                    @else
                                        <small class="text-muted ms-2">unit</small>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- CATATAN -->
                @if($subComponent->catatan)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-chat-square-text"></i> CATATAN</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $subComponent->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- MAKLUMAT HIERARKI -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-diagram-2"></i> MAKLUMAT HIERARKI</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2">Komponen</h6>
                                        <p class="small mb-0">{{ $subComponent->mainComponent->component->nama_premis }}</p>
                                        <a href="{{ route('components.show', $subComponent->mainComponent->component) }}" 
                                           class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="bi bi-layers text-success" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2">Komponen Utama</h6>
                                        <p class="small mb-0">{{ $subComponent->mainComponent->nama_komponen_utama }}</p>
                                        <a href="{{ route('main-components.show', $subComponent->mainComponent) }}" 
                                           class="btn btn-sm btn-outline-success mt-2">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-diagram-3 text-info" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2">Sub Komponen</h6>
                                        <p class="small mb-0">{{ $subComponent->nama_sub_komponen }}</p>
                                        <span class="badge bg-info mt-2">Anda di sini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- METADATA -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-clock-history"></i> MAKLUMAT REKOD</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td width="30%" class="fw-bold">ID Sub Komponen</td>
                                <td><code>{{ $subComponent->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tarikh Dicipta</td>
                                <td>{{ $subComponent->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tarikh Kemaskini</td>
                                <td>{{ $subComponent->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status Rekod</td>
                                <td>
                                    <span class="badge {{ $subComponent->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $subComponent->status == 'aktif' ? 'AKTIF' : 'TIDAK AKTIF' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection