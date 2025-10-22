<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


/**
 * Class USER
 * 
 * @property int $ID
 * @property string $user_name
 * @property string $password
 * @property string|null $user_desc
 * @property string|null $user_bg_color
 * @property string|null $user_fg_color
 * @property string|null $user_accent_color
 * 
 * @property Collection|COLLABORATOR[] $c_o_l_l_a_b_o_r_a_t_o_r_s
 * @property Collection|PROJECT[] $p_r_o_j_e_c_t_s
 *
 * @package App\Models
 */
class User extends Authenticatable 
{
	protected $table = 'USER';
	protected $primaryKey = 'ID';

	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'user_name',
		'password',
		'user_desc',
		'user_bg_color',
		'user_fg_color',
		'user_accent_color'
	];

	public function c_o_l_l_a_b_o_r_a_t_o_r_s()
	{
		return $this->hasMany(COLLABORATOR::class, 'USER_ID');
	}

	public function p_r_o_j_e_c_t_s()
	{
		return $this->hasMany(PROJECT::class, 'USER_ID_PM');
	}
}
