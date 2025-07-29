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
        $data = $objekCustomer->dailyCheck(); //tanggal di sini
        $dataActual = $data->where('status_label', 'Close');
        $totalPlan = $data->sum('qty_pcs');
        $totalActual = $dataActual->sum(function($item) {
            return $item->QtyPerKbn * $item->countP;
        });

        return response()->json([
            'totalPlan' => $totalPlan,
            'totalActual' => $totalActual,
        ]);
    }

    public function getPrepareData() {
        $objekCustomer = CustomerFactory::createCustomerInstance('hpm');
        $data = $objekCustomer->dailyCheck(); //tanggal di sini
        $dataOpen = $data->where('status_label', 'Open');
        $dataClosed = $data->where('status_label', 'Close');
        $totalOpen = $dataOpen->sum('qty_pcs');
        $totalClosed = $dataClosed->sum('qty_pcs');

        return response()->json([
            'totalOpen' => $totalOpen,
            'totalClosed' => $totalClosed,
        ]);
    }

    public function getCheckedData() {
        $objekCustomer = CustomerFactory::createCustomerInstance('hpm');
        $data = $objekCustomer->dataDashboardChecked(); //tanggal di sini
        $data = $data->where('status_label', 'Open');
        $dataPlan = $data->sum('qty_pcs');
        $dataActual = $data->sum(function($item) {
            return $item->QtyPerKbn * $item->countP;
        });

        Log::info($data);

        return response()->json([
            'totalPlan' => $dataPlan,
            'totalActual' => $dataActual,
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

    public function checkSuratJalan() {
        $user = auth()->user();

        if (in_array($user->id_role, ['1', '2'])) {
            return view('pages.surat-jalan');
        } else {
            return redirect()->route('dashboard')->with('error', 'User tidak memiliki akses ke halaman ini.');
        }
    }
}
