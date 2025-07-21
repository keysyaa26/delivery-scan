<?php

namespace App\Http\Controllers;

use Database\Factories\CustomerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScanWaitingPostController extends BaseController
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    public function index () {
        $manifests = null;
        if(session('customer')) {
            $manifests = $this->dataIndex();
        }
        return view('pages.wp-index', compact('manifests'));
    }

    public function openScanWaitingPost (Request $request) {
        return view('scan.waiting-post');
    }

    public function storeScan(Request $request) {
        $this->validate($request, [
            'customer' => 'required',
            'cycle' => 'required',
        ]);

        $date = $request->input('date');

        try {
            session([
                'customer' => $request->input('customer'),
                'cycle' => $request->input('cycle'),
            ]);

            $manifests = $this->dataIndex($date);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Scan berhasil!',
                    'manifests' => $manifests
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

    public function tes(Request $request) {
        dd(session('customer'));
    }
}
