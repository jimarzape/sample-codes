<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CategoryModel;
use App\Models\ItemModel;
use App\Models\LogModel;
use App\Events\NotifEvent;
use Auth;

class CategoryController extends MainController
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

        $this->data['_pages'] = pages('Menu','Categories');
    }

    public function index()
    {
        $this->data['_category'] = CategoryModel::details()->paginate(20);
        return view('menu.category', $this->data);
    }

    public function _new()
    {
        return view('menu.category_new');
    }

    public function _save(Request $request)
    {
        $category = new CategoryModel();
        $category->category_name = $request->category_name;
        $category->save();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Category';
        $logs->logs_description = 'Created a new category : '._strong($request->category_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $request->category_name;
        $data['id']   = $category->category_id;
        event(New NotifEvent($data, 'category-new'));
    }

    public function view(Request $request)
    {
        $data['category'] = CategoryModel::where('category_id',$request->id)->first();
        return view('menu.category_view', $data);
    }

    public function update(Request $request)
    {
        $category                   = new CategoryModel();
        $category->exists           = true;
        $category->category_id      = $request->category_id;
        $category->category_name    = $request->category_name;
        $category->save();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Category';
        $logs->logs_description = 'Updated category : '._strong($request->category_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $request->category_name;
        $data['id']   = $category->category_id;
        event(New NotifEvent($data, 'category-update'));
    }

    public function archived(Request $request)
    {
        $category                       = new CategoryModel();
        $category->exists               = true;
        $category->category_id          = $request->id;
        $category->category_archived    = 1;
        $category->save();

        $_category              = CategoryModel::where('category_id', $request->id)->first();
        
        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Category';
        $logs->logs_description = 'Deleted category : '._strong($_category->category_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */
        $data['name'] = $_category->category_name;
        $data['id']   = $_category->category_id;
        event(New NotifEvent($data, 'category-delete'));
    }

}

