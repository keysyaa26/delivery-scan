{{-- Scan BarCode Manifest --}}

@extends('layouts.app')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    //untuk button di form
    function submitForm() {
        const formData = new FormData(document.getElementById('manifestForm'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/store-manifest', {
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            Swal.fire({
                    title: res.success ? 'OK!' : 'NG!',
                    text: res.message,
                    icon: res.success ? 'success' : 'error',
                    timer: 2000, //2 detik
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
    @if(isset($manifestData) && count($manifestData) > 0)
    <div class="card">
        <div class="card-body">
                <h4 class="mb-4">Manifest Data Customer {{$customer}}</h4>
                <div class="table-responsive-scroll">
                    <table class="table table-bordered table-striped mt-2 table-hover table-sm">
                        <thead >
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Manifest</th>
                                <th>Cycle</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manifestData as $manifest)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $manifest->dn_no }}</td>
                                    <td>{{ $manifest->cycle }}</td>
                                    {{-- <td>{{ $manifest->status }}</td> --}}
                                    <td>
                                        @if($manifestStatus === true)
                                        <span class="status-icon check"><i class="fas fa-check-circle"></i></span>
                                        @elif($manifestStatus === false)
                                        <span class="status-icon cross"><i class="fas fa-times-circle"></i></span>
                                        @else
                                        <span class="status-icon empty"><i class="fas fa-circle"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
            <div class="alert alert-info mt-4">
                Tidak ada data manifest yang ditemukan.
            </div>
        @endif
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


