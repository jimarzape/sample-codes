<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CategoryModel;
use App\Models\ItemModel;
use App\Models\ItemImages;
use App\Models\ItemTags;
use App\Models\LogModel;
use App\Models\Ingredients;
use App\Models\MenuSearch;
use App\Events\NotifEvent;
use DB;
use Auth;

class ItemController extends MainController
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
            
        $this->data['_pages'] = pages('Menu','Items');
    }

    public function index(Request $request)
    {
        $this->data['_item'] = ItemModel::details()->paginate(20);
        if($request->has('search'))
        {
            if($request->search != '')
            {
                $this->data['_item'] = ItemModel::details()->search($request->search)->paginate(20);
            }
        }
        
        return view('menu.item', $this->data);
    }

    public function _new()
    {
        $data['_category']  = CategoryModel::details()->get();
        return view('menu.item_new', $data);
    }

    public function save(Request $request)
    {
        $item_id                = 0;
        $item = new ItemModel;
        $item->category_id      = $request->category;
        $item->item_name        = $request->item_name;
        $item->item_description = $request->description;
        $item->item_price       = $request->item_price;
        $item->save();
        $item_id = $item->item_id;

        $ex_tag = explode(',', $request->tags);

        Self::ingredients($item_id, $ex_tag);

        $main                   = new ItemImages;
        $main->item_id          = $item_id;
        $main->item_image       = $request->main_img;
        $main->item_image_main  = 1;
        $main->save();

        if($request->has('sub_img'))
        {
            $insert_subs = [];
            foreach($request->sub_img as $key => $sub)
            {
                $int_sub['item_id']         = $item_id;
                $int_sub['item_image']      = $sub;
                $int_sub['item_image_main'] = 0;
                $int_sub['created_at']      = date('Y-m-d H:i:s');
                $int_sub['updated_at']      = date('Y-m-d H:i:s');
                $insert_subs[]              = $int_sub;
            }

            ItemImages::insert($insert_subs);
        }

        Self::update_search($item_id);

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Item';
        $logs->logs_description = 'Created a new item : '._strong($request->item_name);
        $logs->save();

        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $request->item_name;
        $data['id']   = $item_id;
        event(New NotifEvent($data, 'item-new'));
    }

    public function ingredients($item_id, $ex_tag = array())
    {
        $insert_tags = [];
        foreach($ex_tag as $key => $tags)
        {
            $ingredient_id          = 0;
            $ing_ex                 =   Ingredients::where('ingredient_name', $tags)->exists();
            if($ing_ex)
            {
                $ing            = Ingredients::where('ingredient_name', $tags)->first();
                $ingredient_id  = $ing->ingredient_id;
            }
            else
            {
                $ing                    = new Ingredients;
                $ing->ingredient_name   = $tags;
                $ing->save();
                $ingredient_id = $ing->ingredient_id;

                $logs                   = new LogModel;
                $logs->user_id          = Auth::user()->id;
                $logs->logs_type        = 'Ingredients';
                $logs->logs_description = 'Created a new ingredients : '._strong($tags);
                $logs->save();
            }
            $inrt_tag['item_id']        = $item_id;
            $inrt_tag['ingredient_id']  = $ingredient_id;
            $inrt_tag['created_at']     = date('Y-m-d H:i:s');
            $inrt_tag['updated_at']     = date('Y-m-d H:i:s');
            $insert_tags[]              = $inrt_tag;
        }

        ItemTags::insert($insert_tags);
    }

    public function active_toggle(Request $request)
    {
        $item           = new ItemModel;
        $item->exists   = true;
        $item->item_id  = $request->id;
        $item->item_active = $request->status;
        $item->save();

        $_item = ItemModel::where('item_id', $request->id)->first();

        $type   = $_item->is_bundle == 1 ? 'Bundle' : 'Item';
        $status = $request->status == 1 ? 'Actived' : 'Deactivated';
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = $type;
        $logs->logs_description = $status.' '.strtolower($type).' : '._strong($_item->item_name);
        $logs->save();
    }

    public function archived(Request $request)
    {
        $id                     = $request->id;
        $item                   = new ItemModel;
        $item->exists           = true;
        $item->item_id          = $id;
        $item->item_archived    = 1;
        $item->save();

        /* audit trail */
        $_item                  = ItemModel::where('item_id', $request->id)->first();
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = $type;
        $logs->logs_description = 'Deleted item : '._strong($_item->item_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $_item->item_name;
        $data['id']   = $id;
        event(New NotifEvent($data, 'item-delete'));
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $data['item']       = ItemModel::details()->where('tbl_item.item_id', $id)->first();
        $data['tags']       = ItemTags::details($id)->select(\DB::raw('group_concat(ingredient_name) as tags'))->first();
        $data['_category']  = CategoryModel::details()->get();
        $data['_img']       = ItemImages::details($id)->get();
        
        return view('menu.item_edit', $data);
    }

    public function update(Request $request)
    {
        $item_id                = $request->item_id;
        $item                   = new ItemModel;
        $item->exists           = true;
        $item->item_id          = $item_id;
        $item->category_id      = $request->category;
        $item->item_name        = $request->item_name;
        $item->item_description = $request->description;
        $item->item_price       = $request->item_price;
        $item->save();
        ItemImages::where('item_id', $item_id)->delete();
        ItemTags::where('item_id', $item_id)->delete();
        
        $ex_tag = explode(',', $request->tags);
       
        Self::ingredients($item_id, $ex_tag);

        $main                   = new ItemImages;
        $main->item_id          = $item_id;
        $main->item_image       = $request->main_img;
        $main->item_image_main  = 1;
        $main->save();

        if($request->has('sub_img'))
        {
            $insert_subs = [];
            foreach($request->sub_img as $key => $sub)
            {
                $int_sub['item_id']         = $item_id;
                $int_sub['item_image']      = $sub;
                $int_sub['item_image_main'] = 0;
                $int_sub['created_at']      = date('Y-m-d H:i:s');
                $int_sub['updated_at']      = date('Y-m-d H:i:s');
                $insert_subs[]              = $int_sub;
            }

            
            ItemImages::insert($insert_subs);
        }

        
        Self::update_search($item_id);

        /* audit trail */
        $logs                   = new LogModel;
        $logs->user_id          = Auth::user()->id;
        $logs->logs_type        = 'Item';
        $logs->logs_description = 'Updated item : '._strong($request->item_name);
        $logs->save();


        /*
            - Notif event allows to subscribe and emit signal to our socket.io
            - I mostly used this on real time notification [like from my previous project - ORDERING SYSTEM with ios app connected through REST API]
            - It can be use for real time chat
            - please see root_folder/socket/socket.js for code reference
            - please see also root_folder/public/js/global.js for code reference
            - also please make sure you run npm install on root_folder/socket - nodejs and redis are required
        */

        $data['name'] = $request->item_name;
        $data['id']   = $item_id;
        event(New NotifEvent($data, 'item-update'));
    }


    public function all_item()
    {   
        $_items = ItemModel::get();
        foreach($_items as $item)
        {
            Self::update_search($item->item_id);
        }   
    }

    public function update_search($item_id)
    {

        /*  
            - I'm using fulltext indexing for search instead of using like
            - using fulltext index is faster than "like" expression
        */
        $tags   = ItemTags::details($item_id)->select(DB::raw('group_concat(ingredient_name SEPARATOR " ") as ingredient_tags'))->first();
       
        $item = ItemModel::where('item_id', $item_id)->first();
        MenuSearch::where('item_id', $item_id)->delete();
        $text = $item->item_name.' '.$tags->ingredient_tags;
        $search = new MenuSearch;
        $search->item_id = $item_id;
        $search->menu_body = $text;
        $search->save();
 
    }
}