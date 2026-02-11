{{-- resources/views/components/partials/export-buttons.blade.php --}}
{{-- Usage: @include('components.partials.export-buttons', ['item' => $component, 'type' => 'component']) --}}

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0"><i class="bi bi-download"></i> EXPORT LAPORAN</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- PDF Export -->
            <div class="col-md-6 mb-3">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <i class="bi bi-file-pdf text-danger" style="font-size: 3rem;"></i>
                        <h6 class="mt-2">Export ke PDF</h6>
                        <p class="text-muted small">Format dokumen untuk cetak</p>
                        <div class="d-grid gap-2">
                            @if($type === 'component')
                                <a href="{{ route('export.component.pdf', $item) }}" class="btn btn-danger" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Download PDF
                                </a>
                                <a href="{{ route('export.complete-report.pdf', $item) }}" class="btn btn-outline-danger">
                                    <i class="bi bi-file-pdf"></i> Laporan Lengkap (PDF)
                                </a>
                            @elseif($type === 'main-component')
                                <a href="{{ route('export.main-component.pdf', $item) }}" class="btn btn-danger" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Download PDF
                                </a>
                            @elseif($type === 'sub-component')
                                <a href="{{ route('export.sub-component.pdf', $item) }}" class="btn btn-danger" target="_blank">
                                    <i class="bi bi-file-pdf"></i> Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Excel Export -->
            <div class="col-md-6 mb-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-file-excel text-success" style="font-size: 3rem;"></i>
                        <h6 class="mt-2">Export ke Excel</h6>
                        <p class="text-muted small">Format spreadsheet untuk analisis</p>
                        <div class="d-grid gap-2">
                            @if($type === 'component')
                                <a href="{{ route('export.component.excel', $item) }}" class="btn btn-success">
                                    <i class="bi bi-file-excel"></i> Download Excel
                                </a>
                                <a href="{{ route('export.complete-report.excel', $item) }}" class="btn btn-outline-success">
                                    <i class="bi bi-file-excel"></i> Laporan Lengkap (Excel)
                                </a>
                            @elseif($type === 'main-component')
                                <a href="{{ route('export.main-component.excel', $item) }}" class="btn btn-success">
                                    <i class="bi bi-file-excel"></i> Download Excel
                                </a>
                            @elseif($type === 'sub-component')
                                <a href="{{ route('export.sub-component.excel', $item) }}" class="btn btn-success">
                                    <i class="bi bi-file-excel"></i> Download Excel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3 mb-0">
            <i class="bi bi-info-circle"></i> 
            <strong>Tip:</strong> Laporan lengkap mengandungi semua maklumat komponen, komponen utama, dan sub komponen dalam satu fail.
        </div>
    </div>
</div>