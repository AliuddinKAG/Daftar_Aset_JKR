@extends('layouts.app')

@section('title', 'User Components - ' . $user->username)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="bi bi-person-circle"></i> {{ $user->username }}'s Components</h2>
            <p class="text-muted">
                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }}">{{ ucfirst($user->role) }}</span>
                <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} ms-2">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($components->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kemudahan</th>
                            <th>Kod Aset</th>
                            <th class="text-center">Main Components</th>
                            <th class="text-center">Sub Components</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($components as $component)
                        <tr>
                            <td>{{ $loop->iteration + ($components->currentPage() - 1) * $components->perPage() }}</td>
                            <td>
                                <i class="bi bi-box-seam text-primary"></i>
                                <strong>{{ $component->nama_kemudahan }}</strong>
                            </td>
                            <td>
                                <code>{{ $component->kod_aset }}</code>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $component->mainComponents->count() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning">
                                    {{ $component->mainComponents->sum(fn($mc) => $mc->subComponents->count()) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $component->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('components.show', $component) }}" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $components->links() }}
            </div>
            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">User ini belum register sebarang komponen</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection