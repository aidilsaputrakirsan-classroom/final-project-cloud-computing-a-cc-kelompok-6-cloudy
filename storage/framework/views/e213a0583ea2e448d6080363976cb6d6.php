<?php $__env->startSection('title', 'Manajemen Pemesanan Produk'); ?>

<?php $__env->startPush('styles'); ?>
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
    .bg-pink { background-color: #ff69b4 !important; color: white; }
    .form-select { max-width: 250px; border-radius: 8px; }
    .toast-container { min-width: 350px; max-width: 400px; z-index: 9999; }
    .toast { margin-bottom: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease-out; }
    .toast-success .toast-header { background-color: #28a745; color: white; }
    .toast-error .toast-header { background-color: #dc3545; color: white; }
    .toast-warning .toast-header { background-color: #ffc107; color: white; }
    .toast-body { background-color: white; padding: 0.75rem; }
    .pagination .page-link { color: #0E5DA5; background-color: #ffffff; border-color: #0E5DA5; }
    .pagination .page-link:hover { background-color: #1067b8; border-color: #0E5DA5; color: #fff; }
    .pagination .page-item.active .page-link { background-color: #0E5DA5; border-color: #0E5DA5; color: #fff; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 768px) { .table-responsive { overflow-x: auto; } .page-header { text-align: center; } .btn-tambah { width: 100%; margin-bottom: 1rem; } .nav-tabs .nav-link { padding: 0.5rem 0.75rem; font-size: 0.875rem; } .product-img { width: 60px; height: 60px; } .toast-container { min-width: 300px; max-width: 90%; right: 10px; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <?php if(session('success')): ?>
    <div class="toast toast-success show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
        <div class="toast-header bg-success text-white">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <?php echo e(session('success')); ?>

        </div>
    </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
    <div class="toast toast-error show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="4000">
        <div class="toast-header bg-danger text-white">
            <i class="bi bi-x-circle-fill me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?>
    
    <?php if(session('warning')): ?>
    <div class="toast toast-warning show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header bg-warning text-white">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong class="me-auto">Peringatan</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <?php echo e(session('warning')); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
    <div class="content-container px-0">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h3 mb-1"><i class="bi bi-box-seam me-2"></i>Manajemen Pemesanan Produk</h1>
                    <p class="text-muted mb-0">Kelola pemesanan produk</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="<?php echo e(route('admin.pemesanan.index')); ?>" class="d-flex" role="search">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="<?php echo e(request('q')); ?>" class="form-control" placeholder="Cari produk atau kategori..." />
                            <?php if(request('q')): ?>
                                <a href="<?php echo e(route('admin.pemesanan.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                            <?php endif; ?>
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
                                    <th style="width: 10%">Kategori</th>
                                    <th style="width: 30%">Nama Produk</th>
                                    <th style="width: 5%">Qty</th>
                                    <th style="width: 10%">Total</th>
                                    <th style="width: 15%">Bukti Pembayaran</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($o->product->category->name ?? '-'); ?></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                            <?php if($o->product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $o->product->image)); ?>" alt="Produk" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php endif; ?>
                            <span><?php echo e($o->product->name); ?></span>
                            </div>
                        </td>
                        <td><?php echo e($o->quantity); ?></td>
                        <td>Rp <?php echo e(number_format($o->total, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($o->proof): ?>
                            <a href="<?php echo e(asset('storage/' . $o->proof)); ?>" target="_blank">Lihat</a>
                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo e(route('admin.pemesanan.update', $o->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" <?php echo e($o->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="processing" <?php echo e($o->status == 'processing' ? 'selected' : ''); ?>>Diproses</option>
                                    <option value="shipping" <?php echo e($o->status == 'shipping' ? 'selected' : ''); ?>>Dikirim</option>
                                    <option value="completed" <?php echo e($o->status == 'completed' ? 'selected' : ''); ?>>Selesai</option>
                                    <option value="cancelled" <?php echo e($o->status == 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.pemesanan.index', $o->id)); ?>" class="btn btn-action btn-edit">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form id="delete-order-<?php echo e($o->id); ?>" action="<?php echo e(route('admin.pemesanan.destroy', $o->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-action btn-delete" onclick="confirmDelete(<?php echo e($o->id); ?>, '<?php echo e($o->product->name); ?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Belum ada order.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="mt-3 px-3">
                <?php echo e($orders->appends(['q' => request('q')])->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function confirmDelete(id, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus produk "${nama}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
            document.getElementById('delete-order-' + id).submit();
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Project\final-project-cloud-computing-a-cc-kelompok-6-cloudy\resources\views/admin/pemesanan/index.blade.php ENDPATH**/ ?>