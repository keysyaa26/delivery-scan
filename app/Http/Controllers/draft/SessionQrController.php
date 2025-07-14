<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;

class SessionQrController extends Controller
{
     public function generateQrCode()
     {
         $data = [
            'customer' => session('customer'),
            'plan' => session('plan'),
            'cycle' => session('cycle'),
         ];
         $qrText = json_encode($data);

         return view('QrMake', compact('qrText'));
     }
}
