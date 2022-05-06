<?php 
if(!isset($side_menu)){
  $side_menu=array();
}
?>
<div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper">
          <div>
            <div class="logo-wrapper"><a href="index.html"><img width="150px" class="img-fluid for-light" src="<?= base_url("images/login_logo.png") ?>" alt=""><img class="img-fluid for-dark" src="" alt=""></a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
              <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            </div>
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                
            
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"home") ? "active":""?>" href="<?=base_url("home")?>"><i data-feather="home"></i><span><?=lang('Dashboard')?></span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"profile") ? "active":""?>" href="<?=base_url("profile")?>"><i data-feather="user"></i><span><?=lang('profile_page')?></span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"branches") ? "active":""?>" href="<?=base_url("branches")?>"><i data-feather="map-pin"></i><span> <?=lang('branches_locations')?></span></a></li>
                  
                  
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"menu") ? "active":""?>" href="#"><i data-feather="airplay"></i> <span><?=lang('menu_management')?></span></a>
                    <ul class="sidebar-submenu <?=menu($side_menu,"menu") ? "d-block":""?>">
                      <li><a class="<?=menu($side_menu,"index") ? "active":""?>" href="<?=base_url("menus")?>"><?=lang('menus')?></a></li>
                      <li><a class="<?=menu($side_menu,"pdf") ? "active":""?>" href="<?=base_url("menus/pdf")?>"><?=lang('pdf_menus')?></a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"mydiners") ? "active":""?>" href="<?=base_url("mydiners")?>"><i data-feather="users"></i><span> <?=lang('my_diners')?></span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"customer_comments") ? "active":""?>" href="<?=base_url("home/comments")?>"><i data-feather="message-circle"></i><span> <?=lang('customer_comments')?></span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"ratings") ? "active":""?>" href="<?=base_url("rate")?>"><i data-feather="percent"></i><span> <?=lang('ratings')?></span></a></li>
                  
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"gallery") ? "active":""?>" href="#"><i data-feather="image"></i><span ><?=lang('photo_gallery')?> </span></a>
                    <ul class="sidebar-submenu <?=menu($side_menu,"gallery") ? "d-block":""?>">
                      <li><a class="<?=menu($side_menu,"r_photo") ? "active":""?>" href="<?=base_url("gallery")?>"><?=lang('restaurant_photos')?></a></li>
                      <li><a class="<?=menu($side_menu,"user_photo") ? "active":""?>" href="<?=base_url("home/userUploads")?>"><?=lang('users_photos')?></a></li>
                    
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"offers") ? "active":""?>" href="<?=base_url("offers")?>"><i data-feather="star"></i><span><?=lang('special_offers')?> </span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"video") ? "active":""?>" href="<?=base_url("video")?>"><i data-feather="film"></i><span> <?=lang('restaurant_videos')?> </span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"settings") ? "active":""?>" href="<?=base_url("settings")?>"><i data-feather="settings"></i><span> <?=lang('account_settings')?> </span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"account") ? "active":""?>" href="<?=base_url("accounts")?>"><i data-feather="trending-up"></i><span> <?=lang('upgrade_account')?></span></a></li>
                
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
          </div>
        </div>
        <!-- Page Sidebar Ends-->