<div class="page-wrapper" style="padding: 50px 30px; font-size: 9pt; line-height: 1.2;">
    
    <!-- Document Code -->
    <div class="doc-code">D.A 6</div>
    
    <!-- Header -->
    <div class="page-header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <h2>Peringkat Komponen</h2>
    </div>

    <!-- MAKLUMAT LOKASI KOMPONEN -->
    <div style="margin-top: 10px;">
        <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt; text-decoration: underline;">
            MAKLUMAT LOKASI KOMPONEN
        </div>
        
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
            <span class="checkbox-box">
                @if($component->ada_blok)
                    ✓
                @endif
            </span>
            <span class="checkbox-label">Blok (Tandakan '✓' jika berkenaan)</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col" style="width: 30%;">Kod Blok</td>
                    <td class="value-col" style="width: 70%;">{{ $component->kod_blok ?? ' ' }} - {{ $component->nama_blok ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->kod_aras ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->kod_ruang ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->nama_ruang ?? ' ' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="catatan-row">
                        <strong>Catatan:</strong><br>
                        {{ $component->catatan_blok ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- BINAAN LUAR Section -->
    <div class="checkbox-section">
        <div class="checkbox-header">
            <span class="checkbox-box">
                @if($component->ada_binaan_luar)
                    ✓
                @endif
            </span>
            <span class="checkbox-label">Binaan Luar (Tandakan '✓' jika berkenaan)</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Nama Binaan Luar</td>
                    <td class="value-col">{{ $component->nama_binaan_luar ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Binaan Luar</td>
                    <td class="value-col">{{ $component->kod_binaan_luar ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Koordinat GPS (WGS 84)</td>
                    <td class="value-col">
                        @if($component->koordinat_x || $component->koordinat_y)
                            X : {{ $component->koordinat_x ?? '' }}<br>
                            Y : {{ $component->koordinat_y ?? '' }}
                        @else
                            X : <span style="margin-left: 100px;"></span><br>
                            Y : <span style="margin-left: 100px;"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #f5f5f5; font-weight: bold; text-align: left;">
                        Diisi Jika Binaan Luar Mempunyai Aras dan Ruang
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->kod_aras_binaan ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->kod_ruang_binaan ?? ' ' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->nama_ruang_binaan ?? ' ' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="catatan-row">
                        <strong>Catatan:</strong><br>
                        {{ $component->catatan_binaan ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SIGNATURE SECTION -->
    <div style="margin-top: 18px; width: 100%;">
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tr>
                <!-- PENGUMPUL DATA -->
                <td style="width: 50%; vertical-align: top; padding-right: 20px; border: none;">
                    <div style="position: relative; margin-left: 90px;">
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 9pt; padding: 6px 0; text-align: left; border-bottom: 1px solid #fff;">
                            PENGUMPUL DATA :
                        </div>
                        
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #fff; border-top: none;">
                            <tr>
                                <td style="height: 55px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px;"></td>
                            </tr>
                        </table>
                        
                        <div style="position: absolute; top: 47px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tandatangan :
                        </div>
                        <div style="position: absolute; top: 107px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Nama :
                        </div>
                        <div style="position: absolute; top: 147px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Jawatan :
                        </div>
                        <div style="position: absolute; top: 187px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tarikh :
                        </div>
                    </div>
                </td>
                
                <!-- PENGESAH DATA -->
                <td style="width: 50%; vertical-align: top; padding-left: 20px; border: none;">
                    <div style="position: relative; margin-left: 90px;">
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 9pt; padding: 6px 0; text-align: left; border-bottom: 1px solid #fff;">
                            PENGESAH DATA :
                        </div>
                        
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #fff; border-top: none;">
                            <tr>
                                <td style="height: 55px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px;"></td>
                            </tr>
                        </table>
                        
                        <div style="position: absolute; top: 47px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tandatangan :
                        </div>
                        <div style="position: absolute; top: 107px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Nama :
                        </div>
                        <div style="position: absolute; top: 147px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Jawatan :
                        </div>
                        <div style="position: absolute; top: 187px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tarikh :
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
</div>