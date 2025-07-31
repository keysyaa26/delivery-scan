<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckSuratJalan extends Model
{
    protected $table = 'tbl_check_sj';
    protected $fillable = [
        'dn_no',
        'table_name',
        'check_sj',
        'checked_by',
        'created_at',
        'updated_at'];

    public function scopeCheckByDN($query, $dn)
    {
        return $query->where('dn_no', $dn);
    }

    public function scopeCheckByTableName($query, $tableName)
    {
        return $query->where('table_name', $tableName);
    }

    public function checker()
    {
        return $this->belongsTo(TblUser::class, 'checked_by');
    }
}
