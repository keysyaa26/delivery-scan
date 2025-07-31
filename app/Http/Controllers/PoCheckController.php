<?php

namespace App\Http\Controllers;

use App\Models\CheckSuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use Illuminate\Support\Facades\Auth;
use Http\Controllers\ScanWaitingPostController;

class PoCheckController extends BaseController
{

    public function processScan(Request $request) {
        $request->validate([
            'manifest' => 'required',
        ]);


        $manifest = request()->input('manifest');
        $process = 'check_po';
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        try {
            $customer = CustomerFactory::createCustomerInstance($customer);
            $result = $customer->getDataManifest($manifest, $process, $cycle);

            if($result) {
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Data manifest sesuai!',
                    ], 200);
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Data manifest tidak sesuai!'
                    ], 200);
            }
        } catch (\Throwable $e) {
            Log::error('Error: '.$e->getMessage());
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan di server: ' . $e->getMessage(),
                ], 500);
        }

    }

    public function checkManifestSJ(Request $request) {
        $request->validate([
            'manifest' => 'required',
        ]);

        $manifest = request()->input('manifest');
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $customer = CustomerFactory::createCustomerInstance($customer);
        $result = $customer->checkManifestCustomerSJ($cycle, $manifest);

        if($result->isNotEmpty()) {
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Data manifest sesuai!',
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Data manifest tidak sesuai!'
                ], 200);
        }
    }

    public function checkLoading(Request $request) {
        $request->validate([
            'manifest' => 'required',
        ]);
        $manifest = request()->input('manifest');
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $customer = CustomerFactory::createCustomerInstance($customer);

        // check scan surat jalan
        $scanSJ = CheckSuratJalan::where('dn_no', $manifest)->first();

        if(is_null($scanSJ)) {
            return response()->json([
                'success' => false,
                'message' => 'Belum Scan Surat Jalan!'
            ], 200);
        }

        $result = $customer->checkManifestLoading($manifest, $cycle);

        if($result) {
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Data loading berhasil scan!',
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Data loading tidak sesuai!'
                ], 200);
        }
    }
}
