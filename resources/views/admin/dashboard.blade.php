@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->username }}!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                    <p class="text-muted mb-0">Total Users</p>
                    <small class="text-success">
                        <i class="bi bi-check-circle-fill"></i> 
                        {{ $stats['active_users'] }} Active
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="mb-0">{{ $stats['total_components'] }}</h3>
                    <p class="text-muted mb-0">Komponen</p>
                    <small class="text-muted">Borang 1</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-layers"></i>
                    </div>
                    <h3 class="mb-0">{{ $stats['total_main_components'] }}</h3>
                    <p class="text-muted mb-0">Main Komponen</p>
                    <small class="text-muted">Borang 2</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <h3 class="mb-0">{{ $stats['total_sub_components'] }}</h3>
                    <p class="text-muted mb-0">Sub Komponen</p>
                    <small class="text-muted">Borang 3</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-lightning-fill text-warning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.sistem.index') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-gear"></i> Manage Sistem
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.subsistem.index') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-sliders"></i> Manage SubSistem
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('components.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-list-ul"></i> View All Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Activity -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-activity text-primary"></i> User Activity</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Username</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Components</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userActivity->take(5) as $user)
                                <tr>
                                    <td>
                                        <i class="bi bi-person-circle text-primary"></i>
                                        {{ $user->username }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'primary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.components', $user) }}" class="text-decoration-none">
                                            <span class="badge bg-info">
                                                {{ $user->components_count + $user->main_components_count + $user->sub_components_count }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if($user->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Tiada data user
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Components -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history text-info"></i> Recent Components</h5>
                    <a href="{{ route('components.index') }}" class="btn btn-sm btn-outline-info">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentComponents as $component)
                        <a href="{{ route('components.show', $component) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $component->nama_kemudahan }}</h6>
                                <small class="text-muted">{{ $component->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> {{ $component->user->username ?? 'N/A' }}
                                </small>
                            </p>
                        </a>
                        @empty
                        <div class="list-group-item text-center text-muted">
                            Tiada komponen terkini
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection