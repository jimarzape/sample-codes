<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorModel extends Model
{
    protected $table 	= 'tbl_error_logs';
    public $timestamps 	= true;
    public $primaryKey 	= 'error_logs_id';
}