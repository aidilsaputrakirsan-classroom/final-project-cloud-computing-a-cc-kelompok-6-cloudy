<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - cloudywear</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 205px;
            background: linear-gradient(135deg, #0E5DA5 35%, #8cbff1 100%);
            box-shadow: 5px 0 50px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-brand {
            padding: 1rem;
            text-align: center;
        }

        .brand-logo {
            height: 36px;
            max-width: 100%;
            object-fit: contain;
            transition: all 0.3s;
        }

        /* Tetap tampil penuh meski collapse */
        .sidebar.collapsed .brand-logo {
            height: 36px;
        }

        .toggle-btn {
            border: none;
            background: transparent;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .toggle-btn:hover {
            transform: rotate(90deg);
        }

        .nav-link {
            color: white;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }



        .nav-link i {
            font-size: 1.2rem;
        }

        .nav-link span {
            margin-left: 10px;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.6);
            color: white;
            font-weight: 600;
        }

        /* Sembunyikan teks saat collapse */
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        /* Main Content */
        .main-content-wrapper {
            margin-left: 200px;
            width: calc(100% - 200px);
            min-height: 100vh;
            padding: 1.5rem;
            transition: all 0.3s ease-in-out;
        }

        .main-content-wrapper.expanded {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                left: -200px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .main-content-wrapper.expanded {
                width: 100%;
            }
        }

        /* Icon toggle */
        body.dark-mode label i.bi-sun-fill {
            display: inline;
        }

        body.dark-mode label i.bi-moon-fill {
            display: none;
        }

        label i.bi-sun-fill {
            display: none;
        }

        /* Tombol switch */
        .form-check-input:checked {
            background-color: #0E5DA5;
            border-color: #0E5DA5;
        }

        .form-check-input {
            transition: all 0.3s ease;
        }

        /* Dark Mode Base */
        body.dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .main-content-wrapper {
            background-color: #1e1e1e;
        }

        body.dark-mode .card,
        body.dark-mode .dropdown-menu,
        body.dark-mode .sidebar,
        body.dark-mode .table,
        body.dark-mode .modal-content {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }

        body.dark-mode .nav-link.active,
        body.dark-mode .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        body.dark-mode .text-muted {
            color: #a0a0a0 !important;
        }

        body.dark-mode .btn-light {
            background-color: #333 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .btn-light:hover {
            background-color: #444 !important;
        }

        body.dark-mode .btn-primary-custom,
        body.dark-mode .btn-tambah {
            background-color: #0E5DA5 !important;
            border-color: #0E5DA5 !important;
            color: #fff !important;
        }

        ,

        body.dark-mode .sidebar {
            background: linear-gradient(135deg, #0a3a66 35%, #1e1e1e 100%) !important;
        }

        body.dark-mode table th,
        body.dark-mode table td {
            border-color: #333 !important;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="d-flex align-items-center justify-content-between px-3 pt-3 pb-2">
                <a href="/admin" class="sidebar-brand p-0 m-0 d-flex align-items-center justify-content-center w-100">
                    <img src="{{ asset('images/cloudywear-logo.png') }}" alt="CloudyWear" class="brand-logo">
                </a>
                <button class="toggle-btn" id="toggleSidebar" aria-label="Toggle sidebar">
                    <i class="bi bi-list text-white"></i>
                </button>
            </div>
            <nav class="navbar flex-column mt-3">
                <ul class="navbar-nav w-100">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @php
                            $productMenuActive = request()->is('admin/products*') || request()->is('admin/categories*');
                        @endphp

                        <a class="nav-link {{ $productMenuActive ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                            href="#menuProduk">
                            <i class="bi bi-box-seam"></i>
                            <span>Manajemen Produk</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div id="menuProduk" class="collapse {{ $productMenuActive ? 'show' : '' }}">
                            <ul class="nav flex-column ms-4">

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                                        href="/admin/products">
                                        <i class="bi bi-bag"></i>
                                        <span>Produk</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
                                        href="/admin/categories">
                                        <i class="bi bi-tags"></i>
                                        <span>Kategori</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pemesanan*') ? 'active' : '' }}"
                            href="/admin/pemesanan">
                            <i class="bi bi-cart"></i><span>Pesanan</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content-wrapper" id="mainContent">
            @hasSection('page_header')
                <div class="card shadow-sm border-10 mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            @yield('page_header')
                        </div>
                        @auth
                        <div class="d-flex align-items-center gap-0 ms-auto">
                            <!-- Dark Mode Toggle -->
                            <div class="d-flex align-items-center gap-2">
                                <!-- Jika ingin tetap ada label, beri gap 1 atau 2 -->
                                <span id="darkModeLabel" style="font-weight:400;">Light Mode</span>
                                <div class="form-check form-switch m-0 position-relative">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch"
                                        style="width:3rem; height:1.5rem; cursor:pointer;">
                                    <label class="form-check-label d-flex align-items-center justify-content-between mb-0 px-2"
                                        for="darkModeSwitch" style="width:3rem; cursor:pointer;">
                                        <i class="bi bi-sun-fill" style="color:#FFD700; font-size:1.3rem;"></i>
                                        <i class="bi bi-moon-fill" style="color:#f1f1f1; font-size:1.3rem;"></i>
                                    </label>
                                </div>
                            </div>

                            <!-- User Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i> {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-gear me-2"></i> Manage Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                        </div>
                    </div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('active');
            }
        });
    </script>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            const body = document.body;
            const sunIcon = darkModeSwitch?.nextElementSibling.querySelector('.bi-sun-fill');
            const moonIcon = darkModeSwitch?.nextElementSibling.querySelector('.bi-moon-fill');
            const modeLabel = document.getElementById('darkModeLabel');

            // Set dark mode jika sudah di localStorage
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                if (darkModeSwitch) darkModeSwitch.checked = true;
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'inline';
                if (modeLabel) modeLabel.textContent = 'Dark Mode';
            } else {
                if (sunIcon) sunIcon.style.display = 'inline';
                if (moonIcon) moonIcon.style.display = 'none';
                if (modeLabel) modeLabel.textContent = 'Light Mode';
            }

            // Toggle switch
            if (darkModeSwitch) {
                darkModeSwitch.addEventListener('change', () => {
                    if (darkModeSwitch.checked) {
                        body.classList.add('dark-mode');
                        localStorage.setItem('darkMode', 'enabled');
                        sunIcon.style.display = 'none';
                        moonIcon.style.display = 'inline';
                        modeLabel.textContent = 'Dark Mode';
                    } else {
                        body.classList.remove('dark-mode');
                        localStorage.setItem('darkMode', 'disabled');
                        sunIcon.style.display = 'inline';
                        moonIcon.style.display = 'none';
                        modeLabel.textContent = 'Light Mode';
                    }
                });
            }
        });
    </script>
</body>

</html>
