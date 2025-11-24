<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $component->nama_premis ?? 'Komponen' }}</title>
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
        
        /* SCALE KESELURUHAN SUPAYA MUAT 1 PAGE */
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
        
        .doc-code {
            position: absolute;
            top: 50px;
            right: 30px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .section-header {
            background-color: #000;
            color: white;
            padding: 3px 8px;
            font-weight: bold;
            font-size: 9pt;
            margin-top: 8px;
            margin-bottom: 0;
            text-align: center;
            text-transform: uppercase;
        }
        
        .info-group {
            margin-bottom: 10px;
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
            padding: 5px 8px;
            margin: 8px 0;
            position: relative;
        }
        
        .checkbox-header {
            margin-bottom: 5px;
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
        
        .checkbox-label {
            font-weight: bold;
            display: inline-block;
            vertical-align: middle;
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
        
        .signature-section {
            margin-top: 25px;
            display: table;
            width: 100%;
        }
        
        .signature-box {
            display: table-cell;
            width: 48%;
            padding: 0 8px;
            vertical-align: top;
        }
        
        .signature-box:first-child {
            border-right: 1px solid #ccc;
        }
        
        .signature-title {
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
            font-size: 9pt;
        }
        
        .signature-field {
            margin-bottom: 10px;
        }
        
        .signature-field label {
            display: block;
            margin-bottom: 2px;
            font-size: 9pt;
        }
        
        .signature-field .field-line {
            border-bottom: 1px solid #000;
            min-height: 18px;
            padding: 2px 4px;
        }
        
        .bottom-note {
            position: fixed;
            bottom: 15px;
            right: 25px;
            font-size: 8pt;
            font-style: italic;
        }
        
        @media print {
            body {
                padding: 50px 30px 50px 30px !important;
            }
            
            .page-wrapper {
                transform: scale(0.95);
                transform-origin: top center;
            }
            
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Page Wrapper untuk scaling -->
    <div class="page-wrapper">
    
    <!-- Document Code -->
    <div class="doc-code">D.A 6</div>
    
    <!-- Header -->
    <div class="page-header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <h2>Peringkat Komponen</h2>
    </div>

    <!-- MAKLUMAT LOKASI KOMPONEN -->
    <div style="margin-top: 10px;">
        <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">MAKLUMAT LOKASI KOMPONEN</div>
        
        <div class="info-row">
            <span class="info-label">Nama Premis</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $component->nama_premis ?? '' }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Nombor DPA</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $component->nombor_dpa ?? '' }}</span>
        </div>
    </div>

    <!-- BLOK Section -->
    <div class="checkbox-section">
        <div class="checkbox-header">
            <span class="checkbox-box {{ $component->ada_blok ? 'checked' : '' }}"></span>
            <span class="checkbox-label">Blok</span>
            <span style="margin-left: 10px; font-size: 10pt; font-family: 'Courier New', monospace;">(Tandakan 'v' jika berkenaan)</span>
        </div>
        
        @if($component->ada_blok)
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Kod Blok</td>
                    <td class="value-col">{{ $component->kod_blok ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->kod_aras ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->kod_ruang ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->nama_ruang ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col" style="vertical-align: top;">Catatan:</td>
                    <td class="value-col">
                        <div class="catatan-box">{{ $component->catatan_blok ?? '' }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Kod Blok</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; height: 55px;">
                        <strong>Catatan:</strong><br>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>

    <!-- BINAAN LUAR Section -->
    <div class="checkbox-section">
        <div class="checkbox-header">
            <span class="checkbox-box {{ $component->ada_binaan_luar ? 'checked' : '' }}"></span>
            <span class="checkbox-label">Binaan Luar</span>
            <span style="margin-left: 10px; font-size: 10pt; font-family: 'Courier New', monospace;">(Tandakan 'v' jika berkenaan)</span>
        </div>
        
        @if($component->ada_binaan_luar)
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Nama Binaan Luar</td>
                    <td class="value-col">{{ $component->nama_binaan_luar ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Binaan Luar</td>
                    <td class="value-col">{{ $component->kod_binaan_luar ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Koordinat GPS (WGS 84)</td>
                    <td class="value-col">
                        X : {{ $component->koordinat_x ?? '' }}<br>
                        Y : {{ $component->koordinat_y ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #e8e8e8; font-weight: bold;">
                        Diisi Jika Binaan Luar Mempunyai Aras dan Ruang
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->kod_aras_binaan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->kod_ruang_binaan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->nama_ruang_binaan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label-col" style="vertical-align: top;">Catatan:</td>
                    <td class="value-col">
                        <div class="catatan-box">{{ $component->catatan_binaan ?? '' }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Nama Binaan Luar</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Binaan Luar</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Koordinat GPS (WGS 84)</td>
                    <td class="value-col">
                        X : <span style="margin-left: 100px;"></span> ( Cth X : 2.935905 )<br>
                        Y : <span style="margin-left: 100px;"></span> ( Cth Y : 101.700286)
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #e8e8e8; font-weight: bold;">
                        Diisi Jika Binaan Luar Mempunyai Aras dan Ruang
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; height: 55px;">
                        <strong>Catatan:</strong><br>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>

    <!-- SIGNATURE SECTION -->
    <div style="margin-top: 18px; width: 100%;">
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tr>
                <!-- PENGUMPUL DATA -->
                <td style="width: 50%; vertical-align: top; padding-right: 30px; border: none;">
                    <div style="font-weight: bold; margin-bottom: 8px; text-transform: uppercase; font-size: 9pt;">PENGUMPUL DATA :</div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 13px; font-size: 9pt;">Tandatangan :</div>
                        <div style="border: 1px solid #000; height: 40px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Nama :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Jawatan :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Tarikh :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                </td>
                
                <!-- PENGESAH DATA -->
                <td style="width: 50%; vertical-align: top; padding-left: 30px; border: none;">
                    <div style="font-weight: bold; margin-bottom: 8px; text-transform: uppercase; font-size: 9pt;">PENGESAH DATA :</div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 13px; font-size: 9pt;">Tandatangan :</div>
                        <div style="border: 1px solid #000; height: 40px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Nama :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative; margin-bottom: 0;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Jawatan :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                    
                    <div style="position: relative;">
                        <div style="position: absolute; left: 0; top: 7px; font-size: 9pt;">Tarikh :</div>
                        <div style="border: 1px solid #000; height: 28px; margin-left: 90px;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER PAGE COUNT -->
    <div style="margin-top: 12px; text-align: right; font-size: 8pt; font-style: italic; border: 1px solid #000; padding: 5px 10px; display: inline-block; float: right;">
        Muka surat _____ dari _____
    </div>
    
    </div><!-- End Page Wrapper -->
</body>
</html>