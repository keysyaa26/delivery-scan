@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>
    </div>

    {{-- card status --}}
    <div class="row align-items-center justify-content-center">
        <div class="col-md-4 col-sm-6 col-12 my-3">
            <div class="status-card text-center">
                <div class="card-role-custom">
                    Admin
                </div>
                <div class="card-header-custom">
                    Order (Pcs)
                </div>
                <div class="card-body-custom">
                    <div class="order-status-number">
                        120/120
                    </div>
                    <div class="order-status-text">
                        Closed
                    </div>
                </div>
                <a href="#" class="more-info-link">
                    More Info
                </a>
            </div>
        </div>
    </div>

    {{-- job --}}
    <div class="d-flex justify-content-center align-items-center flex-column gap-3" style="min-height: 60vh;">
        <a href="{{ route('scan.open') }}" class="btn btn-primary w-100 py-3 rounded-pill shadow-sm">
            Scan Waiting Post
        </a>

        <a href="{{ route('manifest.open') }}" class="btn btn-success w-100 py-3 rounded-pill shadow-sm">
            Scan Manifest
        </a>

        <a class="btn btn-warning w-100 py-3 rounded-pill shadow-sm text-white">
            Scan Label Customer
        </a>
    </div>
</div>
@endsection
