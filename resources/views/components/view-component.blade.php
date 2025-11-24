@extends('layouts.app')

@section('title', 'Paparan Komponen')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">PAPARAN DETAIL KOMPONEN</h5>
                        <small>Peringkat Komponen</small>
                    </div>
                    <div>
                        <span class="badge {{ $component->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} fs-6">
                            {{ $component->status == 'aktif' ? 'AKTIF' : 'TIDAK AKTIF' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <!-- Action Buttons -->
                <div class="mb-4">
                    <a href="{{ route('components.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('components.edit', $component) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('components.delete', $component) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Adakah anda pasti ingin memadam komponen ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Padam
                        </button>
                    </form>
                </div>

                <!-- MAKLUMAT LOKASI KOMPONEN -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i> MAKLUMAT LOKASI KOMPONEN</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%" class="fw-bold bg-light">Nama Premis</td>
                                <td>{{ $component->nama_premis }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nombor DPA</td>
                                <td>{{ $component->nombor_dpa }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- BLOK SECTION (if applicable) -->
                @if($component->ada_blok)
                <div class="card mb-4">
                    <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <h6 class="mb-0"><i class="bi bi-building"></i> MAKLUMAT BLOK</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%" class="fw-bold bg-light">Kod Blok</td>
                                <td>{{ $component->kod_blok ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kod Aras</td>
                                <td>{{ $component->kod_aras ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kod Ruang</td>
                                <td>{{ $component->kod_ruang ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nama Ruang</td>
                                <td>{{ $component->nama_ruang ?? '-' }}</td>
                            </tr>
                            @if($component->catatan_blok)
                            <tr>
                                <td class="fw-bold bg-light">Catatan</td>
                                <td>{{ $component->catatan_blok }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                @endif

                <!-- BINAAN LUAR SECTION (if applicable) -->
                @if($component->ada_binaan_luar)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-house"></i> MAKLUMAT BINAAN LUAR</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%" class="fw-bold bg-light">Nama Binaan Luar</td>
                                <td>{{ $component->nama_binaan_luar ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kod Binaan Luar</td>
                                <td>{{ $component->kod_binaan_luar ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Koordinat GPS (WGS 84)</td>
                                <td>
                                    @if($component->koordinat_x || $component->koordinat_y)
                                        X: {{ $component->koordinat_x ?? '-' }} | Y: {{ $component->koordinat_y ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @if($component->kod_aras_binaan || $component->kod_ruang_binaan || $component->nama_ruang_binaan)
                            <tr>
                                <td colspan="2" class="fw-bold bg-light">Maklumat Aras dan Ruang (jika ada)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kod Aras</td>
                                <td>{{ $component->kod_aras_binaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Kod Ruang</td>
                                <td>{{ $component->kod_ruang_binaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nama Ruang</td>
                                <td>{{ $component->nama_ruang_binaan ?? '-' }}</td>
                            </tr>
                            @endif
                            @if($component->catatan_binaan)
                            <tr>
                                <td class="fw-bold bg-light">Catatan</td>
                                <td>{{ $component->catatan_binaan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                @endif

                <!-- MAIN COMPONENTS LIST -->
                @if($component->mainComponents->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-layers"></i> SENARAI KOMPONEN UTAMA ({{ $component->mainComponents->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($component->mainComponents as $mainComponent)
                            <a href="{{ route('main-components.show', $mainComponent) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $mainComponent->nama_komponen_utama }}</h6>
                                        <small class="text-muted">
                                            @if($mainComponent->jenama)
                                                <i class="bi bi-tag"></i> {{ $mainComponent->jenama }}
                                            @endif
                                            @if($mainComponent->model)
                                                | <i class="bi bi-box"></i> {{ $mainComponent->model }}
                                            @endif
                                            @if($mainComponent->no_siri)
                                                | <i class="bi bi-hash"></i> {{ $mainComponent->no_siri }}
                                            @endif
                                        </small>
                                    </div>
                                    <span class="badge bg-success">{{ $mainComponent->subComponents->count() }} Sub Komponen</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Tiada komponen utama bagi komponen ini.
                    <a href="{{ route('main-components.create') }}" class="alert-link">Tambah komponen utama</a>
                </div>
                @endif

                <!-- METADATA -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-clock-history"></i> MAKLUMAT REKOD</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td width="30%" class="fw-bold">Tarikh Dicipta</td>
                                <td>{{ $component->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tarikh Kemaskini</td>
                                <td>{{ $component->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection