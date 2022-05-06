<?php

use Illuminate\Support\Facades\Lang;
?>
<body class="dash-body <?=(sys_lang()=="arabic" ?"rtl" :"")?> <?=(isset($_COOKIE['darkMode']) && $_COOKIE['darkMode']==1 ? "dark-only" :"")?>">
    <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
        </filter>
      </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="#"><img class="img-fluid" src="<?=app_files_url()?>/logos/<?php echo rest_info()->rest_Logo?>" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                   
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang"><?=sys_lang()=="arabic" ? '<i class="flag-icon flag-icon-sa"></i>' :'<i class="flag-icon flag-icon-us"></i>'?><span class="lang-txt"><?=sys_lang()=="arabic" ? "AR" :"EN"?> </span></div>
                                </div>
                                <div class="more_lang">
                                    <div class="lang <?=sys_lang()=="english" ?"selected":"" ?>" data-value="en"><a class="p-0" href="<?=base_url("home/set_language/english")?>"><i class="flag-icon flag-icon-us"></i><span class="lang-txt">English<span></span></span></a></div>
                                    <div class="lang <?=sys_lang()=="arabic" ?"selected":"" ?>" data-value="sa"><a class="p-0"  href="<?=base_url("home/set_language/arabic")?>"><i class="flag-icon flag-icon-sa"></i><span class="lang-txt">العربية <span> </span></span></a></div>
                                </div>
                            </div>
                        </li>
                        <li class="d-none"> <span class="header-search"><i data-feather="search"></i></span></li>
                        <li class="onhover-dropdown">
                            <div class="notification-box"><i data-feather="bell"> </i><span class="badge rounded-pill badge-secondary">4 </span></div>
                            <ul class="notification-dropdown onhover-show-div">
                                <li><i data-feather="bell"></i>
                                    <h6 class="f-18 mb-0">Notitications</h6>
                                </li>
                                <li>
                                    <p><i class="fa fa-circle-o me-3 font-primary"> </i>Delivery processing <span class="pull-right">10 min.</span></p>
                                </li>
                                <li>
                                    <p><i class="fa fa-circle-o me-3 font-success"></i>Order Complete<span class="pull-right">1 hr</span></p>
                                </li>
                                <li>
                                    <p><i class="fa fa-circle-o me-3 font-info"></i>Tickets Generated<span class="pull-right">3 hr</span></p>
                                </li>
                                <li>
                                    <p><i class="fa fa-circle-o me-3 font-danger"></i>Delivery Complete<span class="pull-right">6 hr</span></p>
                                </li>
                                <li><a class="btn btn-primary" href="#">Check all notification</a></li>
                            </ul>
                        </li>
               
                        <li>
                            <div class="mode <?=(isset($_COOKIE['darkMode']) && $_COOKIE['darkMode']==1 ? "selected" :"")?>">
                            
                            <?=(isset($_COOKIE['darkMode']) && $_COOKIE['darkMode']==1 ? '<i class="fa fa-lightbulb-o"></i>' :'<i class="fa fa-moon-o"></i>')?>
                            
                        
                        </div>
                        </li>
                 
                        <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media"><img class="b-r-10" src="<?php echo base_url("logos".rest_info()->rest_Logo); ?>" alt="">
                                <div class="media-body"><span> <?php echo (htmlspecialchars(rest_info()->rest_Name)); ?></span>
                                    <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="<?php echo base_url('settings'); ?>"><i data-feather="settings"></i><span><?=lang('my_account')?> </span></a></li>
                                
                                <li><a href="<?php echo base_url('home/logo'); ?>"><i data-feather="file-text"></i><span><?=lang("change_logo")?></span></a></li>

                                <li><a href="<?php echo base_url('home/password'); ?>"><i data-feather="edit-2"></i><span><?=lang('change_password')?></span></a></li>
                                <li><a href="<?=base_url("home/logout")?>"><i data-feather="log-in"> </i><span><?=lang('log_out')?></span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <!-- Page Header Ends  -->