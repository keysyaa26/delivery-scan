<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\ManifestScanController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ScanWaitingPostController;
use App\Http\Controllers\SessionQrController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'destroy')->name('logout');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

Route::controller(ScanController::class)->name('scan.')->group(function () {
    Route::post('/store-scan', 'storeScanCustomer')->name('store-data');
    Route::get('/open-scan', 'openScan')->name('open');
    Route::post('/close-scan', 'endSessionCustomer')->name('end-session');
});

Route::controller(ManifestScanController::class)->name('manifest.')->group(function () {
    Route::get('/scan-manifest', 'filterManifest')->name('filter');
    Route::post('/store-manifest', 'storeManifest')->name('store');
    Route::get('/input-manifest', 'openScanManifest')->name('open');
    Route::get('/checked-manifest', 'checkedManifestIndex')->name('checked.index');
    // Route::get('/debug-manifest', 'debug')->name('debug');
});

Route::get('/scan-customer', function () {
    return view('scan-customer');
})->name('scan.customer');

Route::get('/input-customer-cycle', [ExternalController::class, 'DeliveryHpm'])
    ->name('store.customer.cycle');


Route::get('/session/qr', [SessionQrController::class, 'generateQrCode'])->name('session.qr');


Route::controller(ScanWaitingPostController::class)->group(function () {
    Route::get('/scan-waiting-post', 'scanWaitingPost')->name('open');
    Route::get('/wp/index', 'index')->name('store');
});

?>
