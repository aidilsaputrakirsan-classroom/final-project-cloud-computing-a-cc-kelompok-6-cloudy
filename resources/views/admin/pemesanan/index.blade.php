@extends('layouts.admin')

@section('title', 'Manajemen Pemesanan Produk')

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
    .product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .btn-action { width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.3s; border: none; }
    .btn-edit { background-color: #ffc562; color: #white; margin-right: 0.5rem; }
    .btn-edit:hover { background-color: #ffc562; color: white; transform: scale(1.1); }
    .btn-delete { background-color: #fc4c4c; color: white; }
    .btn-delete:hover { background-color: #fc4c4c; color: white; transform: scale(1.1); }
    .modal-header { background: linear-gradient(135deg, #0E5DA5 55%, #8cbff1 100%); color: white; border-radius: calc(0.5rem - 1px) calc(0.5rem - 1px) 0 0; }
    .modal-header .btn-close { filter: invert(1); }
    .form-label { font-weight: 600; color: #495057; margin-bottom: 0.5rem; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #dee2e6; padding: 0.75rem; transition: all 0.3s; }
    .form-control:focus, .form-select:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
    .badge-stok { padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; }
    .badge-stok-tersedia { background-color: #d1f2d4; color: #006d0d; }
    .badge-stok-habis { background-color: #f8c1c1; color: #d63031; }
    .badge-stok-sedikit { background-color: #ffeaa7; color: #fdcb6e; }
    .bg-pink { background-color: #ff69b4 !important; color: white; }
    .form-select { max-width: 250px; border-radius: 8px; }
    .toast-container { min-width: 350px; max-width: 400px; z-index: 9999; }
    .toast { margin-bottom: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease-out; }
    .toast-success .toast-header { background-color: #28a745; color: white; }
    .toast-error .toast-header { background-color: #dc3545; color: white; }
    .toast-warning .toast-header { background-color: #ffc107; color: white; }
    .toast-body { background-color: white; padding: 0.75rem; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 768px) { .table-responsive { overflow-x: auto; } .page-header { text-align: center; } .btn-tambah { width: 100%; margin-bottom: 1rem; } .nav-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.875rem; } .product-img { width: 60px; height: 60px; } .toast-container { min-width: 300px; max-width: 90%; right: 10px; } }
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
                    <h1 class="h3 mb-1"><i class="bi bi-box-seam me-2"></i>Manajemen Pemesanan Produk</h1>
                    <p class="text-muted mb-0">Kelola pemesanan produk dengan mudah</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex" role="search">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q', $q ?? '') }}" class="form-control" placeholder="Cari produk atau kategori..." />
                            @if(request('q'))
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th style="width: 12%">Kode Order</th>
                        <th style="width: 18%">Customer</th>
                        <th style="width: 25%">Produk</th>
                        <th style="width: 12%">Total</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 13%">Aksi</th>
                    </tr>
                </thead>

                @php
                $products = $products ?? collect();
                $categories = $categories ?? collect();

                $needsDummy = !isset($orders) || (is_countable($orders) && count($orders) === 0) || (is_object($orders) && method_exists($orders,'isEmpty') && $orders->isEmpty());
                if ($needsDummy) {
                    $orders = collect([
                        (object)[
                            'id' => 1,
                            'order_code' => 'DUMMY-001',
                            'customer' => (object)['name' => 'John Sample'],
                            'items' => collect([
                                (object)['product' => (object)['name' => 'Produk Contoh A'], 'qty' => 2],
                                (object)['product' => (object)['name' => 'Produk Contoh B'], 'qty' => 1],
                            ]),
                            'total' => 125000,
                            'status' => 'pending',
                        ],
                        (object)[
                            'id' => 2,
                            'order_code' => 'DUMMY-002',
                            'customer' => (object)['name' => 'Jane Example'],
                            'items' => collect([
                                (object)['product' => (object)['name' => 'Produk Demo C'], 'qty' => 1],
                            ]),
                            'total' => 75000,
                            'status' => 'processing',
                        ],
                    ]);
                }
                @endphp
                <tbody>
                    @forelse($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td><strong>#{{ $order->order_code }}</strong></td>

                        <td>{{ $order->customer->name ?? 'Tidak diketahui' }}</td>

                        <td>
                            @foreach($order->items as $item)
                                <div>{{ $item->product->name }} ({{ $item->qty }})</div>
                            @endforeach
                        </td>

                        <td><strong class="text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>

                        <td>
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')

                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>
                                        Dikirim
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan
                                    </option>
                                </select>
                            </form>
                        </td>

                        <td>
                            <a href="" class="btn btn-action btn-edit">
                                <i class="bi bi-eye"></i>
                            </a>

                            <form id="delete-order-{{ $order->id }}" action="" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-action btn-delete" onclick="confirmDelete({{ $order->id }}, '#{{ $order->order_code }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Belum ada order.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdukLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" name="category_id" id="category_id">
                                <option value="">Pilih Kategori (Opsional)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih kategori untuk produk ini (opsional)</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" name="price" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stock" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, atau WEBP (Maks. 2MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    @foreach($products as $product)
    <div class="modal fade" id="modalEditProduk{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="category_id">
                                <option value="">Pilih Kategori (Opsional)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih kategori untuk produk ini (opsional)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control" name="price" value="{{ $product->price }}" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, atau WEBP (Maks. 2MB)</small>
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                </div>
                            @endif
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
        if (confirm(`Apakah Anda yakin ingin menghapus produk "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
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
