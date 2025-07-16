<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoCheckController extends Controller
{
    public function openScan() {
        return view('scan.check-po');
    }

    public function processScan(Request $request) {
        $request->validate([
            'barcode_result' => 'required',
        ]);
    }
}
