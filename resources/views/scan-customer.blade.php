@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-center mb-4 fw-bold">Input Customer & Cycle</h5>

            <form action="{{ route('store.customer.cycle') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nama Customer</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required placeholder="Masukkan nama customer">
                </div>

                <div class="mb-3">
                    <label for="cycle" class="form-label">Cycle</label>
                    <input type="text" name="cycle" id="cycle" class="form-control" required placeholder="Masukkan cycle">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        Input
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
