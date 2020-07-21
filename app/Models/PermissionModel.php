<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $table 	= 'tbl_permissions';
    public $timestamps 	= true;
    public $primaryKey 	= 'permission_id';


     public function PermissionLinks()
	 {
	    return $this->hasMany('App\Models\PermissionLink', 'permission_id', 'permission_id');
	 }

	public function getPermissionLinksAttribute()
	{
	    return $this->getRelationValue('PermissionLinks')->keyBy('link_desc');
	}

	public function scopedetails($query, $archived = 0)
    {
    	return $query->where('permission_archived',$archived)
    				 ->orderBy('permission_name');
    }

    public function scopespecify($query, $permission_id)
    {
    	return $query->where('permission_id', $permission_id);
    }
}
