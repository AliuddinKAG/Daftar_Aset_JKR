@extends('layouts.app')

@section('title', 'Subsistem - ' . $sistem->kod)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-diagram-2"></i> Subsistem: {{ $sistem->kod }}
            </h2>
            <p class="text-muted mb-0">{{ $sistem->nama }}</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sistem.index') }}">Sistem</a></li>
                    <li class="breadcrumb-item active">Subsistem</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.sistem.subsistems.create', $sistem) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Subsistem
        </a>
    </div>

    <!-- Subsistem Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kod</th>
                            <th>Nama Subsistem</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subsistems as $subsistem)
                        <tr>
                            <td><code>{{ $subsistem->kod }}</code></td>
                            <td>{{ $subsistem->nama }}</td>
                            <td>
                                @if($subsistem->keterangan)
                                {{ Str::limit($subsistem->keterangan, 60) }}
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($subsistem->is_active)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.sistem.subsistems.edit', [$sistem, $subsistem]) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="deleteSubsistem({{ $subsistem->id }})" 
                                            title="Padam">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $subsistem->id }}" 
                                      action="{{ route('admin.sistem.subsistems.destroy', [$sistem, $subsistem]) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                <p class="text-muted mb-3">Tiada subsistem untuk sistem ini</p>
                                <a href="{{ route('admin.sistem.subsistems.create', $sistem) }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah Subsistem Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subsistems->hasPages())
        <div class="card-footer bg-white">
            {{ $subsistems->links() }}
        </div>
        @endif
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.sistem.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Senarai Sistem
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteSubsistem(subsistemId) {
    if (confirm('Adakah anda pasti ingin memadam subsistem ini?')) {
        document.getElementById('delete-form-' + subsistemId).submit();
    }
}
</script>
@endsection