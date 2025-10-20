<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PROJECT
 * 
 * @property int $ID
 * @property int $USER_ID_PM
 * @property int $PROJECT_STATUS_ID
 * @property string $project_name
 * @property string|null $project_desc
 * @property Carbon|null $project_start
 * @property Carbon|null $project_date
 * @property string|null $project_links
 * 
 * @property USER $u_s_e_r
 * @property PROJECTSTATUS $p_r_o_j_e_c_t_s_t_a_t_u_s
 * @property Collection|COLLABORATOR[] $c_o_l_l_a_b_o_r_a_t_o_r_s
 * @property Collection|PROJECTTECHSTACK[] $p_r_o_j_e_c_t_t_e_c_h_s_t_a_c_k_s
 *
 * @package App\Models
 */
class PROJECT extends Model
{
	protected $table = 'PROJECTS';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int',
		'USER_ID_PM' => 'int',
		'PROJECT_STATUS_ID' => 'int',
		'project_start' => 'datetime',
		'project_date' => 'datetime'
	];

	protected $fillable = [
		'USER_ID_PM',
		'PROJECT_STATUS_ID',
		'project_name',
		'project_desc',
		'project_start',
		'project_date',
		'project_links'
	];

	public function u_s_e_r()
	{
		return $this->belongsTo(USER::class, 'USER_ID_PM');
	}

	public function p_r_o_j_e_c_t_s_t_a_t_u_s()
	{
		return $this->belongsTo(PROJECTSTATUS::class, 'PROJECT_STATUS_ID');
	}

	public function c_o_l_l_a_b_o_r_a_t_o_r_s()
	{
		return $this->hasMany(COLLABORATOR::class, 'PROJECTS_ID');
	}

	public function p_r_o_j_e_c_t_t_e_c_h_s_t_a_c_k_s()
	{
		return $this->hasMany(PROJECTTECHSTACK::class, 'PROJECTS_ID');
	}
}
