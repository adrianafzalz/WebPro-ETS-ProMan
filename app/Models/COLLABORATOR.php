<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class COLLABORATOR
 * 
 * @property int $ID
 * @property int $USER_ID
 * @property int $PROJECTS_ID
 * @property string|null $role
 * 
 * @property USER $u_s_e_r
 * @property PROJECT $p_r_o_j_e_c_t
 *
 * @package App\Models
 */
class COLLABORATOR extends Model
{
	protected $table = 'COLLABORATORS';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'USER_ID' => 'int',
		'PROJECTS_ID' => 'int'
	];

	protected $fillable = [
		'USER_ID',
		'PROJECTS_ID',
		'role'
	];

	public function u_s_e_r()
	{
		return $this->belongsTo(USER::class, 'USER_ID');
	}

	public function p_r_o_j_e_c_t()
	{
		return $this->belongsTo(PROJECT::class, 'PROJECTS_ID');
	}
}
