<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends MainController
{
    public function upload_picture(Request $request)
    {
        $upload_path = '/upload/images';

        if($request->folder){ $upload_path = $request->folder; }

        $image = $request->file('image');
        $name = str_randoms(5).time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path($upload_path);
        $image->move($destinationPath, $name);
        
        return $upload_path.'/'.$name;
    }

    public function remove_img()
    {

    }

    public function upload_video(Request $request)
    {
        $upload_path = '/upload/videos';

        if($request->folder){ $upload_path = $request->folder; }

        $image = $request->file('video');
        $name = str_randoms(5).time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path($upload_path);
        $image->move($destinationPath, $name);
        
        return $upload_path.'/'.$name;
    }
}
