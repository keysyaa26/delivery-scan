<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Manifest Scanner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
<body class="scan">

    <!-- Scanner Container -->
    <div id="reader-container" style="position: relative; width: 300px; height: 300px; margin: auto;">
        <!-- Kotak Hijau -->
        <div class="custom-barcode-frame"></div>
        <!-- Tempat Kamera -->
        <div id="reader" style="width: 100%; height: 100%;"></div>
    </div>

    <!-- Info dan Tombol -->
    <div class="scanner-info" style="text-align: center; margin-top: 10px;">
        <div class="info-text">Arahkan kamera ke Barcode Manifest</div>
        <a href="{{ route('wp.index') }}" class="btn btn-danger">Kembali</a>
    </div>

    <!-- Form untuk mengirim hasil -->
    <form action="{{ route('po.store-scan') }}" method="POST" id="barcodeForm">
        @csrf
        <input type="hidden" name="barcode_result" id="barcodeResult">
    </form>




<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const barcodeForm = document.getElementById("barcodeForm");
    const barcodeResult = document.getElementById("barcodeResult");

    function onScanSuccess(decodedText) {
        const data = JSON.parse(decodedText);
        const csrfToken = document.querySelector('input[name="_token"]').value;

        console.log(data);

        .then(response => response.json())
        .then(data => {
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
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengirim data.'
            });

        });
    }
    function onScanFailure(error) {
            console.warn(`Scan error: ${error}`);
    }

    const html5QrCode = new Html5Qrcode("reader");
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            const cameraId = devices[0].id;
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                onScanSuccess,
                onScanFailure
            );
        }
    }).catch(err => {
        console.error("Camera error:", err);
    });
</script>

</body>

</html>
