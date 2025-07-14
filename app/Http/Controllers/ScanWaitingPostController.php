<?php

namespace App\Http\Controllers;

use Database\Factories\CustomerFactory;
use Illuminate\Http\Request;

class ScanWaitingPostController extends Controller
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;
    public function index($dataManifest)
    {
        $data = $dataManifest;
        return view('pages.form-waiting-post', compact('data'));
    }

    public function scanWaitingPost(Request $request) {
        $this->validate($request, [
            'customer' => 'required',
            'cycle' => 'required',
        ]);

        $customer = strtolower($request->input('customer'));
        $cycle = $request->input('cycle');

        $manifestCustomer = CustomerFactory::createCustomerInstance($customer);
        $dataManifest =$manifestCustomer->checkManifestCustomer($cycle); //bentuk collection (hrs loop)
        return $this->index($dataManifest);
    }
}
