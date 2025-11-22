<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Cloudywear'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-white')">
    {{-- Header --}}
    @hasSection('header')
        @yield('header')
    @else
        @include('layouts.navigation')
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @hasSection('footer')
        @yield('footer')
    @endif

    @stack('scripts')
</body>
</html>
