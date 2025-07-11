<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterpartHino
 * 
 * @property string $InvId
 * @property string $PartName
 * @property string $PartNo
 * @property string $JobNo
 * @property int $QtyPerKbn
 * @property string $ModelNo
 * @property string|null $Tanggal_Order
 * @property Carbon|null $Tanggal_input
 * @property int|null $user
 * @property int $id
 * 
 * @property TblUser|null $tbl_user
 *
 * @package App\Models
 */
class MasterpartHino extends Model
{
	protected $table = 'masterpart_hino';
	public $timestamps = false;

	protected $casts = [
		'QtyPerKbn' => 'int',
		'Tanggal_input' => 'datetime',
		'user' => 'int'
	];

	protected $fillable = [
		'InvId',
		'PartName',
		'PartNo',
		'JobNo',
		'QtyPerKbn',
		'ModelNo',
		'Tanggal_Order',
		'Tanggal_input',
		'user'
	];

	public function tbl_user()
	{
		return $this->belongsTo(TblUser::class, 'user');
	}
}
