<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTags extends Model
{
	protected $table 	= 'tbl_item_tags';
    public $timestamps 	= true;
    public $primaryKey 	= 'item_tags_id';


    public function scopedetails($query, $item_id)
    {
    	return $query->where('item_id', $item_id)
                     ->leftjoin('tbl_ingredients','tbl_ingredients.ingredient_id','tbl_item_tags.ingredient_id');
    }

    public function scopeapi($query, $date)
    {   
        return $query->whereDate('updated_at', '>=', $date);
    }
}
