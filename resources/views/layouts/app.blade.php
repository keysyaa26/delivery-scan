<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('logo-kbi.png') }}">
    <title>{{ $title ?? 'Scan Delivery' }}</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
        <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <!-- Tombol toggle sidebar (muncul di mobile) -->
            <button class="navbar-toggler sidebar-toggler me-2" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand/logo -->
            <a class="navbar-brand" href="#">DELIVERY SISTEM</a>

            <!-- Tombol toggle navbar (muncul di mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ Illuminate\Support\Facades\Auth::user()->full_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar bg-light">
        <div class="sidebar-header p-3 border-bottom">
            <h5 class="mb-0">Menu Navigasi</h5>
        </div>
        <ul class="nav flex-column p-2">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('scanAdmin') }}">
                    <i class="fas fa-chart-bar"></i> Scan Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('scanLeader') }}">
                    <i class="fas fa-chart-bar"></i> Check Prepare
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('checkSuratJalan') }}">
                    <i class="fas fa-truck"></i> Check Surat Jalan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('checkLoading')}}">
                    <i class="fas fa-truck-loading"></i> Loading
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay untuk sidebar di mobile -->
    <div class="overlay"></div>


    <!-- Main Content -->
    <main class="py-4 main-content">

        @if(session()->has('customer'))
        <div class="alert alert-success text-center m-0 rounded-0 d-flex justify-content-between align-items-center">
        <div>
            <strong>Data aktif:</strong>
            📦{{ session('customer') }},
            📋{{ session('route') ?? '-'}},
            🔄{{ session('cycle') ?? '-'}}
        </div>
        <form action="{{ route('scan.end-session') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                Reset
            </button>
        </form>
    </div>
    @endif

        <div class="container-fluid">
            @yield('content')
            <!-- Global Alert Container -->
            <div id="responseAlert" class="alert alert-success d-none text-center mx-4 mt-3"></div>

            <!-- SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>
    </main>

    {{-- --}}
    @stack('scripts')

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');
            const overlay = document.querySelector('.overlay');
            const mainContent = document.querySelector('.main-content');

            sidebarToggler.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
                mainContent.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.style.display = 'none';
                mainContent.classList.remove('active');
            });

            // Di desktop, sidebar selalu aktif
            function handleResize() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.add('active');
                    overlay.style.display = 'none';
                    mainContent.classList.add('active');
                } else {
                    sidebar.classList.remove('active');
                    overlay.style.display = 'none';
                    mainContent.classList.remove('active');
                }
            }

            // Jalankan saat pertama kali load
            handleResize();

            // Dan saat window di-resize
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
</html>
