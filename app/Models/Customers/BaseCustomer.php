<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseCustomer extends Model
{
    protected $tableName;
    protected $logChannel;
    abstract public function getTableName(): string;
    abstract protected function getLogChannel(): string;

    public function checkManifestCustomer($cycle){
        $datas = DB::table($this->getTableName())
                ->where('cycle', $cycle)
                ->get();

        return $datas;
    }

    public function getDataManifest($manifest_id, $process){
        $manifest = DB::table($this->getTableName())
                    ->where('no_dn', $manifest_id)
                    ->first();

        $this->logCheck($manifest_id, $manifest ? 'OK' : 'NG', $process);

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
}
