@extends('layouts.app', ['title' => 'Leader'])

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

        <div id="form2-container" style="display:none;">
            @include('partials.input-manifest')

            {{-- input parts untuk leader --}}
            @if (in_array(Auth::user()->id_role, [1, 2]))
            <div id="form3-container" style="display:none;">
                @include('partials.input-parts')

                @include('partials.table-parts')
            </div>
            @endif
        </div>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Daftarkan event listener hanya pada input fields yang relevan
            document.getElementById('inputCustomer').addEventListener('keydown', handleEnter);
            document.getElementById('inputCycle').addEventListener('keydown', handleEnter);
            document.getElementById('inputManifest').addEventListener('keydown', handleEnter);

            const userRole = {{ auth()->user()->id_role }};

            async function handleEnter(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();

                    scanWP();
                }
            }

            document.getElementById('inputManifest').addEventListener('keydown', async function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                inputManifest();
                }
            });

            function refreshTabel() {
                fetch("{{ route('wp.index') }}", {
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

            function inputManifest() {
                const manifest = document.getElementById('inputManifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                console.log('Script loaded!');

                console.log(manifest);
                document.getElementById('form3-container').style.display = 'block';
            }

            async function scanWP () {
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
                        const response = await fetch('/waiting-post/store-scan', {
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

                        document.getElementById('form2-container').style.display = 'block';
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

