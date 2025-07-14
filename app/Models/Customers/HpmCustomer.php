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
}
