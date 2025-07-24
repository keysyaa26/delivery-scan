<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Database\Factories\CustomerFactory;

class CustomerLabelController extends Controller
{
    public function getPartsData (Request $request) {
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $manifest = $request->input('manifest');

        $objekCustomer = CustomerFactory::createCustomerInstance($customer);
        $dataParts = $objekCustomer->getMasterparts($manifest);

        if($dataParts) {
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Data manifest sesuai!',
                    'html' => view('partials.table-parts', compact('dataParts'))->render(),
                    'data' => $dataParts
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Data manifest tidak sesuai!'
                ], 200);
        }
    }

    public function getLabelCust() {
        $manifest = 'HPM 002024040100';

        $dataLabel = DB::table('tbl_kbndelivery')
            ->where('dn_no', $manifest)
            ->select('job_no', 'seq_no', 'invid')
            ->get();

        $jobNos = $dataLabel->pluck('job_no')->unique();
        $invIds = $dataLabel->pluck('invid')->unique();

        $hpmData = DB::table('vw_data_hpm')
            ->where('dn_no', $manifest)
            ->whereIn('job_no', $jobNos)
            ->whereIn('InvId', $invIds)
            ->get();
    }
}
