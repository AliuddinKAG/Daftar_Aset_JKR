@extends('layouts.app')

@section('title', 'Pengurusan Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-people"></i> Pengurusan Pengguna</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengguna</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Tambah Pengguna
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, username atau email" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Pengguna</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                        <i class="bi bi-person-fill text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        @if($user->phone)
                                        <small class="text-muted"><i class="bi bi-telephone"></i> {{ $user->phone }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $user->username }}</code></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                                @else
                                <span class="badge bg-primary">User</span>
                                @endif
                            </td>
                            <td>{{ $user->department ?? '-' }}</td>
                            <td>
                                @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($user->last_login_at)
                                <small>{{ $user->last_login_at->diffForHumans() }}</small>
                                @else
                                <small class="text-muted">Belum login</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning" 
                                            onclick="toggleStatus({{ $user->id }})" 
                                            title="{{ $user->is_active ? 'Nyahaktifkan' : 'Aktifkan' }}"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                    </button>
                                    <a href="{{ route('admin.users.reset-password', $user) }}" class="btn btn-outline-info" title="Reset Password">
                                        <i class="bi bi-key"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="deleteUser({{ $user->id }})"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                            title="Padam">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <form id="toggle-form-{{ $user->id }}" action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tiada pengguna dijumpai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteUser(userId) {
    if (confirm('Adakah anda pasti ingin memadam pengguna ini?')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}

function toggleStatus(userId) {
    if (confirm('Adakah anda pasti ingin mengubah status pengguna ini?')) {
        document.getElementById('toggle-form-' + userId).submit();
    }
}
</script>
@endsection