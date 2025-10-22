<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PROJECTTECH
 * 
 * @property int $ID
 * @property string|null $tech_icon_url
 * @property string $tech_name
 * @property string $tech_color
 * 
 * @property Collection|PROJECTTECHSTACK[] $p_r_o_j_e_c_t_t_e_c_h_s_t_a_c_k_s
 *
 * @package App\Models
 */
class PROJECTTECH extends Model
{
	protected $table = 'PROJECT_TECHS';
	protected $primaryKey = 'ID';
	public $timestamps = false;
	
	protected $hidden = ['pivot'];
	
	protected $fillable = [
		'tech_icon_url',
		'tech_name',
		'tech_color'
	];

	public function project_tech_stacks()
	{
		return $this->hasMany(PROJECTTECHSTACK::class, 'TECH_ID');
	}
}
