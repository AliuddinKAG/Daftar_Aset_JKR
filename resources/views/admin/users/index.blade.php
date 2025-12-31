@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-people-fill"></i> User Management</h2>
            <p class="text-muted">Manage all registered users</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New User
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
                            <th>Username</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Components</th>
                            <th class="text-center">Main</th>
                            <th class="text-center">Sub</th>
                            <th>Registered</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <i class="bi bi-person-circle text-primary"></i>
                                <strong>{{ $user->username }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $user->components_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $user->main_components_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning">{{ $user->sub_components_count }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.users.components', $user) }}" 
                                       class="btn btn-outline-info" 
                                       title="View Components">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.delete', $user) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Adakah anda pasti mahu hapuskan user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1"></i>
                                <p>Tiada user dijumpai</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection