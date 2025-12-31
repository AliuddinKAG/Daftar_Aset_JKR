{{-- ==================== INDEX.BLADE.PHP ==================== --}}
@extends('layouts.app')
@section('title', 'Manage SubSistem')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-sliders"></i> SubSistem Management</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.subsistem.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add SubSistem
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
                            <th>Kod SubSistem</th>
                            <th>Nama SubSistem</th>
                            <th>Nama Sistem</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subsistems as $subsistem)
                        <tr>
                            <td>{{ $loop->iteration + ($subsistems->currentPage() - 1) * $subsistems->perPage() }}</td>
                            <td><code>{{ $subsistem->kod_sistem }}</code></td>
                            <td><code>{{ $subsistem->kod_subsistem }}</code></td>
                            <td><strong>{{ $subsistem->nama_subsistem }}</strong></td>
                            <td><small class="text-muted">{{ $subsistem->nama_sistem ?? 'N/A' }}</small></td>
                            <td><small class="text-muted">{{ \Carbon\Carbon::parse($subsistem->created_at)->format('d/m/Y') }}</small></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.subsistem.edit', $subsistem->id) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.subsistem.delete', $subsistem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapuskan subsistem ini?')">
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
                            <td colspan="7" class="text-center text-muted py-4">Tiada subsistem dijumpai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $subsistems->links() }}</div>
        </div>
    </div>
</div>
@endsection

{{-- ==================== CREATE.BLADE.PHP ==================== --}}
@extends('layouts.app')
@section('title', 'Add SubSistem')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col"><h2><i class="bi bi-plus-circle"></i> Add New SubSistem</h2></div>
        <div class="col text-end">
            <a href="{{ route('admin.subsistem.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.subsistem.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kod_sistem" class="form-label">Kod Sistem <span class="text-danger">*</span></label>
                            <select class="form-select @error('kod_sistem') is-invalid @enderror" id="kod_sistem" name="kod_sistem" required>
                                <option value="">-- Pilih Sistem --</option>
                                @foreach($sistems as $sistem)
                                <option value="{{ $sistem->kod_sistem }}" {{ old('kod_sistem') == $sistem->kod_sistem ? 'selected' : '' }}>
                                    {{ $sistem->kod_sistem }} - {{ $sistem->nama_sistem }}
                                </option>
                                @endforeach
                            </select>
                            @error('kod_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="kod_subsistem" class="form-label">Kod SubSistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kod_subsistem') is-invalid @enderror" id="kod_subsistem" name="kod_subsistem" value="{{ old('kod_subsistem') }}" required>
                            @error('kod_subsistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_subsistem" class="form-label">Nama SubSistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_subsistem') is-invalid @enderror" id="nama_subsistem" name="nama_subsistem" value="{{ old('nama_subsistem') }}" required>
                            @error('nama_subsistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                            <a href="{{ route('admin.subsistem.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
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
@section('title', 'Edit SubSistem')
@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col"><h2><i class="bi bi-pencil-square"></i> Edit SubSistem</h2></div>
        <div class="col text-end">
            <a href="{{ route('admin.subsistem.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.subsistem.update', $subsistem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="kod_sistem" class="form-label">Kod Sistem <span class="text-danger">*</span></label>
                            <select class="form-select @error('kod_sistem') is-invalid @enderror" id="kod_sistem" name="kod_sistem" required>
                                <option value="">-- Pilih Sistem --</option>
                                @foreach($sistems as $sistem)
                                <option value="{{ $sistem->kod_sistem }}" {{ old('kod_sistem', $subsistem->kod_sistem) == $sistem->kod_sistem ? 'selected' : '' }}>
                                    {{ $sistem->kod_sistem }} - {{ $sistem->nama_sistem }}
                                </option>
                                @endforeach
                            </select>
                            @error('kod_sistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="kod_subsistem" class="form-label">Kod SubSistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kod_subsistem') is-invalid @enderror" id="kod_subsistem" name="kod_subsistem" value="{{ old('kod_subsistem', $subsistem->kod_subsistem) }}" required>
                            @error('kod_subsistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_subsistem" class="form-label">Nama SubSistem <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_subsistem') is-invalid @enderror" id="nama_subsistem" name="nama_subsistem" value="{{ old('nama_subsistem', $subsistem->nama_subsistem) }}" required>
                            @error('nama_subsistem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                            <a href="{{ route('admin.subsistem.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection