<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Data manifest tidak sesuai!'
                ], 200);
        }

    }
}
