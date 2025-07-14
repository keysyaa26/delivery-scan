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
}
