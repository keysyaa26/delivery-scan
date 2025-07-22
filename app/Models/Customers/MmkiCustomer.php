<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class MmkiCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliverynote';
    }

    public function getLogChannel(): string
    {
        return 'mmki_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_mmki';
    }
}
