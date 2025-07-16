<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;

class SessionQrController extends Controller
{
     public function generateQrCode()
     {
        $data = [
            'customer' => 'hpm',
            'cycle' => '3'
        ];
         $qrText = json_encode($data);

         return view('QrMake', compact('qrText'));
     }
}
