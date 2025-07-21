@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="card">
    <div class="card-body">
        <h4 class="mb-4">Data Waiting Post</h4>
        <form method="POST" id="formWaitingPost">
            @csrf

            <label for="dateInput" class="form-label">Tanggal Delivery</label>
            <div class="col-md-4">
                <input type="date" name="date" id="dateInput" value="{{old('date')}}" class="form-control" value="{{ request('date') }}">
            </div>

            <div class="mb-3">
                <label for="inputCustomer" class="form-label">Customer</label>
                <input type="text" name="customer" id="inputCustomer" value="{{old('customer')}}" placeholder="Scan customer..." class="form-control" autofocus>
            </div>

            <div class="mb-3">
                <label for="inputCycle" class="form-label">Cycle</label>
                <input type="text" name="cycle" id="inputCycle" class="form-control" value="{{old('cycle')}}" placeholder="Scan cycle..." autofocus>
            </div>
        </form>

        @if(!empty($manifests))
        <form method="POST" id="formManifest">
            @csrf
            <div class="mb-3">
                <label for="inputManifest" class="form-label">Manifest</label>
                <input type="text" name="manifest" id="inputManifest" class="form-control" value="{{old('manifest')}}" placeholder="Scan Manifest..." autofocus>
            </div>
        </form>

        <h4 class="mb-4">Data Manifest</h4>
            <div class="table-responsive-scroll">
                <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>Manifest</th>
                            <th>Job No</th>
                            <th>Cycle</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($manifests as $manifest )
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $manifest->tanggal_order }}</td>
                            <td>{{ $manifest->dn_no }}</td>
                            <td>{{ $manifest->job_no }}</td>
                            <td>{{ $manifest->cycle }}</td> {{-- FIX: Added closing </td> here --}}
                            <td>
                                @if ($manifest->status === null)
                                    {{-- Jika status null, tampilkan kosong --}}
                                @elseif ($manifest->status === 'OK')
                                    <b style="color: green;">OK</b>
                                @elseif ($manifest->status === 'NG')
                                    <b style="color: red;">NG</b>
                                @else
                                    {{ $item->status }} {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Daftarkan event listener hanya pada input fields yang relevan
            document.getElementById('inputCustomer').addEventListener('keydown', handleEnter);
            document.getElementById('inputCycle').addEventListener('keydown', handleEnter);
            document.getElementById('inputManifest').addEventListener('keydown', handleEnter);

            async function handleEnter(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    const customer = document.getElementById('inputCustomer').value;
                    const cycle = document.getElementById('inputCycle').value;
                    const date = document.getElementById('dateInput').value;

                    // Hanya proses jika ada nilai di semua field
                    if (!customer || !cycle) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Please fill all fields',
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        return;
                    }

                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    console.time("scannerPost");
                    try {
                        const response = await fetch('/wp/store-scan', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                customer: customer,
                                cycle: cycle,
                                date: date
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
            }



            document.getElementById('inputManifest').addEventListener('keydown', async function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                const manifest = document.getElementById('inputManifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;
                // console.log(manifest);

                console.log('Script loaded!');

                fetch('/po/store-scan', {
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
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
                }
            });
        </script>
    </div>
</div>
</div>
@endsection

