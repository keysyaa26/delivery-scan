<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\ManifestScanController;
use App\Http\Controllers\PoCheckController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ScanWaitingPostController;
use App\Http\Controllers\SessionQrController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'destroy')->name('logout');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});


Route::controller(ScanWaitingPostController::class)->name('wp.')->group(function () {
    Route::get('/wp/open-scan', 'openScanWaitingPost')->name('open-scan');
    Route::post('/wp/store-scan', 'storeScan')->name('store-scan');
    Route::get('/wp/index', 'index')->name('index');
    Route::get('/wp/tes', 'tes')->name('tes');
});

Route::controller(PoCheckController::class)->name('po.')->group(function () {
    Route::get('/po/open-scan', 'openScan')->name('open-scan');
    Route::post('/po/store-scan', 'processScan')->name('store-scan');
});

// QR maker untuk simulasi
Route::controller(SessionQrController::class)->name('session-qr.')->group(function () {
    Route::get('/session-qr', 'generateQrCode')->name('index');
    Route::get('/session-barcode', 'generateBarCode')->name('barcode');
    Route::get('/session-tes', 'tes')->name('tes');
});


Route::controller(ScanController::class)->name('scan.')->group(function () {
    Route::post('/store-scan', 'storeScanCustomer')->name('store-data');
    Route::get('/open-scan', 'openScan')->name('open');
    Route::post('/close-scan', 'endSessionCustomer')->name('end-session');
});
?>
