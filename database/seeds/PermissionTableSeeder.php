<?php

use Illuminate\Database\Seeder;

use App\Models\PermissionModel;
use App\Models\PermissionLink;

use App\User;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = PermissionModel::count();
        $now = Carbon::now();

        if($count == 0)
        {

        	$PermissionModel = new PermissionModel;
        	$PermissionModel->permission_name = 'Super Admin';
        	$PermissionModel->save();


        	$_pages             = _pages();
        	$links 				= [];

	        foreach($_pages as $pages)
	        {

	        	$temp['permission_id'] = $PermissionModel->permission_id;
	        	$temp['link_desc'] = $pages['desc'];
	        	$temp['created_at'] = $now;
	        	$temp['updated_at'] = $now;

	            array_push($links, $temp);

	            foreach($pages['sub'] as $sub)
	            {
	                $temp['permission_id'] = $PermissionModel->permission_id;
		        	$temp['link_desc'] = $sub['desc'];
		        	$temp['created_at'] = $now;
		        	$temp['updated_at'] = $now;

	                array_push($links, $temp);
	            }
	        }

	        PermissionLink::insert($links);

        }


        // check if first user has permission
        
        $first_user = User::first();

        if($first_user->permission_id == null)
        {
        	$permission = PermissionModel::first();

        	$first_user->permission_id = $permission->permission_id;
        	$first_user->save();

        } 

        
    }
}
