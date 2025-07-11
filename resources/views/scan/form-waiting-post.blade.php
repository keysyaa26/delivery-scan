{{-- gak ada ajx, langsung form dan kirim ke route --}}

@extends('layouts.app')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- untuk button di form --}}
<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('waitingPostForm'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/store-scan', {
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
                title: res.success ? 'Sukses!' : 'Gagal!',
                text: res.message,
                icon: res.success ? 'success' : 'error',
                timer: 2000, // 2 detik
                showConfirmButton: false
            });
        })
        .then(() => {
            // Redirect to dashboard after successful submission
            window.location.href = "{{ route('dashboard') }}";
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan'
            });
        });

    }
</script>

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Input Waiting Post</h3>

    {{-- Form Scan --}}
    <div class="card">
        <div class="card-body">
            <form id="waitingPostForm" action="{{ route('scan.store-data') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="customer" class="form-label">Customer</label>
                    <input type="text" name="customer" id="customer" class="form-control" placeholder="Input customer..." required autofocus>
                </div>

                <div class="mb-3">
                    <label for="plan" class="form-label">Plan</label>
                    <input type="text" name="plan" id="plan" class="form-control" placeholder="Input plan...">
                </div>

                <div class="mb-3">
                    <label for="cycle" class="form-label">Cycle</label>
                    <input type="text" name="cycle" id="cycle" class="form-control" placeholder="Input cycle..." required>
                </div>

                <div class="d-flex justify-content-start gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- ajax form input waiting post --}}
@section('scripts')
<script>
  document.getElementById('waitingPostForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitForm();
  });
</script>
@endsection
