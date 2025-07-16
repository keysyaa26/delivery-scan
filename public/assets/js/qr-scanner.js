// Fungsi utama untuk memulai scanner
function initializeQrScanner() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let html5QrCode;

    // Konfigurasi scanner
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 }
    };

    // Mulai scanner
    function startScanner() {
        html5QrCode = new Html5Qrcode("qrReader");

        html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            onScanError
        ).then(() => {
            updateScannerStatus("Arahkan kamera ke QR Code");
        }).catch(err => {
            onScanError(err);
        });
    }

    // Handle scan berhasil
    async function onScanSuccess(decodedText) {
        try {
            // Tampilkan status processing
            updateScannerStatus("Memproses QR Code...");

            // Parse data JSON dari QR (jika QR berisi JSON)
            let qrData = {};
            try {
                qrData = JSON.parse(decodedText);
            } catch {
                qrData = { qr_content: decodedText };
            }

            // Kirim data ke server
            const response = await fetch('http://127.0.0.1:8000/store-scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(qrData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan');
            }

            // Tampilkan SweetAlert sukses
            await Swal.fire({
                title: 'Berhasil!',
                text: data.message || 'Data berhasil disimpan',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });

            // Redirect jika ada dalam response
            if (data.redirect) {
                window.location.href = data.redirect;
            }

        } catch (error) {
            onScanError(error);
        } finally {
            // Mulai ulang scanner
            startScanner();
        }
    }

    // Handle scan error
    function onScanError(error) {
        console.error('Scan Error:', error);
        updateScannerStatus("Error: " + (error.message || 'Gagal memindai'));

        Swal.fire({
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat scanning',
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        }).then(() => {
            startScanner();
        });
    }

    // Update status scanner
    function updateScannerStatus(message) {
        const statusElement = document.getElementById('scannerStatus');
        if (statusElement) {
            statusElement.textContent = message;
        }
    }

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Html5Qrcode !== 'undefined') {
            startScanner();
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Scanner library tidak terdeteksi',
                icon: 'error'
            });
        }
    });

    // Hentikan scanner saat halaman ditutup
    window.addEventListener('beforeunload', function() {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop();
        }
    });
}

// Ekspos fungsi jika diperlukan
window.initializeQrScanner = initializeQrScanner;
