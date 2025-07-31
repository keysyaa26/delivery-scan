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
            // halaman di sidebar
            Route::get('dashboard', 'index')->name('dashboard');
            Route::get('scan-admin', 'scanAdmin')->name('scanAdmin');
            Route::get('scan-leader', 'scanLeader')->name('scanLeader');
            Route::get('check-surat-jalan', 'checkSuratJalan')->name('checkSuratJalan');
            Route::get('loading', 'checkLoading')->name('checkLoading');

            // cards data
            Route::get('get-admin-data', 'getAdminCheck')->name('dataAdmin');
            Route::get('get-prepare-data', 'getPrepareData')->name('dataPrepare');
            Route::get('get-checked-data', 'getCheckedData')->name('dataChecked');
            Route::get('get-sj-data', 'getSJData')->name('dataSJ');

            // view more
            Route::get('view-more-admin', 'viewMoreAdmin')->name('viewMoreAdmin');
            Route::get('view-more-prepare', 'viewMorePrepare')->name('viewMorePrepare');
            Route::get('view-more-checked', 'viewMoreChecked')->name('viewMoreChecked');
            Route::get('view-more-sj', 'viewMoreSJ')->name('viewMoreSJ');
            Route::get('view-more-loading', 'viewMoreSJ')->name('viewMoreLoading');
            Route::get('tes', 'tes')->name('tes'); // For testing purposes
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

            // untuk surat jalan
            Route::get('data-table-sj', 'dataTableSJ')->name('data-table-sj');
        });

        Route::controller(PoCheckController::class)
        ->name('po.')
        ->prefix('manifest')
        ->group(function () {
            Route::post('store-scan', 'processScan')->name('store-scan');

            // untuk surat jalan
            Route::post('scan-sj', 'checkManifestSJ')->name('scan-sj');
            Route::post('scan-loading', 'checkLoading')->name('scan-loading');
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
Route::get('tes-scan', function () {
    return view('pages.scan');
})

?>
