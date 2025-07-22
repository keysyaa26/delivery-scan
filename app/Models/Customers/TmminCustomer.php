<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class TmminCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliverytmmin';
    }

    protected function getLogChannel() : string
    {
        return 'tmmin_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_tmmin';
    }
}
