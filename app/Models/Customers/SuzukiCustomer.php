<?php

namespace App\Models\Customers;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;

class SuzukiCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliverysuzuki';
    }
    protected function getLogChannel(): string
    {
        return 'suzuki_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_suzuki';
    }
}
