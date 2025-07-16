<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Database\Factories\CustomerFactory;

abstract class BaseController extends Controller
{
    /**
     * Mendapatkan data manifest berdasarkan siklus
     *
     * @param string $customerType Jenis customer (cust1, cust2, dst)
     * @param string $cycle Siklus yang dipilih
     * @return \Illuminate\Support\Collection
     */

    // ambil manifest dgn status
    protected function getDataManifest($customerType, $cycle)
    {
        // 1. Buat instance customer
        $customer = CustomerFactory::createCustomerInstance($customerType);

        // 2. Ambil data manifest berdasarkan siklus
        $manifestData = $customer->checkManifestCustomer($cycle);

        // 3. Tambahkan status untuk setiap record
        return $customer->getAllWithStatus($manifestData);
    }

    public function customerCycleManifest($customer, $cycle) {
        $customer = CustomerFactory::createCustomerInstance($customer);
        return $customer->checkManifestCustomer($cycle);
    }
}
