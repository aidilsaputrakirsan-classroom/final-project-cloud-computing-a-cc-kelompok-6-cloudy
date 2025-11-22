<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User CloudyWear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- NAVBAR BAR HITAM PERTAMA --}}
    <nav class="navbar navbar-dark bg-dark px-4 py-3 d-flex align-items-center justify-content-between">

        {{-- LOGO KIRI --}}
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/cloudywear-logo.png') }}" 
                 alt="CloudyWear Logo" 
                 style="height: 40px;">
        </div>

        {{-- JUDUL DI TENGAH --}}
        <h2 class="text-white fw-bold m-0 text-center flex-grow-1">
            User Deskripsi Produk Catalog
        </h2>

        {{-- Spacer agar judul tetap di tengah --}}
        <div style="width: 40px;"></div>

    </nav>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

</body>
</html>