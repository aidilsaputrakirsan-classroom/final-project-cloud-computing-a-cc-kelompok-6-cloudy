@extends('layouts.admin')

@section('title', 'Manajemen Kategori Produk')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e9ecef; }
    .btn-tambah { background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%); border: none; padding: 0.75rem 1.5rem; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); transition: all 0.3s; }
    .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5); }
    .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    .table { background: white; }
    .table thead { background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%); color: white; }
    .table thead th { border: none; padding: 1rem; font-weight: 600; }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.01); }
    .table tbody td { vertical-align: middle; padding: 1rem; }
    .btn-action { width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s; border: none; }
    .btn-edit { background-color: #ffc562; color: white; margin-right: 0.5rem; }
    .btn-edit:hover { transform: scale(1.1); }
    .btn-delete { background-color: #fc4c4c; color: white; }
    .btn-delete:hover { transform: scale(1.1); }
</style>
@endpush

@section('content')

{{-- Toast Notifikasi --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    @if(session('success'))
        <div class="toast show">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Sukses</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('success') }}</div>
        </div>
    @endif
</div>

<div class="content-container px-0">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1 class="h3 mb-1"><i class="bi bi-tags me-2"></i>Manajemen Kategori</h1>
                <p class="text-muted mb-0">Kelola kategori produk</p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-tambah">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    <div class="card p-0 shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 25%">Nama</th>
                            <th style="width: 25%">Slug</th>
                            <th style="width: 15%">Deskripsi</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $i => $c)
                            <tr>
                                <td>{{ $categories->firstItem() + $i }}</td>
                                <td>{{ $c->name }}</td>
                                <td class="text-muted">{{ $c->slug }}</td>
                                <td>
                                    <span class="badge {{ $c->is_active ? 'bg-success':'bg-danger' }}">
                                        {{ $c->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-action btn-edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" style="display:inline;" id="delete-{{ $c->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-action btn-delete"
                                            onclick="confirmDelete({{ $c->id }}, '{{ $c->name }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Belum ada kategori.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        if (confirm(`Hapus kategori "${nama}"?\nTindakan ini tidak dapat dibatalkan!`)) {
            document.getElementById('delete-' + id).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toast').forEach(toast => {
            new bootstrap.Toast(toast).show();
        });
    });
</script>
@endpush
