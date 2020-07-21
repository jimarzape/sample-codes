<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table 	= 'users';
    public $timestamps 	= true;
    public $primaryKey 	= 'id';

    public function scopedetails($query, $user_active = 1)
    {
    	return $query->where('user_active', $user_active)
                     ->leftjoin('tbl_permissions', 'tbl_permissions.permission_id', 'users.permission_id')
    				 ->orderBy('users.created_at', 'DESC');
    }

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
