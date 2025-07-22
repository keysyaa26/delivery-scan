@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>
    </div>

    {{-- job --}}
    <div class="d-flex justify-content-center align-items-center flex-column gap-3" style="min-height: 60vh;">
        <a href="{{ route('wp.index') }}" class="btn btn-primary w-100 py-3 rounded-pill shadow-sm">
            Scan Waiting Post
        </a>
    </div>
</div>
@endsection
