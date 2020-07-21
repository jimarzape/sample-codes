<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table 	= 'tbl_item';
    public $timestamps 	= true;
    public $primaryKey 	= 'item_id';

    public function scopedetails($query, $isbundle = 0, $item_archived = 0)
    {
    	 $query->leftjoin('tbl_category','tbl_category.category_id','tbl_item.category_id')
    				 ->leftjoin('tbl_item_image','tbl_item_image.item_id','tbl_item.item_id')
    				 ->where('tbl_item.item_archived', $item_archived)
    				 ->where('tbl_item_image.item_image_main',1)
                     ->orderBy('item_name');


        return $query;
    }

    public function scopeapi($query, $date)
    {   
        return $query->whereDate('updated_at', '>=', $date);
    }

    public function scopesearch($query, $search)
    {
        return $query->leftjoin('tbl_menusearch','tbl_menusearch.item_id','tbl_item.item_id')
                   ->whereRaw("MATCH(tbl_menusearch.menu_body)AGAINST('+".$search."*' IN BOOLEAN MODE)"); 
    }

    public function scopesingle($query, $item_id)
    {
        return  $query->leftjoin('tbl_category','tbl_category.category_id','tbl_item.category_id')
                        ->leftjoin('tbl_item_image','tbl_item_image.item_id','tbl_item.item_id')
                        ->where('tbl_item.item_id', $item_id);
    }
}
