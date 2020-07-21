<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\PermissionModel;

class MainController extends Controller
{
	public $permission_links   = [];
	public $permission         = [];
	public $u                  = 1;
    public $data               = [];

    public function __construct()
    {
    	$this->middleware('auth');
    	view()->share('permission',  $this->permission);
    	view()->share('permission_links',  $this->permission_links);
    	
    	$this->middleware(function ($request, $next) {
            $this->u = Auth::user();

            if(isset( Auth::User()->id ))
            {
                $this->permission = PermissionModel::where('permission_id', Auth::User()->permission_id)->with('PermissionLinks')->first();

                view()->share('permission',  $this->permission);

                if(isset($this->permission->PermissionLinks))
                {
                    $this->permission_links = $this->permission->PermissionLinks;

                    view()->share('permission_links',  $this->permission_links);
                }
            }

            return $next($request);
        });
    }
}
