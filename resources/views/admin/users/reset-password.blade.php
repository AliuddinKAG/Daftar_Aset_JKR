@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-key"></i> Reset Kata Laluan</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                        <li class="breadcrumb-item active">Reset Password</li>
                    </ol>
                </nav>
            </div>

            <!-- User Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-person-fill text-primary fs-3"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">@{{ $user->username }} • {{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reset Password Form -->
            <form action="{{ route('admin.users.reset-password.post', $user) }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Kata Laluan Baru</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Anda akan menetapkan kata laluan baru untuk pengguna ini. Pastikan anda memaklumkan kata laluan baharu kepada pengguna.
                        </div>

                        <div class="row g-3">
                            <!-- New Password -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Kata Laluan Baru <span class="text-danger">*</span></label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                                <small class="text-muted">Minimum 6 aksara</small>
                                @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Sahkan Kata Laluan <span class="text-danger">*</span></label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Reset Password
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection