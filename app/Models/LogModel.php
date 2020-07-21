<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table 	= 'tbl_logs';
    public $timestamps 	= true;
    public $primaryKey 	= 'logs_id';

    public function scopedetails($query)
    {
    	return $query->leftjoin('users','tbl_logs.user_id','users.id')
    				 ->select('users.name','tbl_logs.*')
    				 ->orderBy('tbl_logs.created_at','desc');
    }
}
