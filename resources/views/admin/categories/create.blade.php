@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@push('styles')
<style>
    .page-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e9ecef; }
    .form-label { font-weight: 600; margin-bottom: 0.4rem; }
    .form-control, textarea { padding: 0.75rem; border-radius: 10px; }
    .btn-primary-custom {
        background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%);
        border: none;
        padding: 0.65rem 1.4rem;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.3s;
    }
    .btn-primary-custom:hover { transform: translateY(-2px); }
    .btn-secondary-custom {
        background: #e4e4e4;
        padding: 0.65rem 1.4rem;
        border-radius: 10px;
        font-weight: 600;
    }
    .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
</style>
@endpush

@section('content')

<div class="content-container px-0">

    <div class="page-header">
        <h1 class="h3 mb-1"><i class="bi bi-plus-square me-2"></i>Tambah Kategori</h1>
        <p class="text-muted">Buat kategori baru untuk produk</p>
    </div>

    <div class="card p-4 col-lg-6">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input 
                        type="text" 
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Aktif --}}
                <div class="mb-3 form-check">
                    <input 
                        type="checkbox"
                        class="form-check-input"
                        name="is_active"
                        value="1"
                        id="is_active"
                        checked
                    >
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>

                {{-- Tombol --}}
                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
