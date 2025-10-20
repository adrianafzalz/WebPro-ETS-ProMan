<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Auth wrapper model that maps Laravel auth to the existing `USER` table.
 * This file is safe to add and does not modify your existing generated `USER.php`.
 */
class User extends Authenticatable
{
    use Notifiable;

    // Use the existing table
    protected $table = 'USER';

    // Primary key column name
    protected $primaryKey = 'ID';

    // The existing table doesn't use auto-increment in current migration
    public $incrementing = false;

    // No timestamps on your USER table
    public $timestamps = false;

    protected $casts = [
        'ID' => 'int',
    ];

    // Hide password from JSON
    // protected $hidden = [
    //     'password',
    // ];

    // Allow mass assignment for fields we may need
    protected $fillable = [
		'ID',
        'user_name',
        'password',
        'user_desc',
        'user_bg_color',
        'user_fg_color',
        'user_accent_color',
    ];

    /**
     * Return the field to be used as the username for forms/helpers.
     */
    public static function usernameField(): string
    {
        return 'user_name';
    }
}
