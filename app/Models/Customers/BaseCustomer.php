<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use Carbon\Carbon;

abstract class BaseCustomer extends Model
{
    protected $tableName;
    protected $logChannel;
    abstract public function getTableName(): string;
    abstract protected function getLogChannel(): string;
    abstract public function getTableMasterparts(): string;
    abstract public function getViewTable(): string;

    // ambil data manifest pada cycle yg ditentukan
    public function checkManifestCustomer($cycle, $route) {
        $datas = DB::table($this->getTableName())
                ->where('cycle', $cycle)
                ->where('plan', $route)
                ->orderBy('tanggal_order', 'asc')
                ->get();

        return $datas;
    }

    public function getDataManifest($manifest_id, $process, $cycle){
        $manifest = DB::table($this->getTableName())
                    ->where('cycle', $cycle)
                    ->where('dn_no', $manifest_id)
                    ->first();

        $this->logCheck($manifest_id, $manifest ? 'OK' : 'NG', $process);
        $this->tableLogCheck($manifest_id, $manifest ? 'OK' : 'NG', $process);

        return $manifest;
    }

    public function checkManifestCustomerSJ($cycle, $manifest_id) {
        $datas = DB::table($this->getTableName())
                ->where('dn_no', $manifest_id)
                ->where('cycle', $cycle)
                ->get();
        $this->tblSjCheck($manifest_id, $manifest_id ? 1 :0);

        return $datas;
    }

    public function tblSjCheck($dn, $status) {
        $data = DB::table('tbl_check_sj')
            ->where('dn_no', $dn)
            ->where('table_name', $this->getTableName())
            ->first();

        if ($data) {
            DB::table('tbl_check_sj')
                ->where('dn_no', $dn)
                ->where('table_name', $this->getTableName())
                ->update(['check_sj' => $status,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('tbl_check_sj')
                ->insert([
                    'dn_no' => $dn,
                    'check_sj' => $status,
                    'checked_by' => auth()->user()->id_user,
                    'table_name' => $this->getTableName(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

    }
    public function logCheck($manifest_id, $status, $process){
        Log::channel($this->getLogChannel())
            ->info('Check Manifest', [
                'no_dn' => $manifest_id,
                'status' => $status,
                'process' => $process,
                'customer_tbl' => $this->getTableName(),
                'date_time' => now(),
                'scanned_by' => auth()->user()->name
            ]);
    }

    public function tableLogCheck ($manifest_id, $status, $process) {
        DB::table('tb_input_log')
            ->insert([
                'no_dn' => $manifest_id,
                'status' => $status,
                'process' => $process,
                'customer_tbl' => $this->getTableName(),
                'scanned_by' => auth()->user()->id_user,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    // ambil data di tabel log
    public function getLatestStatus($manifest_id) {
        return DB::table('tb_input_log')
            ->where('customer_tbl', $this->getTableName())
            ->where('file_number', $manifest_id)
            ->latest('scan_timestamp')
            ->value('status');
    }

    // satukan data manifest dan log
    public function getAllWithStatus($filteredData) {

        if (!$filteredData instanceof \Illuminate\Support\Collection) {
            $filteredData = collect($filteredData);
        }

        $fileNumbers = $filteredData->pluck('dn_no')->unique()->filter()->values();

        // ambil status terakhir untuk setiap manifest
        if ($fileNumbers->isEmpty()) {
            return $filteredData->map(function ($item) {
                $item->status = null;
                return $item;
            });
        }

        $statuses = DB::table('tb_input_log')
            ->where('customer_tbl', $this->getTableName())
            ->whereIn('no_dn', $fileNumbers)
            ->select('no_dn', 'status')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('no_dn')
            ->map(function ($logs) {
                return $logs->first()->status;
            });

        return $filteredData->map(function ($customer) use ($statuses) {
            $customer->status = $statuses[$customer->dn_no] ?? null;
            return $customer;
        });
    }

    // ambil data manifest yg OK
    public function getOkManifest ($filteredData) {
    }


    public function getMasterparts ($manifest) {
        $datas = DB::table($this->getViewTable())
            ->orderBy('tanggal_order', 'asc')
            ->where('dn_no', $manifest)
            ->get();

        return $datas;
    }

    public function getDataLabel($labelNo) {
        $data = DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $labelNo)
            ->first();

        $this->checkDataLabel($labelNo, $data ? true : false);

        return $data;
    }

    public function checkDataLabel($labelNo, $status) {
        DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $labelNo)
            ->update([
                'check_leader' => $status,
                'checked_by' => auth()->user()->id_user
            ]);
    }

    public function dailyCheck($date = null) {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $formatedDate = $date ->format('d-m-Y');

        $manifests = DB::table($this->vwTblDataHpm())
            ->where('tanggal_order', $formatedDate)
            ->select('dn_no', 'job_no', 'tanggal_order', 'qty_pcs', 'QtyPerKbn', 'sequence', 'countP', 'status_label')
            ->get();

        if($manifests->isEmpty()) {
            return collect([]);
        }

        $manifestNumber = $manifests->pluck('dn_no')->unique()->values();

        $status = DB::table('tb_input_log')
            ->whereIn('no_dn', $manifestNumber)
            ->select('no_dn', 'status')
            ->get()
            ->groupBy('no_dn')
            ->map(function ($logs) {
                return $logs->first()->status;
            });
            // gabungkan data manifest dengan status
            $data = $manifests->map(function ($manifest) use ($status) {
                $manifest->status = $status[$manifest->dn_no] ?? null;
                return $manifest;
            });
        return $data;
    }

    public function getTodayManifest($date = null) {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $formatedDate = $date->format('d-m-Y');

        $manifests = DB::table($this->vwTblDataHpm())
            ->where('tanggal_order', $formatedDate)
            ->select('dn_no', 'job_no', 'tanggal_order', 'qty_pcs', 'QtyPerKbn', 'sequence', 'countP')
            ->get();

        return $manifests;
    }

    public function dataDashboardChecked($date = null) {
        $data = $this->getTodayManifest($date);
        $manifestNumber = $data->pluck('dn_no')->unique()->values();
        $jobNumber = $data->pluck('job_no')->unique()->values();

        $checkLeader = DB::table('tbl_kbndelivery')
            ->whereIn('kbndn_no', $manifestNumber)
            ->whereIn('job_no', $jobNumber)
            ->select('kbndn_no', 'job_no', 'check_leader')
            ->get()
            ->groupBy('kbndn_no')
            ->map(function ($logs) {
                return $logs->first()->check_leader;
            });

        // gabungkan data
        $datas = $data->map(function ($manifest) use ($checkLeader) {
            $manifest->check_leader = $checkLeader[$manifest->dn_no] ?? null;
            return $manifest;
        });

        return $datas;
    }

    public function manifestWithSuratJalan($filteredData) {
        $manifestNumbers = $filteredData->pluck('dn_no')->unique()->filter()->values();
        $statuses = DB::table('tbl_check_sj')
            ->whereIn('dn_no', $manifestNumbers)
            ->select('dn_no', 'check_sj')
            ->get()
            ->groupBy('dn_no')
            ->map(function ($logs) {
                return $logs->first()->check_sj;
            });

        return $filteredData->map(function ($manifest) use ($statuses) {
            $manifest->check_sj = $statuses[$manifest->dn_no] ?? null;
            return $manifest;
        });
    }
}
