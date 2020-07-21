<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    protected $table 	= 'tbl_ingredients';
    public $timestamps 	= true;
    public $primaryKey 	= 'ingredient_id';

    public function scopeapi($query, $date)
    {   
        return $query->whereDate('updated_at', '>=', $date);
    }
}
