@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>
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
