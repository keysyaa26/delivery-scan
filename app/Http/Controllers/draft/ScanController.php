<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function openScan(Request $request)
    {
        return view('scan.form-waiting-post');
    }

    public function storeScanCustomer(Request $request)
    {
        if($request->session()->has('customer')) {
            $this->forgetSession($request);
        }

        try {
            session([
                'customer' => $request->input('customer'),
                'plan' => $request->input('plan'),
                'cycle' => $request->input('cycle'),
            ]);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Session berhasil disimpan!',
                ], 200);
        } catch (\Throwable $e) {
            Log::error('QR Scan Error: '.$e->getMessage());

            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan di server: ' . $e->getMessage(),
                ], 500);
        }
    }

    public function forgetSession(Request $request)
    {
        session()->forget(['customer', 'plan', 'cycle']);
    }

    public function endSessionCustomer(Request $request)
    {
        $this->forgetSession($request);
        return redirect()->route('dashboard');
    }

}
