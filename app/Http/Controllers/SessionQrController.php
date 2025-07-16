<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

use Illuminate\Http\Request;

class SessionQrController extends Controller
{
     public function generateQrCode()
     {
        $data = 'HPM 002024040100';
         $qrText = json_encode($data);

         return view('QrMake', compact('qrText'));
     }

    //  barcode untuk manifest
    public function generateBarCode(){
        $data = 'HPM 002024040101';

        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($data, $generator::TYPE_CODE_128));
        return view('BarcodeMake', compact('barcode', 'data'));
    }

    public function tes () {
        return view('scan.tes-barcode2');
    }
}
