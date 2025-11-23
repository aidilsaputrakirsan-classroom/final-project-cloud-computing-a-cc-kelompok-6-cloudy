@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_header')
    <h5 class="mb-0">Welcome to Dashboard!</h5>
@endsection

@section('content')
<div class="container-fluid px-4 py-3" style="margin-top: -0.5rem;">
    <div class="row g-3">
        <!-- Total Produk -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100 hover-shadow">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3">
                    <div class="icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:60px; height:60px; font-size:1.8rem;">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div class="text-center text-md-start">
                        <h6 class="text-muted mb-1">Total Seluruh Produk</h6>
                        <div class="display-6 fw-bold fs-3">{{ number_format($totalProducts) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pesanan Selesai -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100 hover-shadow">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3">
                    <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:60px; height:60px; font-size:1.8rem;">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="text-center text-md-start">
                        <h6 class="text-muted mb-1">Total Pesanan Selesai</h6>
                        <div class="display-6 fw-bold fs-3">{{ number_format($totalCompletedOrders) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Nilai Produk (stok × harga) -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100 hover-shadow">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3">
                    <div class="icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:60px; height:60px; font-size:1.8rem;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="text-center text-md-start">
                        <h6 class="text-muted mb-1">Total Pembelian</h6>
                        <div class="display-6 fw-bold fs-3">Rp {{ number_format($totalProductValue, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm h-100 hover-shadow">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3">
                    <div class="icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:60px; height:60px; font-size:1.8rem;">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="text-center text-md-start">
                        <h6 class="text-muted mb-1">Total Pendapatan</h6>
                        <div class="display-6 fw-bold fs-3">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hover effect ringan */
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

/* Ikon lebih menonjol di dark mode */
body.dark-mode .icon {
    opacity: 0.9;
}

/* Text responsif */
@media (max-width: 768px) {
    .display-6 {
        font-size: 1.6rem;
    }
    
    .icon {
        width: 50px !important;
        height: 50px !important;
        font-size: 1.5rem !important;
    }
}
</style>
@endsection
