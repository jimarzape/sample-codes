<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table 	= 'tbl_category';
    public $timestamps 	= true;
    public $primaryKey 	= 'category_id';

    public function scopedetails($query, $category_archived = 0)
    {
    	return $query->where('category_archived', $category_archived)
    				 ->orderBy('category_name');
    }


}
