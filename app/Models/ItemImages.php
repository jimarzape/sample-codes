<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemImages extends Model
{
    protected $table 	= 'tbl_item_image';
    public $timestamps 	= true;
    public $primaryKey 	= 'item_image_id';

    public function scopedetails($query, $item_id, $is_main = 0)
    {
    	return $query->where('item_id',$item_id)
    				 ->where('item_image_main', $is_main);
    }

    public function scopeapi($query, $date)
    {   
        return $query->whereDate('updated_at', '>=', $date);
    }
}
