@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Edit Pengguna</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Asas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Penuh <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                       value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telefon</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" 
                                       value="{{ old('department', $user->department) }}">
                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-gear"></i> Tetapan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Pengguna Biasa</option>
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Akaun</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Akaun Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Nota:</strong> Untuk menukar kata laluan, gunakan butang "Reset Password" di senarai pengguna.
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Kemaskini Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Didaftar pada:</small>
                        <div>{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Login terakhir:</small>
                        <div>
                            @if($user->last_login_at)
                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                            @else
                            <span class="text-muted">Belum login</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">Status:</small>
                        <div>
                            @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Keselamatan</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-3">Untuk menukar kata laluan pengguna ini, gunakan fungsi Reset Password.</p>
                    <a href="{{ route('admin.users.reset-password', $user) }}" class="btn btn-warning w-100">
                        <i class="bi bi-key"></i> Reset Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection