@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    <h4 class="mb-4">Dashboard</h4>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Produk</h6>
                    <div class="display-6 fw-bold">{{ number_format($totalProducts) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Nilai Value (Pendapatan)</h6>
                    <div class="display-6 fw-bold">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


