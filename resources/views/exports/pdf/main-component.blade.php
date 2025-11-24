{{-- resources/views/exports/pdf/main-component.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Komponen Utama - {{ $mainComponent->nama_komponen_utama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            margin: 10mm;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7px;
            line-height: 1.2;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 6px;
            border-bottom: 1.5px solid #28a745;
            padding-bottom: 4px;
        }
        .header h1 {
            font-size: 11px;
            color: #28a745;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 8px;
            color: #666;
        }
        .section {
            margin-bottom: 5px;
            border: 0.5px solid #ddd;
        }
        .section-header {
            background: #343a40;
            color: white;
            padding: 2px 6px;
            font-weight: bold;
            font-size: 8px;
        }
        .section-header.secondary {
            background: #6c757d;
        }
        .section-body {
            padding: 4px 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
        }
        table th, table td {
            border: 0.5px solid #ddd;
            padding: 2px 4px;
            text-align: left;
            font-size: 7px;
        }
        table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }
        .col-3 {
            display: table-cell;
            width: 33.33%;
            padding-right: 6px;
            vertical-align: top;
        }
        .col-2 {
            display: table-cell;
            width: 50%;
            padding-right: 6px;
            vertical-align: top;
        }
        .col-4 {
            display: table-cell;
            width: 25%;
            padding-right: 6px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #555;
            font-size: 7px;
        }
        .value {
            margin-top: 1px;
            font-size: 7px;
        }
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 6px;
            font-weight: bold;
        }
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-secondary { background: #6c757d; color: white; }
        .footer {
            position: fixed;
            bottom: 5px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 6px;
            color: #999;
            border-top: 0.5px solid #ddd;
            padding-top: 2px;
        }
        .info-box {
            border: 0.5px solid #ddd;
            padding: 3px;
            margin-bottom: 3px;
            background: #f9f9f9;
        }
        .info-box .title {
            font-weight: bold;
            margin-bottom: 2px;
            color: #333;
            font-size: 7px;
        }
        /* Optimize spacing */
        .compact-row {
            margin-bottom: 2px;
        }
        small {
            font-size: 6px;
        }
        /* Grid layout untuk maximize space */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            margin-bottom: 3px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 4px;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <p>Peringkat Komponen Utama</p>
    </div>

    <!-- MAKLUMAT KOMPONEN UTAMA -->
    <div class="section">
        <div class="section-header secondary">MAKLUMAT KOMPONEN UTAMA</div>
        <div class="section-body">
            <div class="row compact-row">
                <div class="col-3">
                    <span class="label">Premis:</span> {{ $mainComponent->component->nama_premis ?? '-' }}
                </div>
                <div class="col-3">
                    <span class="label">DPA:</span> {{ $mainComponent->component->nombor_dpa ?? '-' }}
                </div>
                <div class="col-3">
                    <span class="label">Kod Lokasi:</span> {{ $mainComponent->kod_lokasi ?? '-' }}
                </div>
            </div>

            <div class="row compact-row">
                <div class="col-2">
                    <span class="label">Nama Komponen:</span> <strong>{{ $mainComponent->nama_komponen_utama }}</strong>
                </div>
            </div>
            
            <div class="row compact-row">
                <div class="col-3">
                    <span class="label">Sistem:</span> {{ $mainComponent->sistem ?? '-' }}
                </div>
                <div class="col-3">
                    <span class="label">SubSistem:</span> {{ $mainComponent->subsistem ?? '-' }}
                </div>
                <div class="col-3">
                    <span class="label">Kuantiti:</span> {{ $mainComponent->kuantiti ?? 1 }}
                </div>
            </div>

            <div class="row compact-row">
                <div class="col-2">
                    <span class="label">Bidang:</span>
                    @php
                        $bidang = [];
                        if($mainComponent->awam_arkitek) $bidang[] = 'Awam/Arkitek';
                        if($mainComponent->elektrikal) $bidang[] = 'Elektrikal';
                        if($mainComponent->elv_ict) $bidang[] = 'ELV/ICT';
                        if($mainComponent->mekanikal) $bidang[] = 'Mekanikal';
                        if($mainComponent->bio_perubatan) $bidang[] = 'Bio Perubatan';
                        if($mainComponent->lain_lain) $bidang[] = $mainComponent->lain_lain;
                    @endphp
                    {{ !empty($bidang) ? implode(', ', $bidang) : '-' }}
                </div>
                @if($mainComponent->catatan)
                <div class="col-2">
                    <span class="label">Catatan:</span> {{ $mainComponent->catatan }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MAKLUMAT PEROLEHAN & KOMPONEN (Gabung 2 sections) -->
    <div class="section">
        <div class="section-header">MAKLUMAT PEROLEHAN & KOMPONEN</div>
        <div class="section-body">
            <table>
                <tr>
                    <th width="18%">Tarikh Perolehan</th>
                    <th width="18%">Tarikh Dipasang</th>
                    <th width="18%">Kos Perolehan</th>
                    <th width="23%">No. Pesanan Rasmi</th>
                    <th width="23%">Jangka Hayat</th>
                </tr>
                <tr>
                    <td>{{ $mainComponent->tarikh_perolehan?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $mainComponent->tarikh_dipasang?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $mainComponent->kos_perolehan ? 'RM ' . number_format($mainComponent->kos_perolehan, 2) : '-' }}</td>
                    <td>{{ $mainComponent->no_pesanan_rasmi_kontrak ?? '-' }}</td>
                    <td>{{ $mainComponent->jangka_hayat ? $mainComponent->jangka_hayat . ' Tahun' : '-' }}</td>
                </tr>
            </table>

            <div class="grid-3">
                <div class="info-box">
                    <div class="title">Pengilang</div>
                    {{ $mainComponent->nama_pengilang ?? '-' }}
                </div>
                <div class="info-box">
                    <div class="title">Pembekal</div>
                    {{ $mainComponent->nama_pembekal ?? '-' }}
                    @if($mainComponent->no_telefon_pembekal)
                    <br><small>Tel: {{ $mainComponent->no_telefon_pembekal }}</small>
                    @endif
                </div>
                <div class="info-box">
                    <div class="title">Kontraktor</div>
                    {{ $mainComponent->nama_kontraktor ?? '-' }}
                    @if($mainComponent->no_telefon_kontraktor)
                    <br><small>Tel: {{ $mainComponent->no_telefon_kontraktor }}</small>
                    @endif
                </div>
            </div>

            <table>
                <tr>
                    <th width="15%">Jenama</th>
                    <th width="15%">Model</th>
                    <th width="20%">No. Siri</th>
                    <th width="20%">No. Tag/Label</th>
                    <th width="15%">Status</th>
                    <th width="15%">Deskripsi</th>
                </tr>
                <tr>
                    <td>{{ $mainComponent->jenama ?? '-' }}</td>
                    <td>{{ $mainComponent->model ?? '-' }}</td>
                    <td>{{ $mainComponent->no_siri ?? '-' }}</td>
                    <td>{{ $mainComponent->no_tag_label ?? '-' }}</td>
                    <td>
                        @switch($mainComponent->status_komponen)
                            @case('operational')
                                <span class="badge badge-success">Operational</span>
                                @break
                            @case('under_maintenance')
                                <span class="badge badge-warning">Maintenance</span>
                                @break
                            @case('rosak')
                                <span class="badge badge-danger">Rosak</span>
                                @break
                            @case('retired')
                                <span class="badge badge-secondary">Retired</span>
                                @break
                            @default
                                -
                        @endswitch
                    </td>
                    <td><small>{{ Str::limit($mainComponent->deskripsi ?? '-', 30) }}</small></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
    <div class="section">
        <div class="section-header">ATRIBUT SPESIFIKASI</div>
        <div class="section-body">
            <table>
                <tr>
                    <th width="20%">Jenis</th>
                    <th width="20%">Bekalan Elektrik</th>
                    <th width="20%">Bahan</th>
                    <th width="20%">Pemasangan</th>
                    <th width="20%">No. Sijil</th>
                </tr>
                <tr>
                    <td>{{ $mainComponent->jenis ?? '-' }}</td>
                    <td>{{ $mainComponent->bekalan_elektrik ?? '-' }}</td>
                    <td>{{ $mainComponent->bahan ?? '-' }}</td>
                    <td>{{ $mainComponent->kaedah_pemasangan ?? '-' }}</td>
                    <td>{{ $mainComponent->no_sijil_pendaftaran ?? '-' }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th width="33%">Saiz Fizikal</th>
                    <th width="33%">Kadaran</th>
                    <th width="34%">Kapasiti</th>
                </tr>
                <tr>
                    <td>{{ $mainComponent->saiz ?? '-' }} {{ $mainComponent->saiz_unit }}</td>
                    <td>{{ $mainComponent->kadaran ?? '-' }} {{ $mainComponent->kadaran_unit }}</td>
                    <td>{{ $mainComponent->kapasiti ?? '-' }} {{ $mainComponent->kapasiti_unit }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- KOMPONEN BERHUBUNGKAIT & DOKUMEN (Gabung dalam satu section) -->
    @if(($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0) || 
        ($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0))
    <div class="section">
        <div class="section-header">KOMPONEN & DOKUMEN BERHUBUNGKAIT</div>
        <div class="section-body">
            @if($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0)
            <div style="margin-bottom: 3px;">
                <strong style="font-size: 7px;">Komponen:</strong>
                <table>
                    <tr>
                        <th width="5%">Bil</th>
                        <th width="45%">Nama Komponen</th>
                        <th width="30%">No. DPA/Kod</th>
                        <th width="20%">No. Tag</th>
                    </tr>
                    @foreach($mainComponent->relatedComponents->take(3) as $related)
                    <tr>
                        <td>{{ $related->bil }}</td>
                        <td>{{ $related->nama_komponen }}</td>
                        <td>{{ $related->no_dpa_kod_ruang ?? '-' }}</td>
                        <td>{{ $related->no_tag_label ?? '-' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            @if($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0)
            <div>
                <strong style="font-size: 7px;">Dokumen:</strong>
                <table>
                    <tr>
                        <th width="5%">Bil</th>
                        <th width="45%">Nama Dokumen</th>
                        <th width="30%">No. Rujukan</th>
                        <th width="20%">Catatan</th>
                    </tr>
                    @foreach($mainComponent->relatedDocuments->take(3) as $doc)
                    <tr>
                        <td>{{ $doc->bil }}</td>
                        <td>{{ $doc->nama_dokumen }}</td>
                        <td>{{ $doc->no_rujukan_berkaitan ?? '-' }}</td>
                        <td><small>{{ Str::limit($doc->catatan ?? '-', 20) }}</small></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- NOTA (Ringkas) -->
    @if($mainComponent->nota)
    <div class="section">
        <div class="section-header">NOTA</div>
        <div class="section-body">
            <small>{{ $mainComponent->nota }}</small>
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        Dijana: {{ now()->format('d/m/Y H:i') }} | Status: 
        @if($mainComponent->status == 'aktif')
            <span class="badge badge-success">Aktif</span>
        @else
            <span class="badge badge-secondary">Tidak Aktif</span>
        @endif
    </div>
</body>
</html>