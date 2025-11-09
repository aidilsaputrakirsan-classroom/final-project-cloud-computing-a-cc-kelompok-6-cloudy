@extends('layouts.admin')

@section('title', 'Katalog User')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e9ecef; }
    .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .table { background: white; }
    .table thead { background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%); color: white; }
    .table thead th { border: none; padding: 1rem; font-weight: 600; }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.01); }
    .table tbody td { vertical-align: middle; padding: 1rem; }
    .btn-action { width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s; border: none; }
    .btn-edit { background-color: #ffc562; color: white; margin-right: 0.5rem; }
    .btn-edit:hover { background-color: #ffc562; color: white; transform: scale(1.1); }
    .btn-delete { background-color: #fc4c4c; color: white; }
    .btn-delete:hover { background-color: #fc4c4c; color: white; transform: scale(1.1); }
    .modal-header { background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%); color: white; border-radius: calc(0.5rem - 1px) calc(0.5rem - 1px) 0 0; }
    .modal-header .btn-close { filter: invert(1); }
    .form-label { font-weight: 600; color: #495057; margin-bottom: 0.5rem; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #dee2e6; padding: 0.75rem; transition: all 0.3s; }
    .form-control:focus, .form-select:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
    .badge-role { padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; }
    .badge-admin { background-color: #d1f2d4; color: #006d0d; }
    .badge-user { background-color: #e3f2fd; color: #1976d2; }
    .form-select { max-width: 250px; border-radius: 8px; }
    .toast-container { min-width: 350px; max-width: 400px; z-index: 9999; }
    .toast { margin-bottom: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease-out; }
    .toast-success .toast-header { background-color: #28a745; color: white; }
    .toast-error .toast-header { background-color: #dc3545; color: white; }
    .toast-warning .toast-header { background-color: #ffc107; color: white; }
    .toast-body { background-color: white; padding: 0.75rem; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 768px) { .table-responsive { overflow-x: auto; } .page-header { text-align: center; } .nav-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.875rem; } .toast-container { min-width: 300px; max-width: 90%; right: 10px; } }
</style>
@endpush

@section('content')
<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    @if(session('success'))
    <div class="toast toast-success show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
        <div class="toast-header bg-success text-white">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="toast toast-error show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000">
        <div class="toast-header bg-danger text-white">
            <i class="bi bi-x-circle-fill me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('error') }}
        </div>
    </div>
    @endif
    
    @if(session('warning'))
    <div class="toast toast-warning show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header bg-warning text-white">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong class="me-auto">Peringatan</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('warning') }}
        </div>
    </div>
    @endif
</div>

<div class="content-container px-0">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1 class="h3 mb-1"><i class="bi bi-people me-2"></i>Katalog User</h1>
                <p class="text-muted mb-0">Kelola data pengguna sistem</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q', $q ?? '') }}" class="form-control" placeholder="Cari nama atau email..." />
                        <select name="role" class="form-select" style="max-width: 150px;">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @if(request('q') || request('role'))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Nama</th>
                                <th style="width: 25%">Email</th>
                                <th style="width: 12%">Role</th>
                                <th style="width: 18%">Tanggal Daftar</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge badge-role badge-admin">Admin</span>
                                    @else
                                        <span class="badge badge-role badge-user">User</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $user->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-action btn-delete" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-action btn-delete" disabled title="Tidak dapat menghapus akun sendiri">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                    <p class="text-muted mt-2">Belum ada user yang ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
@foreach($users as $user)
<div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (Opsional)</label>
                        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    
    // Auto-close toast notifications
    document.addEventListener('DOMContentLoaded', function() {
        var toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toast) {
            var bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        });
    });
</script>
@endpush

