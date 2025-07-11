{{-- Scan BarCode Manifest --}}

@extends('layouts.app')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    //untuk button di form
    function submitForm() {
        const formData = new FormData(document.getElementById('manifestForm'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        console.log('Sending:', {
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
            },
            body: formData
        });

        fetch('/store-manifest', {
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data.success) {
                document.querySelector('#dataTable tbody').insertAdjacentHTML('afterbegin', data.html);
                document.getElementById('manifestForm').reset();
            }
            Swal.fire({
                title: data.success ? 'OK!' : 'NG!',
                text: data.message,
                icon: data.success ? 'success' : 'error',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan jaringan!'
            });
            console.error('Error:', error);
        });
    }
</script>

@section('content')
<div class="container mt-4">

    {{-- form input manifest --}}
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Input Manifest</h3>
            <form id="manifestForm" action="{{ route('manifest.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                        <label for="customer" class="form-label">Manifest/DN</label>
                        <input type="text" name="manifest" id="manifest" class="form-control" placeholder="Input manifest..." required autofocus>
                </div>

                <div class="d-flex justify-content-start gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- display manifest data --}}
    <div class="card">
        <div class="card-body">
                <h4 class="mb-4">Manifest Data Customer {{$customer}}</h4>
                <div class="table-responsive-scroll">
                    <table id="dataTable" class="table table-bordered table-striped mt-2 table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Manifest</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php $counter = 1 @endphp
                                @foreach($data as $item)
                                    @include('partials.table-row', [
                                        'item1' => $item,
                                        'counter' => $counter++
                                    ])
                                @endforeach
                        </tbody>
                    </table>
                </div>


                <h5 class="mt-4">📋 Manifest yang Belum Diperiksa</h5>
                <div class="table-responsive-scroll">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Manifest</th>
                                <th>Cycle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $nomor = 1; @endphp
                            @forelse($manifestData as $row)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td>{{ $row->dn_no }}</td>
                                    <td>{{ $row->cycle }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Semua ID sudah diperiksa 🎉</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
@endsection

{{-- ajax form input manifest --}}
@section('scripts')
<script>
  document.getElementById('manifestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm();
  });
</script>
@endsection


