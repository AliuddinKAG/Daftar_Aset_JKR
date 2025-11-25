<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Borang 2 - Komponen Utama</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 8pt;
            line-height: 1.1;
            color: #000;
            padding: 15mm 15mm 15mm 15mm;
            background: #fff;
        }
        
        .page-wrapper {
            transform: scale(0.92);
            transform-origin: top center;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
        }
        
        .page-header h1 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .page-header h2 {
            font-size: 9pt;
            font-weight: normal;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .info-group {
            display: flex;
            gap: 5px;
        }

        .info-group span {
            text-align: left;
        }

        .info-group-right span {
            text-align: right;
        }

        .section-title {
            background-color: #000;
            color: white;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 8pt;
            margin-top: 6px;
            margin-bottom: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        table td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: top;
            font-size: 8pt;
        }
        
        .label-cell {
            background-color: #e0e0e0;
            font-weight: normal;
            width: 25%;
        }
        
        .value-cell {
            background-color: #fff;
        }
        
        .checkbox-row {
            padding: 4px 6px;
        }
        
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1.5px solid #000;
            margin-right: 4px;
            vertical-align: middle;
            text-align: center;
            line-height: 10px;
            font-size: 10px;
        }
        
        .inline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            padding: 0 4px;
        }
        
        @media print {
            body { padding: 15mm; }
            .page-wrapper { transform: scale(0.92); }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

<!-- Header -->
<div class="page-header">
    <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
    <h2>Peringkat Komponen Utama</h2>
</div>

    <!-- MAKLUMAT LOKASI KOMPONEN -->
    <div style="margin-top: 10px;">
        <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">MAKLUMAT LOKASI KOMPONEN</div>
        
        <div class="info-row">
            <span class="info-label">Nama Premis</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $mainComponent->component->nama_premis ?? '' }}</span>
        </div>
        
        <div class="info-row">

        <!-- Left Side -->
        <div class="info-group">
            <span class="info-label">Nombor DPA</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $mainComponent->component->nombor_dpa ?? '' }}</span>
        </div>

        <!-- Right Side -->
        <div class="info-group info-group-right">
            <span class="info-label">Kod Lokasi</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $mainComponent->kod_lokasi ?? '' }}</span>
        </div>
    </div>

<!-- MAKLUMAT KOMPONEN UTAMA -->
<div class="section-title">MAKLUMAT KOMPONEN UTAMA</div>
<table>
    
        <td class="label-cell">Nama Komponen Utama</td>
        <td colspan="3" class="value-cell">{{ $mainComponent->nama_komponen_utama ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Sistem</td>
        <td class="value-cell">{{ $mainComponent->sistem ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">SubSistem</td>
        <td class="value-cell">{{ $mainComponent->subsistem ?? '' }}</td>
        <td class="label-cell" rowspan="2" style="vertical-align: middle;">Gambar Komponen</td>
        <td class="value-cell" rowspan="2">{{ $mainComponent->gambar_komponen ?? '' }}</td>
    </tr>
    <<tr>
        <td class="label-cell">No Perolehan (Gemas)</td>
    </tr>
    <tr>
        <td class="label-cell">Kuantiti<br><small>(Komponen yang sama jenis)</small></td>
        <td colspan="3" class="value-cell">{{ $mainComponent->kuantiti ?? '' }}</td>
    </tr>
</table>

<!-- Bidang Kejuruteraan -->
<table style="margin-top: 0;">
    <tr>
        <td colspan="3" class="checkbox-row">
            <strong>Bidang Kejuruteraan Komponen:</strong>
        </td>
        <td>
            <div style="margin-top: 4px;">
                <span class="checkbox">{{ $mainComponent->awam_arkitek ? '✓' : '' }}</span> Awam/Arkitek
                <span style="margin-left: 15px;" class="checkbox">{{ $mainComponent->elektrikal ? '✓' : '' }}</span> Elektrikal
                <span style="margin-left: 15px;" class="checkbox">{{ $mainComponent->elv_ict ? '✓' : '' }}</span> ELV/ICT
                <span style="margin-left: 15px;" class="checkbox">{{ $mainComponent->mekanikal ? '✓' : '' }}</span> Mekanikal<br>
                <span class="checkbox">{{ $mainComponent->bio_perubatan ? '✓' : '' }}</span> Bio Perubatan
                <span style="margin-left: 15px;" class="checkbox">{{ $mainComponent->lain_lain ? '✓' : '' }}</span> Lain-lain: 
                <span class="inline-field">{{ $mainComponent->lain_lain ?? '' }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="min-height: 30px;">
            <strong>Catatan:</strong> {{ $mainComponent->catatan ?? '' }}
        </td>
    </tr>
</table>

<!-- MAKLUMAT PEROLEHAN -->
<div class="section-title">Maklumat Perolehan</div>
<table>
    <tr>
        <td class="label-cell">Tarikh Perolehan</td>
        <td class="value-cell">{{ $mainComponent->tarikh_perolehan?->format('d/m/Y') ?? '' }}</td>
        <td class="label-cell">Tarikh Dipasang</td>
        <td class="value-cell">{{ $mainComponent->tarikh_dipasang?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kos Perolehan/Kontrak</td>
        <td class="value-cell">{{ $mainComponent->kos_perolehan ? 'RM ' . number_format($mainComponent->kos_perolehan, 2) : '' }}</td>
        <td class="label-cell">Tarikh Waranti Tamat</td>
        <td class="value-cell">{{ $mainComponent->tarikh_waranti_tamat?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">No. Pesanan Rasmi Kerajaan/Kontrak</td>
        <td class="value-cell">{{ $mainComponent->no_pesanan_rasmi_kontrak ?? '' }}</td>
        <td class="label-cell">Tarikh Tamat DLP</td>
        <td class="value-cell">{{ $mainComponent->tarikh_tamat_dlp?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Jangka Hayat</td>
        <td colspan="3" class="value-cell">{{ $mainComponent->jangka_hayat ? $mainComponent->jangka_hayat . ' Tahun' : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Jangka Hayat</td>
        <td colspan="3" class="value-cell">{{ $mainComponent->jangka_hayat ? $mainComponent->jangka_hayat . ' Tahun' : '' }}</td>
    </tr>
</table>

<!-- Pengilang, Pembekal, Kontraktor -->
<table style="margin-top: 0;">
    <tr>
        <td class="label-cell">Pengilang</td>
        <td class="value-cell">{{ $mainComponent->nama_pengilang ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Pembekal</td>
        <td class="value-cell">{{ $mainComponent->nama_pembekal ?? '' }}</td>
        <td class="value-cell">No. Telefon</td>
        <td class="value-cell">{{ $mainComponent->no_telefon_pembekal ?? '' }}</td>        
    </tr>
    <tr>
        <td class="label-cell">Alamat Pembekal</td>
        <td colspan="3" class="value-cell">
            {{ $mainComponent->alamat_pembekal ?? '' }}
        </td>
    </tr>
    <tr>
        <td class="label-cell">Pengilang</td>
        <td class="value-cell">{{ $mainComponent->nama_pengilang ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kontraktor</td>
        <td class="value-cell">{{ $mainComponent->nama_kontraktor ?? '' }}</td>
        <td class="value-cell">No. Telefon</td>
        <td class="value-cell">{{ $mainComponent->no_telefon_kontraktor ?? '' }}</td>        
    </tr>
    <tr>
        <td class="label-cell">Alamat Kontraktor</td>
        <td colspan="3" class="value-cell">
            {{ $mainComponent->alamat_pembekal ?? '' }}
        </td>
    </tr>
    <tr>
        <td colspan="6" style="min-height: 25px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_maklumat ?? '' }}</td>
    </tr>
</table>

<!-- MAKLUMAT KOMPONEN -->
<div class="section-title">Maklumat Komponen</div>
<table>
    <tr>
        <td class="label-cell" style="width: 15%;">Deskripsi</td>
        <td class="value-cell" style="width: 35%;">{{ $mainComponent->deskripsi ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Status Komponen</td>
        <td class="value-cell" style="width: 35%;">
            @switch($mainComponent->status_komponen)
                @case('operational') Operational @break
                @case('under_maintenance') Under Maintenance @break
                @case('rosak') Rosak @break
                @case('retired') Retired @break
                @default {{ $mainComponent->status_komponen ?? '' }}
            @endswitch
        </td>
    </tr>
    <tr>
        <td class="label-cell">Jenama</td>
        <td class="value-cell">{{ $mainComponent->jenama ?? '' }}</td>
        <td class="label-cell">No. Siri</td>
        <td class="value-cell">{{ $mainComponent->no_siri ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Model</td>
        <td class="value-cell">{{ $mainComponent->model ?? '' }}</td>
        <td class="label-cell">No. Tag / Label (Jika berkenaan)</td>
        <td class="value-cell">{{ $mainComponent->no_tag_label ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell" colspan="2"></td>
        <td class="label-cell">No Sijil Pendaftaran (Jika ada)</td>
        <td class="value-cell">{{ $mainComponent->no_sijil_pendaftaran ?? '' }}</td>
    </tr>
</table>

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
<div class="section-title">** Maklumat Atribut Spesifikasi</div>
<table>
    <tr>
        <td class="label-cell" style="width: 15%;">Jenis</td>
        <td class="value-cell" style="width: 35%;">{{ $mainComponent->jenis ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Bahan</td>
        <td class="value-cell" style="width: 35%;">{{ $mainComponent->bahan ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Bekalan Elektrik<br><small>(MSB/SSB/PP/DB...)</small></td>
        <td class="value-cell">{{ $mainComponent->bekalan_elektrik ?? '' }}</td>
        <td class="label-cell">Kaedah Pemasangan</td>
        <td class="value-cell">{{ $mainComponent->kaedah_pemasangan ?? '' }}</td>
    </tr>
</table>

<table style="margin-top: 0;">
    <tr style="background-color: #e0e0e0;">
        <td style="text-align: center; font-weight: bold;" colspan="2">Saiz Fizikal</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Kadaran</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Kapasiti</td>
    </tr>
    <tr style="background-color: #f0f0f0;">
        <td style="text-align: center; width: 8%;"><strong>Unit</strong></td>
        <td style="font-size: 6.5pt; width: 25%;">(Panjang/Tinggi/Lebar/Tebal/Diameter/Jarak dll)</td>
        <td style="text-align: center; width: 8%;"><strong>Unit</strong></td>
        <td style="font-size: 6.5pt; width: 25%;">(Kapacity/Power/Speed/Velocity/Speed dll)</td>
        <td style="text-align: center; width: 8%;"><strong>Unit</strong></td>
        <td style="font-size: 6.5pt; width: 26%;">(Kuasa, Kapasiti/Berampian, Simpanan dll)</td>
    </tr>
    <tr>
        <td style="text-align: center;">{{ $mainComponent->saiz_unit ?? '' }}</td>
        <td>{{ $mainComponent->saiz ?? '' }}</td>
        <td style="text-align: center;">{{ $mainComponent->kadaran_unit ?? '' }}</td>
        <td>{{ $mainComponent->kadaran ?? '' }}</td>
        <td style="text-align: center;">{{ $mainComponent->kapasiti_unit ?? '' }}</td>
        <td>{{ $mainComponent->kapasiti ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="6" style="min-height: 30px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_atribut ?? '' }}</td>
    </tr>
</table>

<!-- KOMPONEN YANG BERHUBUNGKAIT -->
<div class="section-title">** Komponen Yang Berhubungkait (Jika Ada)</div>
<table>
    <tr style="background-color: #e0e0e0; font-weight: bold;">
        <td style="width: 5%; text-align: center;">Bil</td>
        <td style="width: 45%;">Nama Komponen</td>
        <td style="width: 30%;">No. DPA / Kod Ruang / Kod Binaan Luar</td>
        <td style="width: 20%;">No. Tag / Label</td>
    </tr>
    @if($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0)
        @foreach($mainComponent->relatedComponents->take(5) as $related)
        <tr>
            <td style="text-align: center;">{{ $related->bil ?? '' }}</td>
            <td>{{ $related->nama_komponen ?? '' }}</td>
            <td>{{ $related->no_dpa_kod_ruang ?? '' }}</td>
            <td>{{ $related->no_tag_label ?? '' }}</td>
        </tr>
        @endforeach
    @else
        @for($i = 0; $i < 3; $i++)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    @endif
    <tr>
        <td colspan="4" style="min-height: 25px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_komponen_berhubung ?? '' }}</td>
    </tr>
</table>

<!-- DOKUMEN BERKAITAN -->
<div class="section-title">** Dokumen Berkaitan (Jika Ada)</div>
<table>
    <tr style="background-color: #e0e0e0; font-weight: bold;">
        <td style="width: 5%; text-align: center;">Bil</td>
        <td style="width: 35%;">Nama Dokumen</td>
        <td style="width: 30%;">No Rujukan Berkaitan</td>
        <td style="width: 30%;">Catatan</td>
    </tr>
    @if($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0)
        @foreach($mainComponent->relatedDocuments->take(3) as $doc)
        <tr>
            <td style="text-align: center;">{{ $doc->bil ?? '' }}</td>
            <td>{{ $doc->nama_dokumen ?? '' }}</td>
            <td>{{ $doc->no_rujukan_berkaitan ?? '' }}</td>
            <td>{{ $doc->catatan ?? '' }}</td>
        </tr>
        @endforeach
    @else
        @for($i = 0; $i < 2; $i++)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endfor
    @endif
</table>

<!-- Nota -->
<div style="border: 1px solid #000; padding: 4px; margin-top: 6px; font-size: 7pt; background-color: #f5f5f5;">
    <strong>Nota:</strong><br>
    * Sila gunakan lampiran jika Maklumat Aset / Komponen diperolehi bagi kuantiti yang melebihi 1.<br>
    ** Maklumat Spesifikasi itu merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.
</div>

<!-- Muka Surat -->
<div style="text-align: right; margin-top: 8px; font-size: 7pt;">
    Muka surat _____ dari _____
</div>

</div>
</body>
</html>