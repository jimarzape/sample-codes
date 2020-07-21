
<?php

/*
    this is where you should set all your dynamic nav
*/
function _pages()
{
	$pages = array();

    $details['title']   = 'Dashboard'; 
    $details['icon']    = 'ti-dashboard';
    $details['url']     = route('dashboard');
    $details['status']  = '';
    $details['desc']    = 'nav.dash';
    $details['class']   = 'pcoded-trigger';
    $details['has_sub'] = false;
    $details['sub']     = array();
    
    array_push($pages, $details);

    
    $details['title']   = 'Menu'; 
    $details['icon']    = 'ti-menu';
    $details['url']     = 'javascript:void(0)';
    $details['status']  = '';
    $details['desc']    = 'nav.menu';
    $details['class']   = 'pcoded-hasmenu';
    $details['has_sub'] = true;
    $details['sub']     = array();


    $sub['title']       = 'Items';
    $sub['icon']        = 'ti-list';
    $sub['url']         = route('items');
    $sub['status']      = '';
    $sub['desc']        = 'nav.menu.item';
    
    array_push($details['sub'], $sub);

    $sub['title']       = 'Categories';
    $sub['icon']        = 'ti-list';
    $sub['url']         = route('category');
    $sub['status']      = '';
    $sub['desc']        = 'nav.menu.categories';
    
    array_push($details['sub'], $sub);

    array_push($pages, $details);

  

    $details['title']   = 'Settings'; 
    $details['icon']    = 'ti-settings';
    $details['url']     = 'javascript:void(0)';
    $details['status']  = '';
    $details['desc']    = 'nav.setting';
    $details['class']   = 'pcoded-hasmenu';
    $details['has_sub'] = true;
    $details['sub']     = array();

    $sub['title']       = 'Users';
    $sub['icon']        = 'ti-camera';
    $sub['url']         = route('user');
    $sub['status']      = '';
    $sub['desc']        = 'nav.user_settings.user';
    
    array_push($details['sub'], $sub);


    $sub['title']       = 'Permissions';
    $sub['icon']        = 'ti-camera';
    $sub['url']         = route('permission');
    $sub['status']      = '';
    $sub['desc']        = 'nav.user_settings.permission';
    
    array_push($details['sub'], $sub);

    $sub['title']       = 'Logs';
    $sub['icon']        = 'ti-camera';
    $sub['url']         = route('logs');
    $sub['status']      = '';
    $sub['desc']        = 'nav.settings.logs';
    
    array_push($details['sub'], $sub);

    

    array_push($pages, $details);


    return $pages;

}

/*
    @params
    $title and $submenu
        - $submenu can be blank
*/
function pages($title = 'Dashboard', $sub_menu = '')
{
    $pages = _pages();
    
    $_pages['pages']    = array();
    $_pages['active']   = array();
    $_pages['active_title'] = '';
    foreach($pages as $page)
    {
        if($page['title'] == $title)
        {
            $page['status']         = 'active';
            $_pages['active_title'] = $page['title'];
            $active['active_title'] = $page['title'];
            $active['active_url']   = $page['url'];
            
            array_push($_pages['active'], $active);
            
            $temp_sub               = array();
            foreach($page['sub'] as $subs)
            {
                if($subs['title'] == $sub_menu)
                {
                    $subs['status']         = 'active';
                    $_pages['active_title'] = $subs['title'];
                    $active['active_title'] = $subs['title'];
                    $active['active_url']   = 'javascript:void(0)';
            
                    array_push($_pages['active'], $active);
                }
                
                array_push($temp_sub, $subs);
            }
            
            $page['sub'] = $temp_sub;
        }
        array_push($_pages['pages'], $page);
    }
    
    return $_pages;
}

/*
    checking each page if it's accessible by the user base on his user permission level
*/
function page_access($pages, $access)
{
    foreach($pages as $key => $page)
    {
        $pages[$key]['enable'] = false; 
        if(isset($access[$page['desc']]))
        {
            $pages[$key]['enable'] = true;
        }

        foreach($page['sub'] as $sub_key => $sub)
        {
            $pages[$key]['sub'][$sub_key]['enable'] = false;

            if(isset($access[$sub['desc']]))
            {
                $pages[$key]['sub'][$sub_key]['enable'] = true;
                $pages[$key]['enable'] = true;
            }
        }
    }

    return $pages;
}