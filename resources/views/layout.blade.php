<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>Ordering System</title>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="#">
    <meta name="keywords" content="flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="#">
    @yield('meta')
    <!-- Favicon icon -->
    <link rel="icon" href="/media/icon.png" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Mada:300,400,500,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="/assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="/assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/flag-icon/flag-icon.min.css">
    <!--SVG Icons Animated-->
    <link rel="stylesheet" type="text/css" href="/assets/icon/SVG-animated/svg-weather.css">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/menu-search/css/component.css">
    <!-- Horizontal-Timeline css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/dashboard/horizontal-timeline/css/style.css">
    <!-- amchart css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/dashboard/amchart/css/amchart.css">
    <!-- Calender css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/widget/calender/pignose.calendar.min.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="/assets/pages/flag-icon/flag-icon.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css?v=1.0.3">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="/bower_components/animate.css/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/pnotify/css/pnotify.history.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/pnotify/css/pnotify.mobile.css">
    <!-- <link rel="stylesheet" type="text/css" href="/theme/pages/pnotify/notify.css"> -->
    <link rel="stylesheet" type="text/css" href="/assets/css/linearicons.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/simple-line-icons.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/ionicons.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="/custom/style.css?{{time()}}">
    @yield('css')
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <!-- Menu header start -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo" data-navbar-theme="theme4">
                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="ti-menu"></i>
                            </a>
                            <a class="mobile-search morphsearch-search" href="#">
                                <i class="ti-search"></i>
                            </a>
                            <a href="{{route('dashboard')}}">
                                <img class="img-fluid img-height-45" src="/media/logo-white.png" alt="Theme-Logo" />
                            </a>
                            <a class="mobile-options">
                                <i class="ti-more"></i>
                            </a>
                        </div>
                        
                        <div class="navbar-container container-fluid">
                            <div>
                                <ul class="nav-left">
                                    <li>
                                        <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                                    </li>
                                    
                                    <li>
                                        <a href="#!" onclick="javascript:toggleFullScreen()">
                                            <i class="ti-fullscreen"></i>
                                        </a>
                                    </li>
                                   
                                </ul>
                                <div class="header-reload">
                                    <ul class="nav-right">
                                       
                                        <li class="user-profile header-notification">
                                            <a href="#!">
                                                <img src="/assets/images/user.png" alt="User-Profile-Image">
                                                <span>{{ Auth::user()->name }}</span>
                                                <i class="ti-angle-down"></i>
                                            </a>
                                            <ul class="show-notification profile-notification">
                                               
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                        <i class="ti-layout-sidebar-left"></i> Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            
            
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">

                            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Local Server</div>
                            <ul class="pcoded-item pcoded-left-item">

                                <!-- permission_links at MainController -->
                                @php $_pages['pages'] = page_access($_pages['pages'], $permission_links);  @endphp
                                @foreach($_pages['pages'] as $pages)
                                    @if($pages['enable'])
                                        <li class="{{$pages['status']}} {{$pages['class']}} {{$pages['status'] == 'active' ? 'pcoded-trigger complete' : ''}}">
                                            <a href="{{$pages['url']}}">
                                                <span class="pcoded-micon"><i class="{{$pages['icon']}}"></i></span>
                                                <span class="pcoded-mtext" data-i18n="{{$pages['desc']}}">{{$pages['title']}}</span>
                                                @if($pages['has_sub'])
                                                <span class="pcoded-mcaret"></span>
                                                @endif
                                            </a>
                                            @if($pages['has_sub'])
                                                <ul class="pcoded-submenu">
                                                    @foreach($pages['sub'] as $sub)
                                                        @if($sub['enable'])
                                                            <li class="{{$sub['status']}}">
                                                                <a href="{{$sub['url']}}">
                                                                    <span class="pcoded-micon"><i class="{{$sub['icon']}}"></i></span>
                                                                    <span class="pcoded-mtext" data-i18n="{{$sub['desc']}}">{{$sub['title']}}</span>
                                                                </a>
                                                            </li>
                                                        @endif 
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                                <li><br><br><br></li>
                            </ul>
                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    
                                    <div class="page-header">
                                        <div class="page-header-title">
                                            <h4>{{$_pages['active_title']}}</h4>
                                        </div>
                                        <div class="page-header-breadcrumb">
                                            <ul class="breadcrumb-title">
                                                <li class="breadcrumb-item">
                                                    <a href="{{route('dashboard')}}">
                                                        <i class="icofont icofont-home"></i>
                                                    </a>
                                                </li>
                                                @foreach($_pages['active'] as $active)
                                                    <li class="breadcrumb-item"><a href="{{$active['active_url']}}">{{$active['active_title']}}</a></li>
                                                @endforeach
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    @yield('content')
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script type="text/javascript" src="/bower_components/jquery/js/jquery.min.js"></script>
    <script src="/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="/bower_components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="/bower_components/modernizr/js/css-scrollbars.js"></script>
    <!-- Calender js -->
    <script type="text/javascript" src="/bower_components/moment/js/moment.min.js"></script>
    <script type="text/javascript" src="/assets/pages/widget/calender/pignose.calendar.min.js"></script>
    <!-- classie js -->
    <script type="text/javascript" src="/bower_components/classie/js/classie.js"></script>
    <!-- c3 chart js -->
    <script src="/bower_components/c3/js/c3.js"></script>
    <!-- knob js -->
    <script src="/assets/pages/chart/knob/jquery.knob.js"></script>
    <script type="text/javascript" src="/assets/pages/widget/jquery.sparkline.js"></script>
    <!-- Rickshow Chart js -->
    <script src="/bower_components/d3/js/d3.js"></script>
    <script src="/bower_components/rickshaw/js/rickshaw.js"></script>
    <!-- Morris Chart js -->
    <script src="/bower_components/raphael/js/raphael.min.js"></script>
    <script src="/bower_components/morris.js/js/morris.js"></script>
    <!-- Todo js -->
    <script type="text/javascript" src="/assets/pages/todo/todo.js?v=1.01"></script>
    <!-- Float Chart js -->
    <script src="/assets/pages/chart/float/jquery.flot.js"></script>
    <script src="/assets/pages/chart/float/jquery.flot.categories.js"></script>
    <script src="/assets/pages/chart/float/jquery.flot.pie.js"></script>
    <!-- echart js -->
    <script src="/assets/pages/chart/echarts/js/echarts-all.js" type="text/javascript"></script>
    <!-- Horizontal-Timeline js -->
    <script type="text/javascript" src="/assets/pages/dashboard/horizontal-timeline/js/main.js"></script>
    <!-- amchart js -->
    <script type="text/javascript" src="/assets/pages/dashboard/amchart/js/amcharts.js"></script>
    <script type="text/javascript" src="/assets/pages/dashboard/amchart/js/serial.js"></script>
    <script type="text/javascript" src="/assets/pages/dashboard/amchart/js/light.js"></script>
    <script type="text/javascript" src="/assets/pages/dashboard/amchart/js/custom-amchart.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="/bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="/assets/pages/dashboard/custom-dashboard.js"></script>
    
    <!-- pcmenu js -->
    <script src="/assets/js/pcoded.min.js"></script>
    <script src="/assets/js/demo-12.js"></script>
    <script src="/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="/assets/js/jquery.mousewheel.min.js"></script>
    <script src="/bower_components/pnotify/js/pnotify.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.desktop.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.buttons.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.confirm.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.callbacks.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.animate.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.history.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.mobile.js"></script>
    <script type="text/javascript" src="/bower_components/pnotify/js/pnotify.nonblock.js"></script>
    <script type="text/javascript" src="/assets/js/script.js"></script>
    <!-- <script type="text/javascript" src="/theme/pages/pnotify/notify.js"></script> -->
    <script src="/plugin/socket.io.js"></script>
    <script type="text/javascript" src="/js/global.js?{{time()}}"></script>
    @yield('js')
</body>

</html>
