<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterpartAdm
 * 
 * @property string $InvId
 * @property string $PartName
 * @property string $PartNo
 * @property string $JobNo
 * @property int $QtyPerKbn
 * @property string|null $ModelNo
 * @property string|null $Tanggal_Order
 * @property Carbon|null $Tanggal_input
 * @property int|null $user
 * @property int $id
 *
 * @package App\Models
 */
class MasterpartAdm extends Model
{
	protected $table = 'masterpart_adm';
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
}
