<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MILESTONE
 * 
 * @property int $ID
 * @property string|null $milestone_title
 *
 * @package App\Models
 */
class MILESTONE extends Model
{
	protected $table = 'MILESTONES';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'milestone_title'
	];
}
