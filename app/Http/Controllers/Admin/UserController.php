<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

use App\Models\PermissionModel;
use App\Models\PermissionLink;
use App\Models\LogModel;

use Auth;

class UserController extends MainController
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

    	$this->data['_pages'] = pages('Settings','Users');
    }

    public function index()
    {
        $this->data['_user'] = User::details()->paginate(20);
        $role[0] = '';
        $role[1] = 'Waiter';
        $role[2] = 'Manager';
        $role[3] = 'Others';
        $this->data['role'] = $role;
    	return view('setting.user', $this->data);
    }

    public function _new()
    {
        $data['permissions'] = PermissionModel::details()->get();
        return view('setting.user_new', $data); 
    }

    public function _save(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user                   = new User();
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = bcrypt($request->password);
        $user->permission_id    = $request->permission_id;
        $user->save();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'User';
        $logs->logs_description = 'Created a new user : '._strong($request->name);
        $logs->save();
    }

    public function view(Request $request)
    {
        $data['user'] = User::where('id',$request->id)->first();
        $data['permissions'] = PermissionModel::details()->get();

        return view('setting.user_view', $data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:6',
            'email' => 'required|unique:users,email,' . $request->user_id
        ]);

        $user                   = new User();
        $user->exists           = true;
        $user->id               = $request->user_id;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->permission_id    = $request->permission_id;
        $user->permission_id    = $request->permission_id;
        if($request->password != '')
        {
            $user->password     = bcrypt($request->password);
        }

        $user->save();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'User';
        $logs->logs_description = 'Updated user : '._strong($request->name);
        $logs->save();
    }

    public function inactive(Request $request)
    {
        $user                   = new User();
        $user->exists           = true;
        $user->id               = $request->id;
        $user->user_active      = 0;
        $user->save();

        $_user = User::where('id', $request->id)->first();

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'User';
        $logs->logs_description = 'Deactivate user : '._strong($_user->name);
        $logs->save();
    }

   

    public function password_authenticate(Request $request)
    {
        $auth = Auth()->user()->password;
        $data['message']  = 'User not authorized';
        $data['status']   = 'error';
        if(Hash::check($request->password, $auth)) {
            $data['message']  = 'User authenticated';
            $data['status']   = 'success';
        }

        return response()->json($data);
    }
}
