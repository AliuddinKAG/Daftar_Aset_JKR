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
            font-family: 'Arial', 'DejaVu Sans', sans-serif;
            font-size: 7pt;
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
        }
        
        .page-header h2 {
            font-size: 8pt;
            font-weight: normal;
        }
        
        .section-title {
            background-color: #000;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 7pt;
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
            font-size: 7pt;
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
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 95px); min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->nama_komponen_utama ?? '' }}</span>
        </div>

        <!-- Id Komponen Utama + Kod Lokasi (SEBARIS) -->
        <div style="font-size: 7.4pt;">
            <span>Nombor DPA</span>
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
    <tr>
        <td colspan="1" style="text-align: center;">
            @php
                $saiz = is_string($subComponent->saiz) ? json_decode($subComponent->saiz, true) : $subComponent->saiz;
            @endphp
            @if(is_array($saiz) && !empty($saiz))
                @foreach($saiz as $s)
                    {{ $s }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->saiz ?? '' }}
            @endif
        </td>
        <td colspan="1" style="width: 150px;">
            @php
                $saiz_unit = is_string($subComponent->saiz_unit) ? json_decode($subComponent->saiz_unit, true) : $subComponent->saiz_unit;
            @endphp
            @if(is_array($saiz_unit) && !empty($saiz_unit))
                @foreach($saiz_unit as $su)
                    {{ $su }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->saiz_unit ?? '' }}
            @endif
        </td>
        <td colspan="1"><span>(Panjang/Tinggi/<br>Lebar/Luas/<br>Dalam/Lebar/Tebal/<br>Diameter/Jarak dll)</span></td>
        <td style="text-align: center;">
            @php
                $kadaran = is_string($subComponent->kadaran) ? json_decode($subComponent->kadaran, true) : $subComponent->kadaran;
            @endphp
            @if(is_array($kadaran) && !empty($kadaran))
                @foreach($kadaran as $k)
                    {{ $k }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->kadaran ?? '' }}
            @endif
        </td>
        <td colspan="1">
            @php
                $kadaran_unit = is_string($subComponent->kadaran_unit) ? json_decode($subComponent->kadaran_unit, true) : $subComponent->kadaran_unit;
            @endphp
            @if(is_array($kadaran_unit) && !empty($kadaran_unit))
                @foreach($kadaran_unit as $ku)
                    {{ $ku }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->kadaran_unit ?? '' }}
            @endif
        </td>
        <td colspan="2"><span>(Voltan/Arus/Kuasa/Rating/<br>Ratio/Keamatan Bunyi/Fluks/<br>Faktor Kuasa/Kecekapan/<br>Fotometri/Bandwidth dll)</span></td>
    </tr>
    <tr style="background-color: #f5f5f5;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Kapasiti</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Unit</td>
        <td colspan="4" class="value-cell" rowspan="2" style="min-height: 15px; vertical-align: top;">
            <strong>Gambar Sub Komponen</strong><br>
            <span style="font-size: 6pt;">Sila lampirkan gambar jika perlu, dan pastikan dimuat naik ke dalam Sistem mySPATA</span>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            @php
                $kapasiti = is_string($subComponent->kapasiti) ? json_decode($subComponent->kapasiti, true) : $subComponent->kapasiti;
            @endphp
            @if(is_array($kapasiti) && !empty($kapasiti))
                @foreach($kapasiti as $kap)
                    {{ $kap }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->kapasiti ?? '' }}
            @endif
        </td>
        <td>
            @php
                $kapasiti_unit = is_string($subComponent->kapasiti_unit) ? json_decode($subComponent->kapasiti_unit, true) : $subComponent->kapasiti_unit;
            @endphp
            @if(is_array($kapasiti_unit) && !empty($kapasiti_unit))
                @foreach($kapasiti_unit as $kapu)
                    {{ $kapu }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            @else
                {{ $subComponent->kapasiti_unit ?? '' }}
            @endif
        </td>
        <td><span>(Isipadu/Head/Berat/Btu/ Velocity/Speed dll)</span></td>
    </tr>
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
    @endphp
    @if(is_array($documents) && !empty($documents))
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
        @for($i = 0; $i < 2; $i++)
        <tr>
            <td colspan="1">&nbsp;</td>
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