<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use App\Services\DashboardServices;
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

    public function getAdminCheck(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Close',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataChecked = $dashboardServices->cardAdmin($filters);

        return response()->json([
            'totalPlan' => $dataChecked['totalPlan'] ?? 0,
            'totalActual' => $dataChecked['totalActual'] ?? 0
        ]);
    }

    public function viewMoreAdmin(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Close',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataAdmin = $dashboardServices->cardAdmin($filters);

        if(empty($dataAdmin)) {
            return view('pages.view-more-admin', compact('dataAdmin'));
        }
        $dataAdmin = $dataAdmin['data'];

        return view('pages.view-more-admin', compact('dataAdmin'));
    }

    public function getPrepareData(Request $request, DashboardServices $dashboardServices) {
        $dataOpen = $dashboardServices->cardPrepare([
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024'
        ]);

        $dataClose = $dashboardServices->cardPrepare([
            'status_label' => 'Close',
            'tanggal_order' => '31-12-2024'
        ]);

        return response()->json([
            'totalOpen' => $dataOpen['totalData'] ?? 0,
            'totalClosed' => $dataClose['totalData'] ?? 0
        ]);
    }

    public function viewMorePrepare(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'tanggal_order' => '31-12-2024'
        ];

        $dataPrepare = $dashboardServices->dataToday($filters);

        return view('pages.view-more-admin', compact('dataPrepare'));


    }

    public function getCheckedData(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataChecked = $dashboardServices->cardChecked($filters);

        return response()->json([
            'totalPlan' => $dataChecked['totalPlan'] ?? 0,
            'totalActual' => $dataChecked['totalActual'] ?? 0
        ]);
    }
    public function viewMoreChecked (Request $request, DashboardServices $dashboardServices){
        $filters = [
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataChecked = $dashboardServices->cardChecked($filters);
        if(empty($dataChecked)) {
            return view('pages.view-more-admin', compact('dataChecked'));
        }
        $dataChecked = $dataChecked['data'];

        return view('pages.view-more-admin', compact('dataChecked'));
    }

    public function getSJData(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataChecked = $dashboardServices->cardSuratJalan($filters);

        return response()->json([
            'totalPlan' => $dataChecked['totalPlan'] ?? 0,
            'totalActual' => $dataChecked['totalActual'] ?? 0
        ]);
    }

    public function viewMoreSJ(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024' //tanggal ganti
        ];
        $dataSJ = $dashboardServices->cardSuratJalan($filters);
        if(empty($dataSJ)) {
            return view('pages.view-more-admin', compact('dataSJ'));
        }
        $dataSJ = $dataSJ['data'];

        return view('pages.view-more-admin', compact('dataSJ'));

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

    public function checkLoading() {
        $user = auth()->user();

        if (in_array($user->id_role, ['1', '2'])) {
            return view('pages.loading');
        } else {
            return redirect()->route('dashboard')->with('error', 'User tidak memiliki akses ke halaman ini.');
        }
    }

    public function tes(Request $request, DashboardServices $dashboardServices) {
        $filters = [
            'status_label' => 'Open',
            'tanggal_order' => '31-12-2024'
        ];
        $dataChecked = $dashboardServices->cardAdmin($filters);

        dd($dataChecked); // For debugging purposes, remove in production
    }
}
