@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_header')
    <h5 class="mb-0 fw-bold">Admin Dashboard Overview</h5>
@endsection

@section('content')
<div class="container-fluid px-4 py-3" style="margin-top: -0.5rem;">

    {{-- ================= KPI CARDS ================= --}}
    <div class="row g-3 mb-4">

        <!-- Total Produk -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 premium-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Produk</h6>
                        <h3 class="fw-bold">{{ number_format($totalProducts) }}</h3>
                    </div>
                    <div class="icon-premium bg-gradient-primary">
                        <i class="bi bi-bag fs-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pesanan Selesai -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 premium-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Pesanan Selesai</h6>
                        <h3 class="fw-bold">{{ number_format($totalCompletedOrders) }}</h3>
                    </div>
                    <div class="icon-premium bg-gradient-success">
                        <i class="bi bi-cart-check fs-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pembelian -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 premium-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Pembelian</h6>
                        <h3 class="fw-bold">Rp {{ number_format($totalProductValue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="icon-premium bg-gradient-info">
                        <i class="bi bi-box-seam fs-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 premium-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Total Pendapatan</h6>
                        <h3 class="fw-bold">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="icon-premium bg-gradient-warning">
                        <i class="bi bi-currency-dollar fs-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= WARNING STOCK LOW (PREMIUM) ================= --}}
<div class="alert shadow-sm border-0 rounded-4 mb-4 p-3 d-flex justify-content-between align-items-center premium-alert">
    <div class="d-flex align-items-start">
        <div class="icon-warning me-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div>
            <h6 class="fw-bold mb-1">Peringatan Stok Rendah</h6>
            <p class="mb-0 text-muted">Beberapa produk memiliki stok kurang dari 5. Segera lakukan restock.</p>
        </div>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn premium-btn">
        Lihat Produk <i class="bi bi-arrow-right ms-1"></i>
    </a>
</div>

{{-- ================= TRANSAKSI HARI INI ================= --}}
<div class="card shadow-sm border-0 rounded-4 premium-card">

    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">🧾 Transaksi Penjualan Hari Ini</h5>
            <small class="text-muted">Menampilkan beberapa transaksi penjualan perhari ini.</small>
        </div>
        <form method="GET" class="d-flex align-items-center gap-2" id="filterForm">
            <input type="date"
                name="date"
                value="{{ request('date') }}"
                class="form-control form-control-sm calendar-filter"
                onchange="document.getElementById('filterForm').submit();">
        </form>
    </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($latestOrders as $order)
                    <tr>
                        <td class="fw-bold">{{ $loop->iteration }}</td>

                        <td>{{ $order->customer_name ?? '-' }}</td>

                        <td class="fw-semibold">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($order->status == 'completed')
                                <span class="badge bg-success px-3 py-2">Selesai</span>
                            @endif
                        </td>

                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Tidak ada transaksi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= STYLE ================= --}}
<style>
.icon-premium {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.premium-card:hover {
    transform: translateY(-4px);
    transition: .25s;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.bg-gradient-primary { background: linear-gradient(45deg, #4f46e5, #6d28d9); }
.bg-gradient-success { background: linear-gradient(45deg, #16a34a, #22c55e); }
.bg-gradient-info    { background: linear-gradient(45deg, #0ea5e9, #38bdf8); }
.bg-gradient-warning { background: linear-gradient(45deg, #f59e0b, #fbbf24); }

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transition: .2s;
}

.badge {
    border-radius: 8px;
    font-size: 0.8rem;
}
    .premium-alert {
        background: #fff9ea;
        border-left: 6px solid #ffcc70;
        animation: fadeIn .6s ease;
        box-shadow: 0px 4px 18px rgba(0,0,0,0.05);
    }

    .icon-warning {
        background: #ffb74d;
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        animation: alertPulse 1.8s infinite ease-in-out;
    }

    @keyframes alertPulse {
        0% { transform: scale(1); box-shadow: 0 0 0 rgba(255, 165, 0, 0.0); }
        50% { transform: scale(1.05); box-shadow: 0 0 14px rgba(255, 165, 0, 0.4); }
        100% { transform: scale(1); box-shadow: 0 0 0 rgba(255, 165, 0, 0.0); }
    }

    /* ================= PREMIUM BUTTON ================= */
    .premium-btn {
        background: linear-gradient(135deg, #0E5DA5, #1086D4);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        transition: .25s ease;
        box-shadow: 0px 4px 12px rgba(14,93,165,.3);
    }

    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0px 8px 18px rgba(14,93,165,.4);
        filter: brightness(1.08);
    }

    /* ================= OUTLINE BUTTON ================= */
    .premium-btn-outline {
        border: 2px solid #0E5DA5;
        color: #0E5DA5;
        padding: 7px 15px;
        border-radius: 8px;
        transition: .25s;
        font-weight: 600;
    }

    .premium-btn-outline:hover {
        background: #0E5DA5;
        color: white;
        box-shadow: 0px 6px 15px rgba(14,93,165,.3);
        transform: translateY(-2px);
    }

    /* ================= PREMIUM CARD ================= */
    .premium-card {
        animation: fadeInUp .6s ease;
        border-radius: 16px !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .calendar-filter {
        border-radius: 8px;
        padding: 4px 8px;
        border: 1px solid #e0e0e0;
        transition: .2s ease;
    }

    .calendar-filter:hover, .calendar-filter:focus {
        border-color: #0E5DA5;
        box-shadow: 0 0 8px rgba(14, 93, 165, 0.25);
    }
</style>
@endsection
