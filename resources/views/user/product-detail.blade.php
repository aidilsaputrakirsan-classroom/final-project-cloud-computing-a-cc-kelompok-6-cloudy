@extends('layouts.user')

@section('content')

<div class="container py-5">

    <div class="row">

        {{-- Gambar Produk --}}
        <div class="col-md-6 text-center">
            <img src="{{ asset('storage/' . $product->image) }}"
                 class="img-fluid rounded"
                 style="max-height: 450px; object-fit: cover;">
        </div>

        {{-- Detail Produk --}}
        <div class="col-md-6">

            <h2 class="fw-bold">{{ $product->name }}</h2>

            <p class="text-muted">
                Kategori: <strong>{{ $product->category->name ?? '-' }}</strong>
            </p>

            <h4 class="text-success fw-bold mb-3">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </h4>

            <hr>

            {{-- Deskripsi --}}
            <h5 class="fw-bold">Deskripsi Produk</h5>
            <p style="white-space: pre-line;">
                {{ $product->description }}
            </p>

            {{-- Ukuran Produk Dinamis --}}
            <div class="mt-4">
                <h6 class="fw-bold">Ukuran:</h6>

                @php
                    $sizeText = '';

                    switch ($product->name) {
                        case 'Kemeja Putih Basic':
                            $sizeText = 'Lebar 45–55 cm, Panjang 65–75 cm';
                            break;

                        case 'Kemeja Biru Salur':
                            $sizeText = 'Lingkar dada 100–110 cm, Panjang 65–95 cm';
                            break;

                        case 'Celana Jeans Denim':
                            $sizeText = 'Panjang 97–103 cm, Lingkar pinggang 70–90 cm';
                            break;

                        case 'Celana Jeans Highwaist':
                            $sizeText = 'Lingkar pinggang 78–100 cm, Panjang 65–105 cm';
                            break;

                        default:
                            $sizeText = 'Ukuran all size (lihat deskripsi).';
                            break;
                    }
                @endphp

                <p>{{ $sizeText }}</p>
            </div>

            <hr>

            {{-- Tombol Pesan --}}
            <a href="{{ route('order.create', $product->id) }}" 
               class="btn btn-primary px-4 py-2 mt-3">
                Pesan Sekarang
            </a>

        </div>

    </div>

</div>

@endsection