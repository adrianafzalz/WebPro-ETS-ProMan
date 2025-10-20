<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PROJECTTECHSTACK
 * 
 * @property int $ID
 * @property int|null $TECH_ID
 * @property int|null $PROJECTS_ID
 * 
 * @property PROJECTTECH|null $p_r_o_j_e_c_t_t_e_c_h
 * @property PROJECT|null $p_r_o_j_e_c_t
 *
 * @package App\Models
 */
class PROJECTTECHSTACK extends Model
{
	protected $table = 'PROJECT_TECH_STACK';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'TECH_ID' => 'int',
		'PROJECTS_ID' => 'int'
	];

	protected $fillable = [
		'TECH_ID',
		'PROJECTS_ID'
	];

	public function p_r_o_j_e_c_t_t_e_c_h()
	{
		return $this->belongsTo(PROJECTTECH::class, 'TECH_ID');
	}

	public function p_r_o_j_e_c_t()
	{
		return $this->belongsTo(PROJECT::class, 'PROJECTS_ID');
	}
}
