<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;

abstract class BaseCustomer extends Model
{
    protected $tableName;
    protected $logChannel;
    abstract public function getTableName(): string;
    abstract protected function getLogChannel(): string;

    abstract public function getTableMasterparts(): string;

    // ambil data manifest pada cycle yg ditentukan
    public function checkManifestCustomer($cycle){
        $datas = DB::table($this->getTableName())
                ->where('cycle', $cycle)
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


    public function getMasterparts () {
    }
}
