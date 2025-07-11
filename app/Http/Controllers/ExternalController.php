<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    public function DeliveryHpm()
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            'https://kyoraku-apps.com/barcode-delivery/MVC/pages/ajx/api_delivery_hpm.php'
        );
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return response()->json([
            'status' => $statusCode,
            'data' => json_decode($body, true),
        ]);
    }
}
