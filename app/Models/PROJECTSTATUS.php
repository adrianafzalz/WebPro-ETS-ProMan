<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PROJECTSTATUS
 * 
 * @property int $ID
 * @property string|null $status_name
 * @property string|null $status_icon_url
 * 
 * @property Collection|PROJECT[] $p_r_o_j_e_c_t_s
 *
 * @package App\Models
 */
class PROJECTSTATUS extends Model
{
	protected $table = 'PROJECT_STATUS';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'status_name',
		'status_icon_url'
	];

	public function p_r_o_j_e_c_t_s()
	{
		return $this->hasMany(PROJECT::class, 'PROJECT_STATUS_ID');
	}
}
