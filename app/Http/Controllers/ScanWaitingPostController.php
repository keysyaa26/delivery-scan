<?php

namespace App\Http\Controllers;

use Database\Factories\CustomerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScanWaitingPostController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;
    public function index(Request $request)
    {

        // ambil data manifest untuk tabel
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $manifestCustomer = CustomerFactory::createCustomerInstance($customer);
        $dataManifest =$manifestCustomer->checkManifestCustomer($cycle); //bentuk collection (hrs loop)

        if ($request->query('date')) {
            $date = $request->query('date');
            $dataManifest = $dataManifest->filter(function ($item) use ($date) {
                return Carbon::parse($item->tanggal_order)->toDateString() === $date;
            });
        }

        $manifests = $manifestCustomer->getAllWithStatus($dataManifest); //ada status dari tb_log

        return view('pages.wp-index', compact( 'customer', 'cycle', 'manifests'));
    }

    public function openScanWaitingPost (Request $request) {
        return view('scan.waiting-post');
    }

    public function storeScan(Request $request) {
        $this->validate($request, [
            'customer' => 'required',
            'cycle' => 'required',
        ]);

        try {
            session([
                'customer' => $request->input('customer'),
                'cycle' => $request->input('cycle'),
            ]);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Scan berhasil!',
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
}
