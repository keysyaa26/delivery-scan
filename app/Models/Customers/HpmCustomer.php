<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class HpmCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliveryhpm';
    }
    protected function getLogChannel(): string
    {
        return 'hpm_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_hpm';
    }

    public function getViewTable(): string
    {
        return 'vw_kbndelivery_hpm';
    }

    public function vwTblDataHpm() {
        return 'vw_data_hpm';
    }
}
