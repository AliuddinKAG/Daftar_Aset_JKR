@extends('layouts.app')

@section('title', 'Lihat Sub Komponen')

@section('content')
<div class="row">
    <div class="col-md-12">


        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                    <small>Peringkat Sub Komponen</small>
                </div>
                <div>
                    <a href="{{ route('sub-components.edit', $subComponent) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('export.sub-component.pdf', $subComponent) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('export.complete-report.pdf', $subComponent) }}" class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf"></i> Download Complete Report
                    </a>
                </div>
            </div>
            <div class="card-body">

                <!-- MAKLUMAT KOMPONEN UTAMA -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        MAKLUMAT KOMPONEN UTAMA
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Nama Premis:</strong>
                                <p class="mb-0">{{ $subComponent->mainComponent->component->nama_premis ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Nombor DPA:</strong>
                                <p class="mb-0">{{ $subComponent->mainComponent->component->nombor_dpa ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Komponen Utama:</strong>
                                <p class="mb-0">
                                    <a href="{{ route('main-components.show', $subComponent->mainComponent) }}" class="text-decoration-none">
                                        {{ $subComponent->mainComponent->nama_komponen_utama ?? '-' }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAKLUMAT SUB KOMPONEN -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        MAKLUMAT SUB KOMPONEN
                    </div>
                    <div class="card-body">
                        <div class="card mb-3" style="background: #f8f9fa;">
                            <div class="card-header bg-dark text-white">
                                <strong>Maklumat Utama</strong>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Nama Sub Komponen:</strong>
                                        <p class="mb-0 text-info fw-bold">{{ $subComponent->nama_sub_komponen }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Deskripsi:</strong>
                                        <p class="mb-0">{{ $subComponent->deskripsi ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Kuantiti:</strong>
                                        <p class="mb-0">{{ $subComponent->kuantiti ?? 1 }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Status Komponen:</strong>
                                        <p class="mb-0">
                                            @switch($subComponent->status_komponen)
                                                @case('operational')
                                                    <span class="badge bg-success">Operational</span>
                                                    @break
                                                @case('under_maintenance')
                                                    <span class="badge bg-warning">Under Maintenance</span>
                                                    @break
                                                @case('rosak')
                                                    <span class="badge bg-danger">Rosak</span>
                                                    @break
                                                @case('retired')
                                                    <span class="badge bg-secondary">Retired</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">-</span>
                                            @endswitch
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Jenama:</strong>
                                <p class="mb-0">{{ $subComponent->jenama ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Model:</strong>
                                <p class="mb-0">{{ $subComponent->model ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>No. Siri:</strong>
                                <p class="mb-0">{{ $subComponent->no_siri ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>No. Sijil Pendaftaran:</strong>
                                <p class="mb-0">{{ $subComponent->no_sijil_pendaftaran ?? '-' }}</p>
                            </div>
                        </div>

                        @if($subComponent->catatan)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="mb-0">{{ $subComponent->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        MAKLUMAT ATRIBUT SPESIFIKASI
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Jenis:</strong>
                                <p class="mb-0">{{ $subComponent->jenis ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Bahan:</strong>
                                <p class="mb-0">{{ $subComponent->bahan ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Saiz Fizikal:</strong>
                                @if(isset($subComponent->saiz_decoded) && is_array($subComponent->saiz_decoded))
                                    @foreach($subComponent->saiz_decoded as $index => $saiz)
                                        <p class="mb-0">
                                            {{ $saiz ?? '-' }} 
                                            {{ $subComponent->saiz_unit_decoded[$index] ?? '' }}
                                        </p>
                                    @endforeach
                                @else
                                    <p class="mb-0">-</p>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <strong>Kadaran:</strong>
                                @if(isset($subComponent->kadaran_decoded) && is_array($subComponent->kadaran_decoded))
                                    @foreach($subComponent->kadaran_decoded as $index => $kadaran)
                                        <p class="mb-0">
                                            {{ $kadaran ?? '-' }} 
                                            {{ $subComponent->kadaran_unit_decoded[$index] ?? '' }}
                                        </p>
                                    @endforeach
                                @else
                                    <p class="mb-0">-</p>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <strong>Kapasiti:</strong>
                                @if(isset($subComponent->kapasiti_decoded) && is_array($subComponent->kapasiti_decoded))
                                    @foreach($subComponent->kapasiti_decoded as $index => $kapasiti)
                                        <p class="mb-0">
                                            {{ $kapasiti ?? '-' }} 
                                            {{ $subComponent->kapasiti_unit_decoded[$index] ?? '' }}
                                        </p>
                                    @endforeach
                                @else
                                    <p class="mb-0">-</p>
                                @endif
                            </div>
                        </div>

                        @if($subComponent->catatan_atribut)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="mb-0">{{ $subComponent->catatan_atribut }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- MAKLUMAT PEMBELIAN -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        MAKLUMAT PEMBELIAN
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="50%"><strong>Tarikh Pembelian</strong></td>
                                        <td>{{ $subComponent->tarikh_pembelian ? \Carbon\Carbon::parse($subComponent->tarikh_pembelian)->format('d/m/Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kos Perolehan</strong></td>
                                        <td>{{ $subComponent->kos_perolehan ? 'RM ' . number_format($subComponent->kos_perolehan, 2) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Pesanan Rasmi/Kontrak</strong></td>
                                        <td>{{ $subComponent->no_pesanan_rasmi_kontrak ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kod PTJ</strong></td>
                                        <td>{{ $subComponent->kod_ptj ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="50%"><strong>Tarikh Dipasang</strong></td>
                                        <td>{{ $subComponent->tarikh_dipasang ? \Carbon\Carbon::parse($subComponent->tarikh_dipasang)->format('d/m/Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarikh Waranti Tamat</strong></td>
                                        <td>
                                            {{ $subComponent->tarikh_waranti_tamat ? \Carbon\Carbon::parse($subComponent->tarikh_waranti_tamat)->format('d/m/Y') : '-' }}
                                            @if($subComponent->tarikh_waranti_tamat && \Carbon\Carbon::parse($subComponent->tarikh_waranti_tamat)->isPast())
                                                <span class="badge bg-danger">Tamat</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jangka Hayat</strong></td>
                                        <td>{{ $subComponent->jangka_hayat ? $subComponent->jangka_hayat . ' Tahun' : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Pengilang, Pembekal, Kontraktor -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Pengilang</strong></div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $subComponent->nama_pengilang ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Pembekal</strong></div>
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Nama:</strong> {{ $subComponent->nama_pembekal ?? '-' }}</p>
                                        <p class="mb-1"><strong>Alamat:</strong> {{ $subComponent->alamat_pembekal ?? '-' }}</p>
                                        <p class="mb-0"><strong>Tel:</strong> {{ $subComponent->no_telefon_pembekal ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Kontraktor</strong></div>
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Nama:</strong> {{ $subComponent->nama_kontraktor ?? '-' }}</p>
                                        <p class="mb-1"><strong>Alamat:</strong> {{ $subComponent->alamat_kontraktor ?? '-' }}</p>
                                        <p class="mb-0"><strong>Tel:</strong> {{ $subComponent->no_telefon_kontraktor ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($subComponent->catatan_pembelian)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="mb-0">{{ $subComponent->catatan_pembelian }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- DOKUMEN BERKAITAN -->
                @if(isset($subComponent->dokumen_decoded) && is_array($subComponent->dokumen_decoded) && count($subComponent->dokumen_decoded) > 0)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        DOKUMEN BERKAITAN
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Dokumen</th>
                                    <th>No. Rujukan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subComponent->dokumen_decoded as $doc)
                                <tr>
                                    <td>{{ $doc['bil'] ?? '-' }}</td>
                                    <td>{{ $doc['nama'] ?? '-' }}</td>
                                    <td>{{ $doc['rujukan'] ?? '-' }}</td>
                                    <td>{{ $doc['catatan'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($subComponent->catatan_dokumen)
                        <p class="mb-0"><strong>Catatan:</strong> {{ $subComponent->catatan_dokumen }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- NOTA & STATUS -->
                <div class="row">
                    <div class="col-md-9">
                        @if($subComponent->nota)
                        <strong>Nota Tambahan:</strong>
                        <p>{{ $subComponent->nota }}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong>
                        <p>
                            @if($subComponent->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection