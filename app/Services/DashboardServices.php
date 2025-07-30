<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardServices {

    private $customerName = [
        'vw_data_hpm' => 'HPM',
        'vw_data_adm' => 'ADM',
        'vw_data_hino' => 'HINO',
        'vw_data_suzuki' => 'SUZUKI',
        'vw_data_mmki' => 'MMKI',
        'vw_data_tmmin' => 'TMMIN'
        // Add other customer tables as needed
    ];

    public function cardAdmin(array $filters = []) {

        $allData = $this->dataToday($filters);
        $manifest = $allData->pluck('dn_no');

        $statuses = DB::table('tb_input_log')
            ->select('no_dn', 'status')
            ->whereIn('no_dn', $manifest)
            ->get()
            ->groupBy('dn_no')
            ->map(function ($group) {
                return $group->last();
            });

        $dataWithStatus = $allData->map(function ($item) use ($statuses) {
            $status = $statuses[$item->dn_no] ?? null;
            $item->status = $status ? $status->status : null;
            return $item;
        });

        if($dataWithStatus->isEmpty()) {
            return [];
        }

        return [
            'data' => $dataWithStatus,
            'totalPlan' => $dataWithStatus->sum('qty_pcs'),
            'totalActual' => $dataWithStatus->sum(function($item) {
                return $item->QtyPerKbn * $item->countP;
            })
        ];
    }

    public function cardPrepare(array $filters = []) {
        $allData = $this->dataToday($filters);

        return [
            'totalData' =>$allData->sum('qty_pcs'),
            'data' => $allData
        ];
    }

    public function cardChecked(array $filters = []) {
        $allData = $this->dataToday($filters);
        $dnNo = $allData->pluck('dn_no');
        $jobNo = $allData->pluck('job_no');

        $statuses = DB::table('tbl_kbndelivery')
            ->select('kbndn_no', 'check_leader')
            ->whereIn('dn_no', $dnNo )
            ->whereIn('job_no', $jobNo)
            ->get()
            ->groupBy('dn_no')
            ->map(function ($group) {
                return $group->last();
            });

        $dataWithStatus = $allData->map(function ($item) use ($statuses) {
            $status = $statuses[$item->dn_no] ?? null;
            $item->check_leader = $status ? $status->check_leader : null;
            return $item;
        });

        return [
            'data' => $dataWithStatus,
            'totalPlan' => $dataWithStatus->sum('qty_pcs'),
            'totalActual' => $dataWithStatus->sum(function($item) {
                return $item->QtyPerKbn * $item->countP;
            })
        ];
    }

    public function cardSuratJalan(array $filters = []) {
        $allData = $this->dataToday($filters);
        $dnNo = $allData->pluck('dn_no')->toArray();

        $statuses = DB::table('tbl_check_sj')
            ->where('dn_no', $dnNo)
            ->select('dn_no', 'check_sj', 'check_loading')
            ->get()
            ->groupBy('dn_no')
            ->map(function ($group) {
                return $group->first();
            });

        $dataWithStatus = $allData->map(function ($item) use ($statuses) {
            $status = $statuses[$item->dn_no] ?? null;
            $item->check_sj = $status ? $status->check_sj : null;
            $item->check_loading = $status ? $status->check_loading : null;
            return $item;
        });

        return [
            'data' => $dataWithStatus,
            'totalPlan' => $dataWithStatus->sum('qty_pcs'),
            'totalActual' => $dataWithStatus->sum(function($item) {
                return $item->QtyPerKbn * $item->countP;
            })
        ];
    }

    public function dataToday (array $filters = []) {
        $query = DB::table('vw_data_hpm')
            ->select(
                'tanggal_order',
                'dn_no',
                'job_no',
                'cycle',
                'customerpart_no',
                'qty_pcs',
                'QtyPerKbn',
                'countP',
                'status_label')
            ->when(isset($filters['tanggal_order']), function ($query) use ($filters) {
                return $query->where('tanggal_order', $filters['tanggal_order']);
            })
            ->when(isset($filters['status_label']), function ($query) use ($filters) {
                return $query->where('status_label', $filters['status_label']);
            });

        $tableName = array_keys($this->customerName);
        $allData = collect();

        foreach ($tableName as $table) {
            $data = (clone $query)->from($table)->get();
            $data = $data->map(function ($item) use ($table) {
                $item->customer = $this->customerName[$table];
                return $item;
            });
            $allData = $allData->merge($data);
        }

        return $allData;
    }
}
?>
