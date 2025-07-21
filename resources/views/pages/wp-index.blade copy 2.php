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


            {{-- manifest --}}
            <div id="manifestSection" style="display: none;">
                <div class="mb-3">
                    <form action="POST" id="formManifest">
                        <label for="manifest" class="form-label">Manifest</label>
                        <input type="text" name="manifest" id="manifest" class="form-control" value="{{old('manifest')}}" placeholder="Scan manifest..." autofocus>
                    </form>
                </div>


            {{-- tabel manifest --}}
                <h4 class="mb-4">Data Manifest</h4>
                <div class="table-responsive-scroll">
                    <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center" id="manifestTable">
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
                        <tbody id="manifestBody">
                        </tbody>
                    </table>
                </div>
            </div>



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('formWaitingPost').addEventListener('keydown', async function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                const customer = document.getElementById('inputCustomer').value;
                const cycle = document.getElementById('inputCycle').value;
                const date = document.getElementById('dateInput').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                console.time("scannerPost");
                await fetch('/wp/store-scan', {
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
                    })
                    .then(response => response.json())
                    .then(data => {
                            Swal.fire({
                            title: data.success ? 'OK!' : 'NG!',
                            text: data.message,
                            icon: data.success ? 'success' : 'error',
                            timer: 2000,
                            showConfirmButton: false
                            });

                            if(data.success && data.manifests){
                                document.getElementById('manifestSection').style.display = 'block';

                                const tbody = document.getElementById('manifestBody');
                                const table = document.getElementById('manifestTable');
                                tbody.innerHTML = ''; // kosongkan isi lama

                                let statusCell = '';


                                data.manifests.forEach((item, index) => {

                                    if (item.status === null) {
                                        statusCell = '';
                                    } else if (item.status === 'OK') {
                                        statusCell = '<b style="color: green;">OK</b>';
                                    } else if (item.status === 'NG') {
                                        statusCell = '<b style="color: red;">NG</b>';
                                    } else {
                                        statusCell = item.status;
                                    }

                                    const row = `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${item.tanggal_order}</td>
                                            <td>${item.dn_no}</td>
                                            <td>${item.job_no}</td>
                                            <td>${item.cycle}</td>
                                            <td>${statusCell}</td>
                                        </tr>
                                    `;
                                    tbody.innerHTML += row;
                                });
                                table.style.display = 'table';
                            }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
                }
            });

            document.getElementById('formManifest').addEventListener('keydown', async function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();

                const manifest = document.getElementById('manifest').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;
                // console.log(manifest);

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
                            Swal.fire({
                            title: data.success ? 'OK!' : 'NG!',
                            text: data.message,
                            icon: data.success ? 'success' : 'error',
                            timer: 2000,
                            showConfirmButton: false
                            });

                            // update tabel
                            const tbody = document.getElementById('manifestBody');
                            const table = document.getElementById('manifestTable');
                            tbody.innerHTML = ''; // kosongkan isi lama

                            let statusCell = '';
                            data.manifests.forEach((item, index) => {
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.tanggal_order}</td>
                                        <td>${item.dn_no}</td>
                                        <td>${item.job_no}</td>
                                        <td>${item.cycle}</td>
                                        <td>
                                            ${
                                                item.status === "OK" ? '<b style="color:green;">OK</b>' :
                                                item.status === "NG" ? '<b style="color:red;">NG</b>' :
                                                item.status ?? ''
                                            }
                                        </td>
                                    </tr>
                                `;
                                tbody.innerHTML += row;
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

