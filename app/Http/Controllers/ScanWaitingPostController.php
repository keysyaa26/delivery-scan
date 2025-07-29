<?php

namespace App\Http\Controllers;

use Database\Factories\CustomerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScanWaitingPostController extends BaseController
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    public function index (Request $request) {
        $manifests = null;

        $date = $request->input('date') ?? null;

        if(session('customer')) {
            $manifests = $this->dataIndex($date);
        }

        if (request()->ajax()) {
            logger()->debug('Ajax request received');
            return view('partials.table-manifest', ['manifests' => $manifests, 'counter' => 1])->render();
        }

        $user = Auth::user();
        if (in_array($user->id_role, [1, 2])) {
            return view('pages.leader', compact('manifests'));
        }
        return view('pages.admin', compact('manifests'));
    }

    public function storeScan(Request $request) {
        $this->validate($request, [
            'customer' => 'required',
            'cycle' => 'required',
            'route' => 'required',
        ]);

        $date = $request->input('date');

        try {
            session([
                'customer' => $request->input('customer'),
                'cycle' => $request->input('cycle'),
                'route' => $request->input('route'),
            ]);

            $manifests = $this->dataIndex($date);

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

    public function storeScan2(Request $request) {
        $this->validate($request, [
            'customer' => 'required',
            'cycle' => 'required',
            'route' => 'required',
        ]);

        $date = $request->input('date');

        try {
            session([
                'customer' => $request->input('customer'),
                'cycle' => $request->input('cycle'),
                'route' => $request->input('route'),
            ]);

            $manifests = $this->dataIndex($date);

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Scan berhasil!',
                    'html' => view('partials.table-manifest', compact('manifests'))->render(),
                    'data' => $manifests,
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

    public function dataTableSJ(Request $request) {
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');
        $route = session('route');
        $date = $request->query('date');

        $object = CustomerFactory::createCustomerInstance($customer);
        $manifests = $object->checkManifestCustomer($cycle, $route);
        if ($date) {
                $manifests = $manifests->filter(function ($item) use ($date) {
                    return Carbon::parse($item->tanggal_order)->toDateString() === $date;
                });
            }
        $statusSJ = $object->manifestWithSuratJalan($manifests);

        return response()->json([
            'html' => view('partials.table-surat-jalan', ['datas' => $statusSJ])->render(),
            'success' => true,
            'data' => $statusSJ
        ]);
    }
}
