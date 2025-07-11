<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblDeliveryhpm
 *
 * @property string $dn_no
 * @property string $job_no
 * @property string $customerpart_no
 * @property int $qty_pcs
 * @property string|null $tanggal_order
 * @property string $plan
 * @property string $status
 * @property string|null $ETA
 * @property string $cycle
 * @property int|null $user
 * @property string|null $count_process
 * @property Carbon|null $datetime_input
 * @property int $id
 *
 * @package App\Models
 */
class TblDeliveryhpm extends Model
{
	protected $table = 'tbl_deliveryhpm';
	public $timestamps = false;

	protected $casts = [
		'qty_pcs' => 'int',
		'user' => 'int',
		'datetime_input' => 'datetime'
	];

	protected $fillable = [
		'dn_no',
		'job_no',
		'customerpart_no',
		'qty_pcs',
		'tanggal_order',
		'plan',
		'status',
		'ETA',
		'cycle',
		'user',
		'count_process',
		'datetime_input'
	];

    public function checkManifest(){
        return $this->morphMany(CheckManifest::class, 'manifest');
    }
}
