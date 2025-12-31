{{-- ==================== INDEX.BLADE.PHP ==================== --}}
@extends('layouts.app')
@section('title', 'Manage Sistem')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-gear-fill"></i> Sistem Management</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.sistem.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Sistem
            </a>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kod Sistem</th>
                            <th>Nama Sistem</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sistems as $sistem)
                        <tr>
                            <td>{{ $loop->iteration + ($sistems->currentPage() - 1) * $sistems->perPage() }}</td>
                            <td><code>{{ $sistem->kod_sistem }}</code></td>
                            <td><strong>{{ $sistem->nama_sistem }}</strong></td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($sistem->created_at)->format('d/m/Y') }}</small></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.sistem.edit', $sistem->id) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.sistem.delete', $sistem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapuskan sistem ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Tiada sistem dijumpai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $sistems->links() }}</div>
        </div>
    </div>
</div>
@endsection

{{-- ==================== CREATE.BLADE.PHP ==================== --}}
@extends('layouts.app')
@section('title', 'Add Sistem')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col"><h2><i class="bi bi-plus-circle"></i> Add New Sistem</h2></div>
        <div class="col text-end">
            <a href="{{ route('admin.sistem.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.sistem.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kod_sistem" class="form-label">Kod Sistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kod_sistem') is-invalid @enderror" id="kod_sistem" name="kod_sistem" value="{{ old('kod_sistem') }}" required>
                            @error('kod_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_sistem" class="form-label">Nama Sistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sistem') is-invalid @enderror" id="nama_sistem" name="nama_sistem" value="{{ old('nama_sistem') }}" required>
                            @error('nama_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                            <a href="{{ route('admin.sistem.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ==================== EDIT.BLADE.PHP ==================== --}}
@extends('layouts.app')
@section('title', 'Edit Sistem')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col"><h2><i class="bi bi-pencil-square"></i> Edit Sistem</h2></div>
        <div class="col text-end">
            <a href="{{ route('admin.sistem.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.sistem.update', $sistem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="kod_sistem" class="form-label">Kod Sistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kod_sistem') is-invalid @enderror" id="kod_sistem" name="kod_sistem" value="{{ old('kod_sistem', $sistem->kod_sistem) }}" required>
                            @error('kod_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_sistem" class="form-label">Nama Sistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sistem') is-invalid @enderror" id="nama_sistem" name="nama_sistem" value="{{ old('nama_sistem', $sistem->nama_sistem) }}" required>
                            @error('nama_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                            <a href="{{ route('admin.sistem.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection