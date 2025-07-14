<?php

namespace App\Http\Controllers;

use App\Models\CheckManifest;
use App\Models\TblDeliveryhpm;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ManifestScanController extends Controller
{
    public function filterManifest(){
        // filter manifest berdasarkan data session yang sudah ada
        $dataSession = [
            'customer' => session('customer'),
            'plan' => session('plan'),
            'cycle' => session('cycle'),
        ];

        $customer = strtolower($dataSession['customer']);
        $modelCustomer = match ($customer) {
            'hpm' => 'App\Models\TblDeliveryhpm',
            'mmki' => 'App\Models\TblDeliverynote',
            default => null,
        };

        if ($modelCustomer === null) {
            return false;
        }

        // filter data berdasarkan plan dan cycle
        if ($modelCustomer) {
            $datas = $modelCustomer::orderBy('tanggal_order', 'desc');

            // cek apakah ada plan atau cycle
            if($dataSession['plan'] || $dataSession['cycle']) {
                if ($dataSession['plan']) {
                    $datas->where('plan', $dataSession['plan']);
                }
                if ($dataSession['cycle']) {
                    $datas->where('cycle', $dataSession['cycle']);
                }
            }
            return $datas;
        }


    }

    public function openScanManifest(){
        if($this->filterManifest() === false) {
            return redirect()
                ->route('dashboard')
                ->with('alert', [
                'type'    => 'warning',
                'message' => 'Customer tidak ditemukan, silakan scan waiting post terlebih dahulu.',
            ]);
        };

        $data = [];

        // ambil data manifest blm scan
        $manifestQuery = $this->filterManifest();
        $manifestQuery->whereNotIn( 'dn_no',
            function ($query) {
            $query->select('input_manifest')->from('check_manifest');
        });

        $manifestData = $manifestQuery->get();

        $customer = ucfirst(session('customer'));
        $manifestStatus = null;

        return view(
            'scan.input-manifest',
        compact(
            'manifestData',
            'customer',
                    'data'));
    }

    public function storeManifest(Request $request)
    {
        // validasi manifest
        $request->validate([
            'manifest' => 'required|string|max:255',
        ]);

        // untuk input ke tb_check_manifest
        $inputData = [
            'input_manifest' => $request->input('manifest'),
            'status' => null,
        ];

        // ambil manifest dari tabel customer
        $manifestCustomer = $this->filterManifest();
        $manifest = $manifestCustomer->where('dn_no', $request->input('manifest'))->first();

        Log::debug('Data Manifest:', ['manifest' => $manifest]);

        if ($manifest) {
            // jika manifest ditemukan, simpan ke database
            $inputData['status'] = 'OK';
            $newData = $manifest->checkManifest()->create($inputData);

            return response()
                ->json([
                'success' => true,
                'message' => 'Data manifest sesuai!',
                'data' => $newData,
                'html' => view('partials.table-row', ['item1' => $newData, 'counter' => 1])->render()
                ], 200);
        } else {
            // jika manifest tidak ditemukan, simpan ke database dengan status NG
            $inputData['status'] = 'NG';
            $inputData['manifest_id'] = null;
            $newData = CheckManifest::create($inputData);

            return response()
                ->json([
                'success' => false,
                'message' => 'Data manifest tidak ditemukan.',
                'data' => $newData,
                'html' => view('partials.table-row', ['item1' => $newData, 'counter' => 1])->render()
                ], 200);
        }
    }

    public function dataCustomer() {
        if($this->filterManifest() === false) {
            return redirect()
                ->route('dashboard')
                ->with('alert', [
                'type'    => 'warning',
                'message' => 'Customer tidak ditemukan, silakan scan waiting post terlebih dahulu.',
            ]);
        };

        $data = $this->filterManifest();
        $customer = ucfirst(session('customer'));
        return view(
            'scan.input-manifest',
            compact(
                'data',
                'customer'
            )
        );
    }
}
