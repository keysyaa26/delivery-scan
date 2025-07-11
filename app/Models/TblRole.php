<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TblUser;

/**
 * Class TblRole
 *
 * @property int $id_role
 * @property string $departemen
 *
 * @package App\Models
 */
class TblRole extends Model
{
	protected $table = 'tbl_role';
	protected $primaryKey = 'id_role';
	public $timestamps = false;

	protected $fillable = [
		'departemen'
	];

	public function User()
	{
		return $this->hasMany(TblUser::class, 'id_role');
	}
}
