@extends('layouts.app', ['title' => 'Check Surat Jalan'])

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="container mt-4">
<div class="card">
    <div class="card-body">
        <h4 class="mb-4">Data Waiting Post</h4>

        <form method="POST" id="formWaitingPost">
            @csrf
            {{-- form tanggal --}}
            <div class="col-md-4">
                <label for="dateInput" class="form-label">Tanggal Delivery</label>
                <input type="date" name="date" id="dateInput" class="form-control" value="{{ request('date') }}">
            </div>

            <div class="mb-3">
                <label for="inputCustomer" class="form-label">Customer</label>
                <input type="text" name="customer" id="inputCustomer" value="{{old('customer')}}" placeholder="Scan customer..." class="form-control" autofocus>
            </div>

            <div class="mb-3">
                <label for="inputCycle" class="form-label">Cycle</label>
                <input type="text" name="cycle" id="inputCycle" class="form-control" value="{{old('cycle')}}" placeholder="Scan cycle..." autofocus>
            </div>

            <div class="mb-3">
                <label for="inputRoute" class="form-label">Route</label>
                <input type="text" name="route" id="inputRoute" class="form-control" value="{{old('route')}}" placeholder="Scan route..." autofocus>
            </div>
        </form>

        <div id="form2-container" style="display:none;">
            @include('partials.input-manifest')

            <div id="table-container">
                {{-- tampilkan di sini --}}
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('inputCustomer').addEventListener('keydown', handleEnter);
    document.getElementById('inputCycle').addEventListener('keydown', handleEnter);
    document.getElementById('inputRoute').addEventListener('keydown', handleEnter);
    document.getElementById('inputManifest').addEventListener('keydown', handleEnter);

    async function handleEnter(e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            if (e.target.id === 'inputCustomer' || e.target.id === 'inputCycle' || e.target.id === 'inputRoute') {
                inputWP();
            } else if (e.target.id === 'inputManifest') {
                scanManifestSJ();
            }
        }
    }

    async function inputWP() {
        const customer = document.getElementById('inputCustomer').value;
        const cycle = document.getElementById('inputCycle').value;
        const route = document.getElementById('inputRoute').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        let selectedDate = null;

        try{
            const response = await fetch("{{ route ('wp.store-scan-2') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    customer: customer,
                    cycle: cycle,
                    route: route
                })
            });
            const data = await response.json();

            Swal.fire({
                title: data.success ? 'OK!' : 'NG!',
                text: data.message,
                icon: data.success ? 'success' : 'error',
                timer: 2000,
                showConfirmButton: false
            });

            if (data.success) {
                document.getElementById('form2-container').style.display = 'block';
                dataManifest(selectedDate); // Refresh the manifest table
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        }
    }

    async function scanManifestSJ() {
        const manifest = document.getElementById('inputManifest').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;

        const response = await fetch("{{ route('po.scan-sj')}}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                manifest: manifest
            })
        });
        const data = await response.json();
        Swal.fire({
            title: data.success ? 'OK!' : 'NG!',
            text: data.message,
            icon: data.success ? 'success' : 'error',
            timer: 2000,
            showConfirmButton: false
        });
        if (data.success) {
            dataManifest(selectedDate); // Refresh the manifest table
        }
    }

    async function dataManifest(date = null){
        let route = "{{ route('wp.data-table-sj') }}";
        if (date) {
            route = `{{ route('wp.data-table-sj') }}?date=${date}`;
        }
        const response = await fetch(route, {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        document.getElementById('table-container').innerHTML = data.html;
    }

    document.addEventListener('DOMContentLoaded', function() {
        dataManifest(selectedDate);
    });
    document.getElementById('dateInput').addEventListener('change', function() {
        selectedDate = this.value;
        dataManifest(selectedDate);
    });
</script>
@endsection
