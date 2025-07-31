<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblKbndelivery
 *
 * @property int $no
 * @property string $kbndn_no
 * @property string $dn_no
 * @property string $job_no
 * @property string $seq_no
 * @property string $kbicode
 * @property Carbon $datetime_input
 * @property int|null $user
 * @property string $invid
 *
 * @property TblUser|null $tbl_user
 *
 * @package App\Models
 */
class TblKbndelivery extends Model
{
	protected $table = 'tbl_kbndelivery';
	protected $primaryKey = 'no';
	public $timestamps = false;

	protected $casts = [
		'datetime_input' => 'datetime',
		'user' => 'int'
	];

	protected $fillable = [
		'kbndn_no',
		'dn_no',
		'job_no',
		'seq_no',
		'kbicode',
		'datetime_input',
		'user',
		'invid',
        'check_leader',
        'checked_by',
        'checked_at'
	];

	public function tbl_user()
	{
		return $this->belongsTo(TblUser::class, 'user');
	}

    public function checker()
    {
        return $this->belongsTo(TblUser::class, 'checked_by');
    }
}
