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
            font-family: 'Arial', 'DejaVu Sans', sans-serif;
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
        
        .doc-code {
            position: absolute;
            top: 50px;
            right: 30px;
            font-size: 10pt;
            font-weight: bold;
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
            text-align: center;
            font-size: 12px;
            line-height: 12px;
        }
        
        .checkbox-box.checked::after {
            /* content: '✓'; */
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
        
        /* Catatan row styling */
        .catatan-row {
            min-height: 50px;
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