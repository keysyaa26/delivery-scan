@extends('layouts.app', ['title' => 'Leader'])

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="container mt-4">
<div class="card">
    <div class="card-body">
        <h4 class="mb-4">Data Waiting Post</h4>

        {{-- form tanggal --}}
        <form action="{{route('wp.index')}}" method="GET" id="dateForm">
            @csrf
        </form>

        <form method="POST" id="formWaitingPost">
            @csrf

            <div class="mb-3">
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

            {{-- input parts untuk leader --}}
            @if (in_array(Auth::user()->id_role, [1, 2]))
            <div id="form3-container" style="display:none;">
                @include('partials.input-parts')
            </div>

            <div id="table-container">
                {{-- tampilkan di sini --}}
            </div>
            @endif
        </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Daftarkan event listener hanya pada input fields yang relevan
            document.getElementById('inputCustomer').addEventListener('keydown', handleEnter);
            document.getElementById('dateInput').addEventListener('change', handleEnter);
            document.getElementById('inputCycle').addEventListener('keydown', handleEnter);
            document.getElementById('inputRoute').addEventListener('keydown', handleEnter);
            document.getElementById('inputManifest').addEventListener('keydown', handleEnter);
            document.getElementById('inputParts').addEventListener('keydown', handleEnter);

            const userRole = {{ auth()->user()->id_role }};

            async function handleEnter(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    if (e.target.id === 'inputCustomer' || e.target.id === 'inputCycle' || e.target.id === 'inputRoute' || e.target.id === 'dateInput') {
                        await scanWP();
                    } else if ( e.target.id === 'inputManifest' ) {
                        await inputManifest();
                    } else if ( e.target.id === 'inputParts' ) {
                        await inputParts();
                    }

                }
            }


            async function inputManifest() {
                const manifest = document.getElementById('inputManifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                try{
                    const response = await fetch ("{{ route('label.parts-data') }}",{
                        method:"POST",
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
                    console.log(data);
                    if (data.success === true) {
                        document.getElementById('form3-container').style.display = 'block';
                        // tampil tabel parts
                        document.getElementById('table-container').innerHTML = data.html;
                    }

                    Swal.fire({
                        title: data.success ? 'OK!' : 'NG!',
                        text: data.message,
                        icon: data.success ? 'success' : 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });

                } catch (error) {
                    console.error("Error:", error);

                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing your request',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    })
                }
            }

            async function inputParts() {
                const parts = document.getElementById('inputParts').value;
                const manifest = document.getElementById('inputManifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                    const response = await fetch("{{ route('label.store-scan') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            parts: parts,
                            manifest: manifest
                        })
                    });

                    const data = await response.json();
                    if(data.success === true) {
                        document.getElementById('table-container').innerHTML = data.html;
                    }

                    Swal.fire({
                        title: data.success ? 'OK!' : 'NG!',
                        text: data.message,
                        icon: data.success ? 'success' : 'error',
                        timer: 2000,
                        showConfirmButton: false
                    })
            }

            async function scanWP () {
                    const customer = document.getElementById('inputCustomer').value;
                    const cycle = document.getElementById('inputCycle').value;
                    const route = document.getElementById('inputRoute').value;
                    const date = document.getElementById('dateInput').value;

                    // Hanya proses jika ada nilai di semua field
                    if (!customer || !cycle) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Input kolom tidak lengkap',
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    console.time("scannerPost");
                    try {
                        const response = await fetch("{{ route('wp.store-scan-2') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                customer: customer,
                                cycle: cycle,
                                date: date,
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
                        // tampil tabel manifest
                        document.getElementById('table-container').innerHTML = data.html;
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
        </script>
    </div>
</div>
</div>
@endsection

