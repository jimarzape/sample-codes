<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionLink extends Model
{
    protected $table 	= 'tbl_permission_link';
    public $timestamps 	= true;
    public $primaryKey 	= 'permission_id';

    public function permission()
    {
        return $this->belongsTo('App\Models\PermissionModel');
    }

    public function scopebypermission($query, $permission_id)
    {
    	return $query->where('permission_id', $permission_id);
    }

    public function scopebydesc($query, $link_desc)
    {
    	return $query->where('link_desc', $link_desc);
    }

    public function scopeuserlink($query, $user_id)
    {
        return $query->leftjoin('users','users.permission_id','tbl_permission_link.permission_id')
                     ->where('users.id', $user_id)
                     ->select('tbl_permission_link.*');
    }
}
