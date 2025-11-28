<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Lengkap - {{ $component->nama_premis }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'DejaVu Sans', 'sans-serif';
            font-size: 9pt;
            line-height: 1.2;
            color: #000;
            background: #fff;
        }
        
        /* Page break after each section */
        .page-break {
            page-break-after: always;
        }
        
        .no-break {
            page-break-inside: avoid;
        }
        
        /* Reuse styles from your existing PDFs */
        .page-wrapper {
            padding: 50px 30px;
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
            text-decoration: underline;
        }
        
        .page-header h2 {
            font-size: 10pt;
            font-weight: normal;
            text-decoration: underline;
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
        }
        
        .label-cell {
            background-color: #f5f5f5;
            font-weight: normal;
            width: 30%;
        }
        
        .value-cell {
            background-color: #fff;
            width: 70%;
        }
        
        .section-title {
            background-color: #000;
            color: white;
            padding: 4px 6px;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
        }
        
        .checkbox-box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #000;
            margin-right: 6px;
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
            line-height: 12px;
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
        }
        
        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

<!-- SECTION 1: COMPONENT (BORANG 1) -->
<div class="page-wrapper page-break">
    <div class="page-header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <h2>Peringkat Komponen</h2>
    </div>
    
    @include('exports.pdf.partials.component-details', ['component' => $component])
</div>

<!-- SECTION 2: MAIN COMPONENTS (BORANG 2) -->
@foreach($component->mainComponents as $index => $mainComponent)
<div class="page-wrapper {{ $loop->last && $component->mainComponents->sum(fn($mc) => $mc->subComponents->count()) == 0 ? '' : 'page-break' }}">
    <div class="page-header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <h2>Peringkat Komponen Utama ({{ $index + 1 }}/{{ $component->mainComponents->count() }})</h2>
    </div>
    
    @include('exports.pdf.partials.main-component-details', ['mainComponent' => $mainComponent])
</div>

    <!-- SECTION 3: SUB COMPONENTS for this Main Component -->
    @foreach($mainComponent->subComponents as $subIndex => $subComponent)
    <div class="page-wrapper {{ $loop->parent->last && $loop->last ? '' : 'page-break' }}">
        <div class="page-header">
            <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
            <h2>Peringkat Sub Komponen ({{ $subIndex + 1 }}/{{ $mainComponent->subComponents->count() }})</h2>
        </div>
        
        @include('exports.pdf.partials.sub-component-details', ['subComponent' => $subComponent])
    </div>
    @endforeach
@endforeach

</body>
</html>