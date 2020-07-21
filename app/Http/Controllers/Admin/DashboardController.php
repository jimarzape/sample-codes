<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use DB;
use Auth;

class DashboardController extends MainController
{
    public function __construct()
    {
        
      parent::__construct();
      /* 
          $this->data['_pages'] is for initializing side navigation menu with custom user level function that can be set by the user base on his preferences.
          - please see root_folder/app/Helpers/page.php for code reference
          - second param for pages() can be blank or null
          - extended MainContoller handle all the permssion function base on the user level.
      */
          
      $this->data['_pages'] = pages('Dashboard');
    }

    public function index()
    {
    	$this->data['_category'] = CategoryModel::leftjoin('tbl_item','tbl_item.category_id','tbl_category.category_id')
                                               ->select('tbl_category.*',DB::raw('count(tbl_item.item_id) as total_item'))
                                               ->where('category_archived', 0)
                                               ->groupBy('tbl_category.category_id')
                                               ->get();
    	return view('dashboard.index', $this->data);
    }
}
