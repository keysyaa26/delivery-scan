<div class="overlay d-md-none" id="sidebar-overlay"></div>

    <nav class="sidebar d-md-block" id="app-sidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <h3>DELIVERY SISTEM</h3>
            <button type="button" id="dismiss" class="btn btn-light d-md-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i> Dashboard</a>
            </li>
            {{-- Tambahkan menu sidebar lain di sini --}}
            <li>
                <a href="#"><i class="fas fa-box me-2"></i> Orders</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-users me-2"></i> Customers</a>
            </li>
        </ul>

        <ul class="list-unstyled CTAs">
            <li>
                <a href="{{ route('logout') }}" class="btn btn-danger w-100"
                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div id="content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
            <div class="container-fluid position-relative">
                <a class="navbar-brand me-auto d-none d-md-block" href="{{ route('dashboard') }}">
                    <i class="fas fa-home me-1"></i>
                </a>
                <button type="button" id="sidebarCollapse" class="btn btn-dark d-md-none me-auto">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="position-absolute start-50 translate-middle-x text-white fw-bold">
                    DELIVERY SISTEM
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse d-none d-md-block" id="navbarContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Illuminate\Support\Facades\Auth::user()->full_name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
