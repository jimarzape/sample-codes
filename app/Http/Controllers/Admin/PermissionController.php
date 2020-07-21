<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use Carbon\Carbon;

use App\Models\PermissionModel;
use App\Models\PermissionLink;
use App\Models\LogModel;
use App\Events\NotifEvent;

class PermissionController extends MainController
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
        
    	$this->data['_pages'] = pages('Settings','Permissions');
    }

    public function index()
    {
        $this->data['Permission'] = PermissionModel::details()->with('PermissionLinks')->paginate(20);
    	return view('setting.permission', $this->data);
    }

    public function _new()
    {
        $datapage['_pages'] = _pages();
        $data['json']       =  array();
        $_pages             = _pages();

        foreach($_pages as $pages)
        {
            $temp['id']         = $pages['desc'];
            $temp['parent']     = '#';
            $temp['text']       = $pages['title'];
            $temp['icon']       = 'ti-folder';
            $temp['selected']   = false;

            array_push($data['json'], $temp);
            foreach($pages['sub'] as $sub)
            {
                $temp['id']         = $sub['desc'];
                $temp['parent']     = $pages['desc'];
                $temp['text']       = $sub['title'];
                $temp['icon']       = 'ti-folder';
                $temp['selected']   = false;
                array_push($data['json'], $temp);
            }
        }

        $data['html'] =  view('setting.permission_new', $datapage)->render();
        return $data;
    }

    public function _save(Request $request)
    {   
        $Permission = new PermissionModel;
        $Permission->permission_name = $request->userlevel;
        $Permission->save();

        Self::insertdesc($Permission->permission_id, $request->permission);

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Permission';
        $logs->logs_description = 'Created a new permission : '._strong($request->userlevel);
        $logs->save();

        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */


        $data['name'] = $request->userlevel;
        $data['id']   = $Permission->permission_id;
        event(New NotifEvent($data, 'permission-new'));
    }

    public function view(Request $request)
    {
        $id                     = $request->id;
        $datapage['permission'] = PermissionModel::specify($id)->with('PermissionLinks')->first();
        $datapage['_pages']     = _pages();
        $data['json']           =  array();
        $_pages                 = _pages();

        $permission_links = $datapage['permission']->PermissionLinks->toArray();

        foreach($_pages as $pages)
        {

            $a = array_search($pages['desc'], $permission_links);

            $temp['id']         = $pages['desc'];
            $temp['parent']     = '#';
            $temp['text']       = $pages['title'];
            $temp['icon']       = 'ti-folder';
            $temp['selected']   = false;
            if(isset($permission_links[$pages['desc']])){ $temp['selected']   = true; }

            array_push($data['json'], $temp);
            foreach($pages['sub'] as $sub)
            {
                $temp['id']         = $sub['desc'];
                $temp['parent']     = $pages['desc'];
                $temp['text']       = $sub['title'];
                $temp['icon']       = 'ti-folder';
                $temp['selected']   = false;
                $check              = PermissionLink::bypermission($id)->bydesc($pages['desc'])->first();

                if(isset($permission_links[$sub['desc']])){ $temp['selected']   = true; }

                array_push($data['json'], $temp);
            }
        }
        
        $data['html'] =  view('setting.permission_view', $datapage)->render();
        return $data;
    }

    public function update(Request $request)
    {   
        $_permission                = $request->permission;
        $id                         = $request->id;

        $Permission = new PermissionModel;
        $Permission->exists = true;
        $Permission->permission_id = $id;
        $Permission->permission_name = $request->userlevel;
        $Permission->save();

        Self::insertdesc($id, $_permission);

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Permission';
        $logs->logs_description = 'Updated permission : '._strong($request->userlevel);
        $logs->save();

        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $request->userlevel;
        $data['id']   = $Permission->permission_id;
        event(New NotifEvent($data, 'permission-update'));
    }

    public function insertdesc($id, $_permission)
    {
        $link = array();
        $now = Carbon::now();
        PermissionLink::where('permission_id', $id)->delete();
        foreach($_permission as $permission)
        {
            $temp['permission_id']  = $id;
            $temp['link_desc']      = $permission;
            $temp['created_at']     = $now;
            $temp['updated_at']     = $now;

            $link[] = $temp;
        }
        PermissionLink::insert($link);
    }

    public function archived(Request $request)
    {
        $id                             = $request->id;
        $Permission                     = new PermissionModel;
        $Permission->exists             = true;
        $Permission->permission_id      = $id;
        $Permission->permission_archived = 1;
        $Permission->save();

        $_permission            = PermissionModel::where('permission_id', $id)->first();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Permission';
        $logs->logs_description = 'Deleted permission : '._strong($_permission->permission_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */


        $data['name'] = $_permission->permission_name;
        $data['id']   = $id;
        event(New NotifEvent($data, 'permission-delete'));
    }
}
