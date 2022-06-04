<?php
$string="";
$string = Request::segment(2);
$substring = Request::segment(3);
if(!isset($side_menu)){
  $side_menu=[];
}
?>

<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
  <div>
    <div class="logo-wrapper"><a href="index.html"><img width="150px" class="img-fluid for-light" src="<?= asset("img/logo.png") ?>" alt=""><img class="img-fluid for-dark" src="" alt=""></a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"home") ? "active":""?>" href="<?=url("hungryn137")?>"><i data-feather="home"></i><span><?=__('Dashboard')?></span></a></li>
     
     
  
          <li><a class="sidebar-link sidebar-title link-nav <?=menu($side_menu,"Country List") ? "active":""?>" href="<?=url("hungryn137/admincountry")?>"><i data-feather="map"></i>  <?=__('Country List')?></a></li>
          <li><a class="sidebar-link sidebar-title link-nav   <?=menu($side_menu,"Administrators") ? "active":""?>" href="<?= url('hungryn137/admins'); ?>"><i data-feather="user"></i> <?=__('Administrators')?></a></li>

    
          

      
      

          <li class="py-5 "></li>

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->
