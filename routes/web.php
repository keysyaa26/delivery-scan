<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CustomerLabelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\ManifestScanController;
use App\Http\Controllers\PoCheckController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ScanWaitingPostController;
use App\Http\Controllers\SessionQrController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('/');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'destroy')->name('logout');
    Route::post('/close-scan','endSessionCustomer')->name('scan.end-session');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)
        ->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
    });

    Route::controller(ScanWaitingPostController::class)
        ->name('wp.')
        ->prefix('waiting-post')
        ->group(function () {
            Route::post('store-scan', 'storeScan')->name('store-scan');
            Route::post('store-scan-2', 'storeScan2')->name('store-scan-2');
            Route::get('index', 'index')->name('index');
            Route::get('tes', 'tes')->name('tes');
            Route::get('/data-manifest', 'dataManifest')->name('data-manifest');
    });

    Route::controller(PoCheckController::class)
        ->name('po.')
        ->prefix('manifest')
        ->group(function () {
            Route::post('store-scan', 'processScan')->name('store-scan');
    });

    Route::controller(CustomerLabelController::class)
        ->name('label.')
        ->prefix('customer-label')
        ->group(function () {
            Route::post('parts-data', 'getPartsData')->name('parts-data');
            Route::post('store-scan', 'checkPartData')->name('store-scan');
    });

});

Route::get('/coba-label', [CustomerLabelController::class, 'getLabelCust']);

?>
