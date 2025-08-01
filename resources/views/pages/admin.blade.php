@extends('layouts.app', ['title' => 'Admin'])

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="container mt-4">
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h4 class="mb-3 mb-md-0">Data Waiting Post</h4>
            </div>
            <div class="col-md-6 text-md-end">
                <form action="{{ route('scan.end-session') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        Reset WP
                    </button>
                </form>
            </div>
        </div>
        {{-- form tanggal --}}
        <form action="{{route('wp.index')}}" method="GET" id="dateForm">
            @csrf
            <label for="dateInput" class="form-label">Tanggal Delivery</label>
            <div class="col-md-4">
                <input type="date" name="date" id="dateInput" class="form-control" value="{{ request('date') }}">
            </div>
        </form>

        <form method="POST" id="formWaitingPost">
            @csrf
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

            <div id='table-manifest'>
                @include('partials.table-manifest')
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>

            // Daftarkan event listener hanya pada input fields yang relevan
            document.getElementById('inputCustomer').addEventListener('keydown', handleEnter);
            document.getElementById('inputCycle').addEventListener('keydown', handleEnter);
            document.getElementById('inputRoute').addEventListener('keydown', handleEnter);
            document.getElementById('inputManifest').addEventListener('keydown', handleEnter);

            async function handleEnter(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    if(e.target.id === 'inputCustomer' || e.target.id === 'inputCycle' || e.target.id === 'inputRoute') {
                        await inputWP();
                    } else {
                        await inputManifest();
                    }
                }
            }

            function refreshTabel() {
            const dateInput = document.getElementById('dateInput');
                const selectedDate = dateInput ? dateInput.value : '';

                const baseUrl = "{{ route('wp.index') }}";
                const url = new URL(baseUrl, window.location.origin);

                if (selectedDate) { // Hanya tambahkan parameter jika tanggal dipilih
                    url.searchParams.append('date', selectedDate);
                }
                fetch(url.toString(), {
                    method: "GET",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'  // <== ini WAJIB
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('table-manifest').innerHTML = html;
                    });
            }

            document.getElementById('dateInput').addEventListener('change', function () {
                    const selectedDate = this.value;
                    const baseUrl = "{{ route('wp.index') }}"; // URL dasar dari route Laravel
                    const url = new URL(baseUrl, window.location.origin); // Pastikan URL absolut
                    url.searchParams.append('date', selectedDate);

                    fetch(url.toString(), {
                        method: "GET",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('table-manifest').innerHTML = html;
                    })
                });

            async function inputWP() {
                    const customer = document.getElementById('inputCustomer').value;
                    const cycle = document.getElementById('inputCycle').value;
                    const route = document.getElementById('inputRoute').value;

                    // Hanya proses jika ada nilai di semua field
                    if (!customer || !cycle) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Kolom tidak diisi lengkap',
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    console.time("scannerPost");
                    try {
                        const response = await fetch("{{ route ('wp.store-scan') }}", {
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

                        document.getElementById('form2-container').style.display = 'block';

                        refreshTabel();
                    } catch (error) {
                        console.error("Error:", error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while processing your request',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } finally {
                        console.timeEnd("scannerPost");
                    }
            }

            async function inputManifest() {
                const manifest = document.getElementById('inputManifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;
                // console.log(manifest);

                console.log('Script loaded!');

                fetch("{{ route ('po.store-scan') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            manifest: manifest
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                            console.log(manifest);
                            Swal.fire({
                            title: data.success ? 'OK!' : 'NG!',
                            text: data.message,
                            icon: data.success ? 'success' : 'error',
                            timer: 2000,
                            showConfirmButton: false
                            });

                            refreshTabel();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            }
        </script>
    </div>
</div>
</div>
@endsection

