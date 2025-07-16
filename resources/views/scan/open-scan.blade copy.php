@extends('layouts.app')
<!-- ini ada kamera (+ajax) + dan form-->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@section('content')
<div class="container mt-4">
    <h3 class="mb-4">📷 Scan</h3>

    <!-- Area Kamera -->
    {{-- <div class="card mb-4">
        <div class="card-body">
            <div id="qr-reader" class="qr-container mx-auto"></div>
        </div>
    </div> --}}

    {{-- Form Scan --}}
    <div class="card">
        <div class="card-body">
            <form id="waitingPostForm" action="{{ route('scan.store-data') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="customer" class="form-label">Customer</label>
                    <input type="text" name="customer" id="customer" class="form-control" placeholder="Scan customer..." required autofocus>
                </div>

                <div class="mb-3">
                    <label for="plan" class="form-label">Plan</label>
                    <input type="text" name="plan" id="plan" class="form-control" placeholder="Scan plan..." required>
                </div>

                <div class="mb-3">
                    <label for="cycle" class="form-label">Cycle</label>
                    <input type="text" name="cycle" id="cycle" class="form-control" placeholder="Scan cycle..." required>
                </div>

                <button type="button" class="btn btn-primary" onclick="submitWaitingPostForm()">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Tambahkan CDN html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            try {
                const data = JSON.parse(decodedText); // parsing hasil QR
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch('http://127.0.0.1:8000/store-scan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'include', // Wajib untuk session cookie
                    body: JSON.stringify({
                        customer: data.customer,
                        plan: data.plan,
                        cycle: data.cycle
                     })
                })
                .then(response => response.json())
                .then(data => {
                        const alertDiv = document.getElementById('responseAlert');
                        alertDiv.textContent = data.message; // Set pesan
                        alertDiv.classList.remove('d-none'); // Tampilkan alert

                        setTimeout(() => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            }
                        }, 2000);
                })
                    .catch(error => {
                        console.error('Error:', error);
                        const alertDiv = document.getElementById('responseAlert');
                        alertDiv.textContent = 'Terjadi kesalahan saat menyimpan data!';
                        alertDiv.classList.remove('d-none'); // Tampilkan alert
                    });
            } catch (error) {
                console.error('Tidak Valid (bukan JSON):', error);
                alert('QR Code tidak sesuai format!');
            }
        }

        function onScanFailure(error) {
            console.warn(`Scan error: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            {
                fps: 10,
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                let minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                return { width: minEdge * 0.8, height: minEdge * 0.8 }; // QR box adaptif
                }
            },
            false
        );

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@endpush
