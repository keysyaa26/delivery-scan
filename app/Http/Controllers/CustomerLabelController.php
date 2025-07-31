<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class CustomerLabelController extends Controller
{
    public function getPartsData (Request $request) {
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $manifest = $request->input('manifest');

        $objekCustomer = CustomerFactory::createCustomerInstance($customer);
        $dataParts = $objekCustomer->getMasterparts($manifest);

        if($dataParts->count() > 0) {
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

    public function checkPartData(Request $request) {
        $request->validate([
            'parts' => 'required'
        ]);
        $customer = strtolower(session('customer'));

        $label = $request->input('parts');
        $objekCust = CustomerFactory::createCustomerInstance($customer);
        $checkedLabel = $objekCust->getDataLabel($label);
        $dataParts = $objekCust->getMasterparts($request->input('manifest'));

        if($checkedLabel) {
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Label customer sesuai!',
                    'html' => view('partials.table-parts', compact('dataParts'))->render(),
                    'data' => $dataParts
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Label customer tidak sesuai!'
                ], 200);
        }
    }

    public function getLabelCust()
    {
        $dataList = [
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '1'],
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '2'],
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '3'],
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '4'],
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '5'],
        ['customer' => 'HPM', 'route' => 'PLANT-2', 'cycle' => '6'],
        ['customer' => 'HPM', 'route' => 'ALOZ', 'cycle' => '1'],
        ['customer' => 'HPM', 'route' => 'ALOZ', 'cycle' => '2'],
        ['customer' => 'HPM', 'route' => 'BLSI', 'cycle' => '1'],
    ];

        return view('BarcodeMake', compact('dataList'));
    }

}
