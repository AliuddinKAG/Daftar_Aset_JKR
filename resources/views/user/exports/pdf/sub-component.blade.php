<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Borang 3 - Sub Komponen</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'DejaVu Sans', 'sans-serif';
            font-size: 8pt;
            line-height: 1.0;
            color: #000;
            padding: 8mm;
            background: #fff;
        }
        
        .page-wrapper {
            transform: scale(0.85);
            transform-origin: top center;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 2px solid #ffffffff;
            padding-bottom: 2px;
        }
        
        .page-header h1 {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1px;
            text-decoration: underline;
        }
        
        .page-header h2 {
            font-size: 8pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .section-title {
            background-color: #000;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 8pt;
            margin-top: 2px;
            margin-bottom: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        table td {
            border: 1px solid #000;
            padding: 1px 3px;
            vertical-align: top;
            font-size: 8pt;
        }
        
        .label-cell {
            background-color: #f5f5f5;
            font-weight: normal;
        }
        
        .value-cell {
            background-color: #fff;
        }
        
        .checkbox-row {
            padding: 2px 4px;
        }
        
        .checkbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin-right: 3px;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 8px;
        }
        
        .inline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding: 0 3px;
        }
        
        div > strong {
            font-size: 7pt;
        }
        
        @media print {
            body { 
                padding: 8mm;
            }
            .page-wrapper { 
                transform: scale(0.95);
                page-break-inside: avoid;
            }
            @page {
                size: A4;
                margin: 8mm;
            }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

<!-- Header -->
<div class="page-header">
    <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
    <h2>Peringkat Komponen Sub Komponen</h2>
</div>

    <!-- MAKLUMAT SUB Komponen -->
    <div style="margin-top: 4px; margin-bottom: 3px;">
        <div style="font-weight: bold; margin-bottom: 3px; font-size: 7.4pt; text-decoration: underline;">
            MAKLUMAT SUB KOMPONEN
        </div>

    <!-- Nama Komponen Utama -->
        <div style="margin-bottom: 2px; font-size: 7.4pt;">
            <span>Nama Komponen Utama</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 200px); min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->nama_komponen_utama ?? '' }}</span>
        </div>

        <!-- Id Komponen Utama + Kod Lokasi (SEBARIS) -->
        <div style="font-size: 7.4pt;">
            <span>Id Komponen Utama</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->id ?? '' }}</span>
            
            <span style="margin-left: 40px;">Kod Lokasi</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 450px); min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->kod_lokasi ?? '' }}</span>
        </div>
    </div>

<table>
<!-- MAKLUMAT SUB KOMPONEN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Sub Komponen</td>
    </tr>
    <tr>
        <td class="label-cell">Nama Sub Komponen</td>
        <td colspan="6" class="value-cell">{{ $subComponent->nama_sub_komponen ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Deskripsi</td>
        <td colspan="6" class="value-cell">{{ $subComponent->deskripsi ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Status Komponen</td>
        <td colspan="1" class="value-cell">
            @switch($subComponent->status_komponen)
                @case('operational') Operational @break
                @case('under_maintenance') Under Maintenance @break
                @case('rosak') Rosak @break
                @default {{ $subComponent->status_komponen ?? '' }}
            @endswitch
        </td>
        <td class="label-cell">No. Siri</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_siri ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Jenama</td>
        <td colspan="1" class="value-cell">{{ $subComponent->jenama ?? '' }}</td>
        <td class="label-cell">No. Sijil Pendaftaran (Jika ada)</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_sijil_pendaftaran ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Model</td>
        <td colspan="1" class="value-cell">{{ $subComponent->model ?? '' }}</td>
        <td class="label-cell">Kuantiti (Sama Jenis)</td>
        <td colspan="4" class="value-cell">{{ $subComponent->kuantiti ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;">
            <strong>Catatan:</strong> {{ $subComponent->catatan ?? '' }}
        </td>
    </tr>

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">** Maklumat Atribut Spesifikasi</td>
    </tr>
    <tr>
        <td class="label-cell" style="width: 15%;">Jenis</td>
        <td class="value-cell" style="width: 35%;">{{ $subComponent->jenis ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Bahan</td>
        <td colspan="4" class="value-cell" style="width: 35%;">{{ $subComponent->bahan ?? '' }}</td>
    </tr>
    <tr style="background-color: #f5f5f5;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Saiz Fizikal</td>
        <td style="text-align: center; font-weight: bold;" colspan="1">Unit</td>
        <td style="text-align: center; font-weight: bold;" colspan="1">Kadaran</td>
        <td style="text-align: center; font-weight: bold;" colspan="4">Unit</td>
    </tr>
    @php
        // FIXED: Use correct relationship and field names
        $saizFizikalData = isset($subComponent->measurements) && is_object($subComponent->measurements) 
            ? $subComponent->measurements->where('type', 'saiz')->sortBy('order')
            : collect();
        
        $kadaranData = isset($subComponent->measurements) && is_object($subComponent->measurements)
            ? $subComponent->measurements->where('type', 'kadaran')->sortBy('order')
            : collect();
        
        $hasSaiz = $saizFizikalData->count() > 0;
        $hasKadaran = $kadaranData->count() > 0;
        $maxRows = max(
            $hasSaiz ? $saizFizikalData->count() : 0,
            $hasKadaran ? $kadaranData->count() : 0,
            4
        );
    @endphp
    @for($i = 0; $i < $maxRows; $i++)
    <tr>
        <td colspan="1" style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->value ?? '' : '' }}
        </td>
        <td colspan="1" style="width: 150px;">
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td colspan="1" rowspan="{{ $maxRows }}"><span>(Panjang/Tinggi/<br>Lebar/Luas/<br>Dalam/Lebar/Tebal/<br>Diameter/Jarak dll)</span></td>
        @endif
        <td style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->value ?? '' : '' }}
        </td>
        <td colspan="1">
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td colspan="2" rowspan="{{ $maxRows }}"><span>(Voltan/Arus/Kuasa/<br>Rating/Ratio/Keamatan Bunyi/Fluks/<br>Faktor Kuasa/Kecekapan/<br>Fotometri/Bandwidth dll)</span></td>
        @endif
    </tr>
    @endfor
    <tr style="background-color: #ffffffff;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Kapasiti</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Unit</td>
        @php
            // FIXED: Use correct type value
            $kapasitiData = isset($subComponent->measurements) && is_object($subComponent->measurements)
                ? $subComponent->measurements->where('type', 'kapasiti')->sortBy('order')
                : collect();
            
            $hasKapasiti = $kapasitiData->count() > 0;
            $kapastiRows = max($hasKapasiti ? $kapasitiData->count() : 0, 4);
        @endphp
        <td colspan="2" class="value-cell" rowspan="{{ $kapastiRows + 1 }}" style="min-height: 15px; vertical-align: top;">
            <strong>Gambar Sub Komponen</strong><br>
        </td>
        <td colspan="2" class="value-cell" rowspan="{{ $kapastiRows + 1 }}">
            <span style="font-size: 7pt;">Sila lampirkan gambar jika perlu, dan pastikan dimuat naik ke dalam Sistem mySPATA</span>
        </td>
    </tr>
    @for($i = 0; $i < $kapastiRows; $i++)
    <tr>
        <td style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->value ?? '' : '' }}
        </td>
        <td>
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td rowspan="{{ $kapastiRows }}"><span>(Isipadu/Head/Berat/Btu/ Velocity/Speed dll)</span></td>
        @endif
    </tr>
    @endfor
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $subComponent->catatan_atribut ?? '' }}</td>
    </tr>

<!-- MAKLUMAT PEMBELIAN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Pembelian</td>
    </tr>
    <tr>
        <td class="label-cell">Tarikh Pembelian</td>
        <td class="value-cell">{{ $subComponent->tarikh_pembelian ? \Carbon\Carbon::parse($subComponent->tarikh_pembelian)->format('d/m/Y') : '' }}</td>
        <td class="label-cell">Tarikh Dipasang</td>
        <td colspan="4" class="value-cell">{{ $subComponent->tarikh_dipasang ? \Carbon\Carbon::parse($subComponent->tarikh_dipasang)->format('d/m/Y') : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kos Perolehan/Kontrak</td>
        <td class="value-cell">{{ $subComponent->kos_perolehan ? 'RM ' . number_format($subComponent->kos_perolehan, 2) : '' }}</td>
        <td class="label-cell">Tarikh Waranti Tamat</td>
        <td colspan="4" class="value-cell">{{ $subComponent->tarikh_waranti_tamat ? \Carbon\Carbon::parse($subComponent->tarikh_waranti_tamat)->format('d/m/Y') : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">No. Pesanan Rasmi Kerajaan/Kontrak</td>
        <td colspan="1" class="value-cell">{{ $subComponent->no_pesanan_rasmi_kontrak ?? '' }}</td>
        <td class="label-cell">Jangka Hayat</td>
        <td colspan="4" class="value-cell">{{ $subComponent->jangka_hayat ? $subComponent->jangka_hayat . ' Tahun' : '' }}</td>
    </tr>
    <tr>
        <td colspan="1" class="label-cell">Kod PTJ</td>
        <td colspan="1" class="value-cell">{{ $subComponent->kod_ptj ?? '' }}</td>
        <td></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td class="label-cell">Pengilang</td>
        <td colspan="6" class="value-cell">{{ $subComponent->nama_pengilang ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Pembekal</td>
        <td colspan="1" class="value-cell">{{ $subComponent->nama_pembekal ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_telefon_pembekal ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Alamat</td>
        <td colspan="6" class="value-cell">{{ $subComponent->alamat_pembekal ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kontraktor</td>
        <td colspan="1" class="value-cell">{{ $subComponent->nama_kontraktor ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_telefon_kontraktor ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Alamat</td>
        <td colspan="6" class="value-cell">{{ $subComponent->alamat_kontraktor ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $subComponent->catatan_pembelian ?? '' }}</td>
    </tr>

<!-- DOKUMEN BERKAITAN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Dokumen Berkaitan (Jika Ada)</td>
    </tr>
    <tr style="background-color: #ffffffff; font-weight: bold;">
        <td colspan="1" style="width: 5%; text-align: center;">Bil</td>
        <td colspan="2" style="width: 45%; text-align: center;">Nama Dokumen</td>
        <td colspan="2" style="width: 30%; text-align: center;">No Rujukan Berkaitan</td>
        <td colspan="2" style="width: 20%; text-align: center;">Catatan</td>
    </tr>
    @php
        $documents = is_string($subComponent->dokumen_berkaitan) 
            ? json_decode($subComponent->dokumen_berkaitan, true) 
            : $subComponent->dokumen_berkaitan;
        
        $hasData = is_array($documents) && !empty($documents) && collect($documents)->contains(function($doc) {
            return !empty($doc['nama']) || !empty($doc['rujukan']);
        });
        
        $minRows = 4;
    @endphp
    
    @if($hasData)
        @foreach($documents as $doc)
            @if(!empty($doc['nama']) || !empty($doc['rujukan']))
            <tr>
                <td colspan="1" style="text-align: center;">{{ $doc['bil'] ?? '' }}</td>
                <td colspan="2">{{ $doc['nama'] ?? '' }}</td>
                <td colspan="2">{{ $doc['rujukan'] ?? '' }}</td>
                <td colspan="2">{{ $doc['catatan'] ?? '' }}</td>
            </tr>
            @endif
        @endforeach
    @else
        @for($i = 0; $i < $minRows; $i++)
        <tr>
            <td colspan="1" style="text-align: center;">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        @endfor
    @endif

</table>

<!-- Nota -->
<div style="margin-top: 3px; font-size: 7pt;">
    <strong>Nota:</strong><br>
    * Sila gunakan lampiran jika Maklumat Sub Komponen diperolehi bagi kuantiti yang melebihi 1.<br>
    ** Maklumat Spesifikasi diisi merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.
</div>

<!-- Muka Surat -->
<div style="margin-top: 4px; text-align: right; font-size: 7pt; font-style: italic; border: 1px solid #000; padding: 3px 8px; display: inline-block; float: right;">
    Muka surat _____ dari _____
</div>

</div>
</body>
</html>