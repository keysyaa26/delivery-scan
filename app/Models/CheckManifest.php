<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckManifest extends Model
{
    protected $table = 'check_manifest';
    public $timestamps = true;

    protected $fillable = [
        'input_manifest',
        'status',
        'manifest_id',
        'manifest_type',
    ];

    protected $casts = [
        'status' => 'string',
        'manifest_id' => 'integer',
    ];

    // menggunakan relasi polimorfic
    public function manifest(){
        return $this->morphTo();
    }
}
