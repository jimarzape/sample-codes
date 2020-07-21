<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogModel;

class LogsController extends MainController
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
            
    	$this->data['_pages'] = pages('Settings','Logs');
    }

    public function index()
    {
    	$this->data['_logs'] = LogModel::details()->paginate(20);
    	return view('setting.logs', $this->data);
    }
}
