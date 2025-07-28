<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use Database\Factories\CustomerFactory;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getAdminCheck() {
        $objekCustomer = CustomerFactory::createCustomerInstance('hpm');
        // data plan = data all
        $data = $objekCustomer->dailyCheck('24-03-2025');
        $dataActual = $data->where('status_label', 'Close');



        $totalPlan = $data->sum('qty_pcs');
        $totalActual = $data->sum(function($item) {
            return $item->QtyPerKbn * $item->countP;
        });

        dd($dataActual);
    }

    public function getPrepareData() {
        $objekCustomer = CustomerFactory::createCustomerInstance('hpm');
        $data = $objekCustomer->dailyCheck('24-03-2025');

        $dataOpen = $data->where('status_label', 'Open');
        $dataClosed = $data->where('status_label', 'Close');
        
        
        $totalOpen = $dataOpen->sum('qty_pcs');
        $totalClosed = $dataClosed->sum('qty_pcs');
        Log::info('Total Open: ' . $totalOpen);

        return response()->json([
            'totalOpen' => $totalOpen,
            'totalClosed' => $totalClosed,
        ]);
    }

    public function scanAdmin() {
        return view('pages.admin');
    }

    public function scanLeader() {
        $user = auth()->user();

        if (in_array($user->id_role, ['1', '2'])) {
            return view('pages.leader');
        } else {
            return redirect()->route('dashboard')->with('error', 'User tidak memiliki akses ke halaman ini.');
        }
    }
}
