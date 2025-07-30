<?php

namespace App\Models\Customers;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;

class HinoCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliveryhino';
    }

    public function getLogChannel(): string
    {
        return 'hino_log';
    }

    public function getTableMasterparts(): string
        {
            return 'masterpart_hino';
        }

    public function vwTblData(): string
    {
        return 'vw_data_hino';
    }

    public function getViewTable(): string
    {
        return 'vw_kbndelivery_hino';
    }
}
