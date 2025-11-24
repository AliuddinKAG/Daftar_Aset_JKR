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
            font-size: 9pt;
            line-height: 1.2;
            color: #000;
            padding: 50px 30px 50px 30px !important;
            background: #fff;
        }
        
        .page-wrapper {
            transform: scale(0.95);
            transform-origin: top center;
            width: 100%;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .page-header h1 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .page-header h2 {
            font-size: 10pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .section-header {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 9pt;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 2px;
        }
        
        .info-label {
            display: table-cell;
            width: 100px;
            font-weight: normal;
            padding-right: 8px;
            vertical-align: top;
            font-size: 9pt;
        }
        
        .info-separator {
            display: table-cell;
            width: 8px;
            text-align: center;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            border-bottom: 1px solid #000;
            padding: 0 4px 1px 4px;
            min-height: 16px;
            font-size: 9pt;
        }
        
        .checkbox-section {
            border: 1px solid #000;
            padding: 5px 8px;
            margin: 8px 0;
        }
        
        .checkbox-box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #000;
            margin-right: 6px;
            vertical-align: middle;
            position: relative;
            background: #fff;
        }
        
        .checkbox-box.checked::after {
            content: '✓';
            position: absolute;
            top: -4px;
            left: 1px;
            font-size: 16px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        
        table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            font-size: 9pt;
        }
        
        table th {
            border: 1px solid #000;
            background-color: #000;
            color: white;
            padding: 4px 6px;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
        }
        
        .label-col {
            width: 30%;
            background-color: #e8e8e8;
            font-weight: normal;
        }
        
        .value-col {
            width: 70%;
            background-color: #fff;
        }
        
        .catatan-box {
            border: 1px solid #000;
            min-height: 40px;
            padding: 4px;
            margin-top: 2px;
            font-size: 9pt;
        }
        
        @media print {
            body {
                padding: 50px 30px 50px 30px !important;
            }
            
            .page-wrapper {
                transform: scale(0.95);
                transform-origin: top center;
            }
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
        <div class="section-header">MAKLUMAT LOKASI KOMPONEN</div>
        
        <div class="info-row">
            <span class="info-label">Nama Premis</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $mainComponent->component->nama_premis ?? '' }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Nombor DPA</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $mainComponent->component->nombor_dpa ?? '' }}</span>
        </div>
    </div>

    <!-- MAKLUMAT KOMPONEN UTAMA Section -->
    <div style="margin-top: 15px;">
        <div class="section-header">MAKLUMAT KOMPONEN UTAMA</div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Utama</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Nama Komponen Utama</td>
                    <td class="value-col">{{ $mainComponent->nama_komponen_utama ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Lokasi</td>
                    <td class="value-col">{{ $mainComponent->kod_lokasi ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Sistem</td>
                    <td class="value-col">{{ $mainComponent->sistem ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">SubSistem</td>
                    <td class="value-col">{{ $mainComponent->subsistem ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kuantiti<br><span style="font-size: 8pt;">(Komponen yang sama jenis)</span></td>
                    <td class="value-col">{{ $mainComponent->kuantiti ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Gambar Komponen</td>
                    <td class="value-col">{{ $mainComponent->gambar_komponen ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bidang Kejuruteraan -->
    <div style="margin-top: 10px;">
        <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">Bidang Kejuruteraan Komponen:</div>
        
        <div class="checkbox-section">
            <div style="margin-bottom: 5px;">
                <span class="checkbox-box {{ $mainComponent->awam_arkitek ? 'checked' : '' }}"></span>
                <span>Awam/Arkitek</span>
                
                <span style="margin-left: 30px;" class="checkbox-box {{ $mainComponent->elektrikal ? 'checked' : '' }}"></span>
                <span>Elektrikal</span>
                
                <span style="margin-left: 30px;" class="checkbox-box {{ $mainComponent->elv_ict ? 'checked' : '' }}"></span>
                <span>ELV/ICT</span>
            </div>
            <div>
                <span class="checkbox-box {{ $mainComponent->mekanikal ? 'checked' : '' }}"></span>
                <span>Mekanikal</span>
                
                <span style="margin-left: 30px;" class="checkbox-box {{ $mainComponent->bio_perubatan ? 'checked' : '' }}"></span>
                <span>Bio Perubatan</span>
                
                <span style="margin-left: 30px;">Lain-lain:</span>
                <span style="border-bottom: 1px solid #000; display: inline-block; min-width: 150px; padding: 0 4px;">{{ $mainComponent->lain_lain ?? '' }}</span>
            </div>
        </div>
    </div>

    <div style="border: 1px solid #000; padding: 4px; font-size: 9pt; margin-top: 5px;">
        <strong>Catatan:</strong><br>
        {{ $mainComponent->catatan ?? '' }}
    </div>

    <!-- MAKLUMAT PEROLEHAN -->
    <div style="margin-top: 15px;">
        <div class="section-header">MAKLUMAT PEROLEHAN</div>
        
        <div style="display: table; width: 100%;">
            <div style="display: table-cell; width: 50%; padding-right: 10px; vertical-align: top;">
                <table>
                    <tr>
                        <td class="label-col">Tarikh Perolehan</td>
                        <td class="value-col">{{ $mainComponent->tarikh_perolehan?->format('d/m/Y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Kos Perolehan/Kontrak</td>
                        <td class="value-col">{{ $mainComponent->kos_perolehan ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">No. Pesanan Rasmi Kerajaan/Kontrak</td>
                        <td class="value-col">{{ $mainComponent->no_pesanan_rasmi_kontrak ?? '' }}</td>
                    </tr>
                </table>
            </div>
            
            <div style="display: table-cell; width: 50%; padding-left: 10px; vertical-align: top;">
                <table>
                    <tr>
                        <td class="label-col">Tarikh Dipasang</td>
                        <td class="value-col">{{ $mainComponent->tarikh_dipasang?->format('d/m/Y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Tarikh Waranti Tamat</td>
                        <td class="value-col">{{ $mainComponent->tarikh_waranti_tamat?->format('d/m/Y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Tarikh Tamat DLP</td>
                        <td class="value-col">{{ $mainComponent->tarikh_tamat_dlp?->format('d/m/Y') ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Jangka Hayat</td>
                        <td class="value-col">{{ $mainComponent->jangka_hayat ?? '' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Pengilang, Pembekal, Kontraktor -->
        <div style="display: table; width: 100%; margin-top: 10px;">
            <div style="display: table-cell; width: 33.33%; padding-right: 5px; vertical-align: top;">
                <div style="border: 1px solid #000; padding: 6px; min-height: 120px;">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 8pt;">Pengilang</div>
                    <div style="font-size: 8pt;">
                        <div style="margin-bottom: 3px;"><strong>Nama:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px;">{{ $mainComponent->nama_pengilang ?? '' }}</div>
                    </div>
                </div>
            </div>
            
            <div style="display: table-cell; width: 33.33%; padding: 0 2.5px; vertical-align: top;">
                <div style="border: 1px solid #000; padding: 6px; min-height: 120px;">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 8pt;">Pembekal</div>
                    <div style="font-size: 8pt;">
                        <div style="margin-bottom: 3px;"><strong>Nama:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px; margin-bottom: 3px;">{{ $mainComponent->nama_pembekal ?? '' }}</div>
                        <div style="margin-bottom: 3px;"><strong>Alamat:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px; margin-bottom: 3px;">{{ $mainComponent->alamat_pembekal ?? '' }}</div>
                        <div style="margin-bottom: 3px;"><strong>No. Telefon:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px;">{{ $mainComponent->no_telefon_pembekal ?? '' }}</div>
                    </div>
                </div>
            </div>
            
            <div style="display: table-cell; width: 33.33%; padding-left: 5px; vertical-align: top;">
                <div style="border: 1px solid #000; padding: 6px; min-height: 120px;">
                    <div style="font-weight: bold; margin-bottom: 5px; font-size: 8pt;">Kontraktor</div>
                    <div style="font-size: 8pt;">
                        <div style="margin-bottom: 3px;"><strong>Nama:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px; margin-bottom: 3px;">{{ $mainComponent->nama_kontraktor ?? '' }}</div>
                        <div style="margin-bottom: 3px;"><strong>Alamat:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px; margin-bottom: 3px;">{{ $mainComponent->alamat_kontraktor ?? '' }}</div>
                        <div style="margin-bottom: 3px;"><strong>No. Telefon:</strong></div>
                        <div style="border-bottom: 1px solid #000; min-height: 16px; padding: 2px;">{{ $mainComponent->no_telefon_kontraktor ?? '' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="border: 1px solid #000; padding: 4px; font-size: 9pt; margin-top: 5px;">
            <strong>Catatan:</strong><br>
            {{ $mainComponent->catatan_maklumat ?? '' }}
        </div>
    </div>

    <!-- MAKLUMAT KOMPONEN -->
    <div style="margin-top: 15px;">
        <div class="section-header">MAKLUMAT KOMPONEN</div>
        
        <table>
            <tr>
                <td class="label-col">Deskripsi</td>
                <td class="value-col" rowspan="2" style="vertical-align: top;">{{ $mainComponent->deskripsi ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">Status Komponen</td>
            </tr>
        </table>

        <table style="margin-top: 5px;">
            <tr>
                <td class="label-col">Jenama</td>
                <td class="value-col">{{ $mainComponent->jenama ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">Model</td>
                <td class="value-col">{{ $mainComponent->model ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">No. Siri</td>
                <td class="value-col">{{ $mainComponent->no_siri ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">No. Tag / Label (Jika berkenaan)</td>
                <td class="value-col">{{ $mainComponent->no_tag_label ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">No Sijil Pendaftaran (Jika ada)</td>
                <td class="value-col">{{ $mainComponent->no_sijil_pendaftaran ?? '' }}</td>
            </tr>
        </table>
    </div>

    <!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
    <div style="margin-top: 15px;">
        <div class="section-header">** MAKLUMAT ATRIBUT SPESIFIKASI</div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Atribut Spesifikasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Jenis</td>
                    <td class="value-col">{{ $mainComponent->jenis ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Bekalan Elektrik<br><span style="font-size: 8pt;">(MSB/SSB/PP/DB...)</span></td>
                    <td class="value-col">{{ $mainComponent->bekalan_elektrik ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Bahan</td>
                    <td class="value-col">{{ $mainComponent->bahan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kaedah Pemasangan</td>
                    <td class="value-col">{{ $mainComponent->kaedah_pemasangan ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top: 10px;">
            <thead>
                <tr>
                    <th colspan="2">Saiz Fizikal</th>
                    <th colspan="2">Kadaran</th>
                    <th colspan="2">Kapasiti</th>
                </tr>
                <tr>
                    <th style="background-color: #e8e8e8; color: #000;">Unit</th>
                    <th style="background-color: #e8e8e8; color: #000; font-size: 7pt;">(Panjang/Tinggi/Lebar/<br>Tebal/Diameter/Jarak dll)</th>
                    <th style="background-color: #e8e8e8; color: #000;">Unit</th>
                    <th style="background-color: #e8e8e8; color: #000; font-size: 7pt;">(Velocity/Speed dll)</th>
                    <th style="background-color: #e8e8e8; color: #000;">Unit</th>
                    <th style="background-color: #e8e8e8; color: #000; font-size: 7pt;">(Kuasa, Kapasiti/<br>Beramaian, Simpanan dll)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ $mainComponent->saiz_unit ?? '' }}</td>
                    <td>{{ $mainComponent->saiz ?? '' }}</td>
                    <td style="text-align: center;">{{ $mainComponent->kadaran_unit ?? '' }}</td>
                    <td>{{ $mainComponent->kadaran ?? '' }}</td>
                    <td style="text-align: center;">{{ $mainComponent->kapasiti_unit ?? '' }}</td>
                    <td>{{ $mainComponent->kapasiti ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        <div style="border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; min-height: 55px; margin-top: 5px;">
            <strong>Catatan:</strong><br>
            {{ $mainComponent->catatan_atribut ?? '' }}
        </div>
    </div>

    <!-- KOMPONEN YANG BERHUBUNGKAIT -->
    <div style="margin-top: 15px;">
        <div class="section-header">** Komponen Yang Berhubungkait (Jika Ada)</div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">Bil</th>
                    <th width="45%">Nama Komponen</th>
                    <th width="30%">No. DPA / Kod Ruang / Kod Binaan Luar</th>
                    <th width="20%">No. Tag / Label</th>
                </tr>
            </thead>
            <tbody>
                @if($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0)
                    @foreach($mainComponent->relatedComponents as $related)
                    <tr>
                        <td style="text-align: center;">{{ $related->bil ?? '' }}</td>
                        <td>{{ $related->nama_komponen ?? '' }}</td>
                        <td>{{ $related->no_dpa_kod_ruang ?? '' }}</td>
                        <td>{{ $related->no_tag_label ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div style="border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; min-height: 40px; margin-top: 5px;">
            <strong>Catatan:</strong><br>
            {{ $mainComponent->catatan_komponen_berhubung ?? '' }}
        </div>
    </div>

    <!-- DOKUMEN BERKAITAN -->
    <div style="margin-top: 15px;">
        <div class="section-header">** Dokumen Berkaitan (Jika Ada)</div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">Bil</th>
                    <th width="35%">Nama Dokumen</th>
                    <th width="30%">No Rujukan Berkaitan</th>
                    <th width="30%">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @if($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0)
                    @foreach($mainComponent->relatedDocuments as $doc)
                    <tr>
                        <td style="text-align: center;">{{ $doc->bil ?? '' }}</td>
                        <td>{{ $doc->nama_dokumen ?? '' }}</td>
                        <td>{{ $doc->no_rujukan_berkaitan ?? '' }}</td>
                        <td>{{ $doc->catatan ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div style="border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; min-height: 40px; margin-top: 5px;">
            <strong>Catatan:</strong><br>
            {{ $mainComponent->catatan_dokumen ?? '' }}
        </div>

        <div style="border: 1px solid #000; padding: 8px; font-size: 8pt; margin-top: 10px; background-color: #f9f9f9;">
            <strong>Nota:</strong><br>
            <div style="margin-top: 4px;">* Sila gunakan lampiran jika Maklumat Aset / Komponen diperolehi bagi kuantiti yang melebihi 1.</div>
            <div>** Maklumat Spesifikasi itu merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.</div>
        </div>
    </div>

    <!-- FOOTER PAGE COUNT -->
    <div style="margin-top: 12px; text-align: right; font-size: 8pt; font-style: italic; border: 1px solid #000; padding: 5px 10px; display: inline-block; float: right;">
        Muka surat _____ dari _____
    </div>
    
    </div>
</body>
</html>