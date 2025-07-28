<!DOCTYPE html>
<html lang="en">
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

</head>

<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
    <div class="container-fluid position-relative">
        <!-- Tombol toggle sidebar (muncul di mobile) -->
        <button class="navbar-toggler sidebar-toggler me-2" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center: Delivery (Always Centered) -->
        <div class="position-absolute start-50 translate-middle-x text-white fw-bold">
            DELIVERY SISTEM
        </div>

        <!-- Hamburger Toggle Button (right on mobile) -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right Side Profile Dropdown -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> {{ Illuminate\Support\Facades\Auth::user()->full_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
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
                <a class="nav-link active" href="#">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i> Scan Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i> Scan Leader
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-truck"></i> Check Surat Jalan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-truck-loading"></i> Loading
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Overlay untuk sidebar di mobile -->
    <div class="overlay"></div>



    {{-- ALERT SESSION DI BAWAH NAVBAR --}}
    @if(session()->has('customer'))
        <div class="alert alert-success text-center m-0 rounded-0 d-flex justify-content-between align-items-center">
        <div>
            <strong>Data aktif:</strong>
            📦 Customer: {{ session('customer') }},
            📋 Plan: {{ session('route') ?? '-'}},
            🔄 Cycle: {{ session('cycle') ?? '-'}}
        </div>
        <form action="{{ route('scan.end-session') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                Reset
            </button>
        </form>
    </div>
    @endif


    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
        <!-- Global Alert Container -->
        <div id="responseAlert" class="alert alert-success d-none text-center mx-4 mt-3"></div>

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </main>

    {{-- --}}
    @stack('scripts')

    <!-- Bootstrap JS (with Popper for modal, dropdown, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- SweetAlert -->
    @if(session('success') || session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
            icon: '{{ session('success') ? 'success' : 'error' }}',
            title: '{{ session('success') ? 'Berhasil!' : 'Gagal!' }}',
            text: '{{ session('success') ?? session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });

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
    @endif
</body>
</html>
