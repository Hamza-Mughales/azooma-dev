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
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Restaurant Mgmt") ? "active":""?>" href="#"><i data-feather="coffee"></i> <span><?=__('Restaurant Mgmt')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Restaurant Mgmt") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Add Restaurants") ? "active":""?>" href="<?=url("hungryn137/adminrestaurants/form")?>"><?=__('Add Restaurants')?></a></li>
              <li><a class="<?=menu($side_menu,"Restaurants") ? "active":""?>" href="<?=url("hungryn137/adminrestaurants")?>"><?=__('Restaurants')?></a></li>
              <li><a class="<?=menu($side_menu,"Restaurant Emails") ? "active":""?>" href="<?=url("hungryn137/adminrestaurants/emails")?>"><?=__('Restaurant Emails')?></a></li>
              <li><a class="<?=menu($side_menu,"Group of Restaurants") ? "active":""?>" href="<?=url("hungryn137/adminrestaurantsgroup")?>"><?=__('Group of Restaurants')?></a></li>
              <li><a class="<?=menu($side_menu,"Hotels") ? "active":""?>" href="<?=url("hungryn137/adminhotels")?>"><?=__('Hotels')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"DB Management") ? "active":""?>" href="#"><i data-feather="database"></i> <span><?=__('DB Management')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"DB Management") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Restaurant Style") ? "active":""?>" href="<?=url("hungryn137/adminreststyle")?>"><?=__('Restaurant Style')?></a></li>
              <li><a class="<?=menu($side_menu,"Business Types") ? "active":""?>" href="<?=url("hungryn137/adminresttypes")?>"><?=__('Business Types')?></a></li>
              <li><a class="<?=menu($side_menu,"Features & Services") ? "active":""?>" href="<?=url("hungryn137/adminrestservices")?>"><?=__('Features & Services')?></a></li>
              <li><a class="<?=menu($side_menu,"Moods & Atmosphere") ? "active":""?>" href="<?=url("hungryn137/adminmoodsatmosphere")?>"><?=__('Moods & Atmosphere')?></a></li>
              <li><a class="<?=menu($side_menu,"Offer Categories") ? "active":""?>" href="<?=url("hungryn137/adminofferscategoires")?>"><?=__('Offer Categories')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Categories / Lists") ? "active":""?>" href="#"><i data-feather="grid"></i> <span><?=__('Categories / Lists')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Categories / Lists") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Favorites") ? "active":""?>" href="<?=url("hungryn137/adminfavorites")?>"><?=__('Favorites')?></a></li>
              <li><a class="<?=menu($side_menu,"Cuisine List") ? "active":""?>" href="<?=url("hungryn137/admincuisine")?>"><?=__('Cuisine List')?></a></li>
              <li><a class="<?=menu($side_menu,"Known For") ? "active":""?>" href="<?=url("hungryn137/adminknownfor")?>"><?=__('Known For')?></a></li>
              <li><a class="<?=menu($side_menu,"Suggested") ? "active":""?>" href="<?=url("hungryn137/adminsuggested")?>"><?=__('Suggested')?></a></li>
              <li><a class="<?=menu($side_menu,"Most Viewed") ? "active":""?>" href="<?=url("hungryn137/adminrestaurants/mostview")?>"><?=__('Most Viewed')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Locations") ? "active":""?>" href="#"><i data-feather="map"></i> <span><?=__('Locations')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Locations") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Country List") ? "active":""?>" href="<?=url("hungryn137/admincountry")?>"><?=__('Country List')?></a></li>
              <li><a class="<?=menu($side_menu,"City List") ? "active":""?>" href="<?=url("hungryn137/admincity")?>"><?=__('City List')?></a></li>
              <li><a class="<?=menu($side_menu,"District List") ? "active":""?>" href="<?=url("hungryn137/admindistrict")?>"><?=__('District List')?></a></li>
              <li><a class="<?=menu($side_menu,"Locations List") ? "active":""?>" href="<?=url("hungryn137/adminlocations")?>"><?=__('Locations List')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Gallery") ? "active":""?>" href="#"><i data-feather="image"></i> <span><?=__('Gallery')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Gallery") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Food Gallery") ? "active":""?>" href="<?= URL::route('admingallery').'?type=All'; ?>"><?=__('Food Gallery')?></a></li>
              <li><a class="<?=menu($side_menu,"Uploads") ? "active":""?>" href="<?= URL::route('admingallery').'?type=Sufrati'; ?>"><?=__('Uploads')?></a></li>
              <li><a class="<?=menu($side_menu,"User Uploads") ? "active":""?>" href="<?= URL::route('admingallery').'?type=Users'; ?>"><?=__('User Uploads')?></a></li>
              <li><a class="<?=menu($side_menu,"Video Uploads") ? "active":""?>" href="<?= URL::route('admingallery/videos'); ?>"><?=__('Video Uploads')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Blog") ? "active":""?>" href="#"><i data-feather="film"></i> <span><?=__('Blog')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Blog") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Articles") ? "active":""?>" href="<?= url('hungryn137/adminarticles'); ?>"><?=__('Articles')?></a></li>
              <li><a class="<?=menu($side_menu,"Recipes") ? "active":""?>" href="<?= url('hungryn137/adminrecipe'); ?>"><?=__('Recipes')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Competitions") ? "active":""?>" href="#"><i data-feather="globe"></i> <span><?=__('Competitions')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Competitions") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Events & Competitions") ? "active":""?>" href="<?= url('hungryn137/admincompetitions'); ?>"><?=__('Events & Competitions')?></a></li>
              <li><a class="<?=menu($side_menu,"Occasions Services") ? "active":""?>" href="<?= url('hungryn137/adminoccasions'); ?>"><?=__('Occasions Services')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Emailing List") ? "active":""?>" href="#"><i data-feather="mail"></i> <span><?=__('Emailing List')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Emailing List") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"News Letter") ? "active":""?>" href="<?= url('hungryn137/adminnewsletter'); ?>"><?=__('News Letter')?></a></li>
              <li><a class="<?=menu($side_menu,"Event Calendar") ? "active":""?>" href="<?= url('hungryn137/admineventcalendar'); ?>"><?=__('Event Calendar')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Art Work") ? "active":""?>" href="#"><i data-feather="loader"></i> <span><?=__('Art Work')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Art Work") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Slider Artwork") ? "active":""?>" href="<?= URL::route('adminartkwork').'?type=Home Page Artwork'; ?>"><?=__('Slider Artwork')?></a></li>
              <li><a class="<?=menu($side_menu,"Logo Artwork") ? "active":""?>" href="<?= URL::route('adminartkwork').'?type=Azooma Logo'; ?>"><?=__('Logo Artwork')?></a></li>
              <li><a class="<?=menu($side_menu,"Banners") ? "active":""?>" href="<?= URL::route('adminbanners'); ?>"><?=__('Banners')?></a></li>
              <li><a class="<?=menu($side_menu,"Category Artwork") ? "active":""?>" href="<?= URL::route('admincategoryartwork'); ?>"><?=__('Category Artwork')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Corporate Pages") ? "active":""?>" href="#"><i data-feather="activity"></i> <span><?=__('Corporate Pages')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Corporate Pages") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Team") ? "active":""?>" href="<?= URL::route('adminteam') ?>"><?php echo Config::get('settings.sitename'); ?> <?=__('Team')?></a></li>
              <li><a class="<?=menu($side_menu,"Testimonials") ? "active":""?>" href="<?= URL::route('admintestimonials') ?>"><?php echo Config::get('settings.sitename'); ?> <?=__('Testimonials')?></a></li>
              <li><a class="<?=menu($side_menu,"Information Pages") ? "active":""?>" href="<?= URL::route('adminpages'); ?>"><?=__('Information Pages')?></a></li>
              <li><a class="<?=menu($side_menu,"Sponsors") ? "active":""?>" href="<?= URL::route('adminsponsors'); ?>"><?php echo Config::get('settings.sitename'); ?> <?=__('Sponsors')?></a></li>
              <li><a class="<?=menu($side_menu,"Press") ? "active":""?>" href="<?= URL::route('adminpress'); ?>"><?php echo Config::get('settings.sitename'); ?> <?=__('Press')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Subscriptions") ? "active":""?>" href="#"><i data-feather="thumbs-up"></i> <span><?=__('Subscriptions')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Subscriptions") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Subscription Types") ? "active":""?>" href="<?= URL::route('adminsubscriptions'); ?>"><?=__('Subscription Types')?></a></li>
              <li><a class="<?=menu($side_menu,"All Members") ? "active":""?>" href="<?= URL::route('adminmembers'); ?>"><?=__('All Members')?></a></li>
              <li><a class="<?=menu($side_menu,"Paid Members") ? "active":""?>" href="<?= URL::route('adminpaidmembers'); ?>"><?=__('Paid Members')?></a></li>
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Billing") ? "active":""?>" href="#"><i data-feather="file-text"></i> <span><?=__('Billing')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Billing") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Manage Invoice") ? "active":""?>" href="<?= url('hungryn137/admininvoice'); ?>"><?=__('Manage Invoice')?></a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Users") ? "active":""?>" href="#"><i data-feather="users"></i> <span><?=__('Users')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Users") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Administrators") ? "active":""?>" href="<?= url('hungryn137/admins'); ?>"><?=__('Administrators')?></a></li>
              <li><a class="<?=menu($side_menu,"General Users") ? "active":""?>" href="<?= url('hungryn137/adminusers'); ?>"><?=__('General Users')?></a></li>
              <li><a class="<?=menu($side_menu,"Restaurant managers") ? "active":""?>" href="<?= url('hungryn137/adminrestmanagers'); ?>"><?=__('Restaurant managers')?></a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title <?=menu($side_menu,"Miscellaneous") ? "active":""?>" href="#"><i data-feather="sliders"></i> <span><?=__('Miscellaneous')?></span></a>
            <ul class="sidebar-submenu <?=menu($side_menu,"Miscellaneous") ? "d-block":""?>">
              <li><a class="<?=menu($side_menu,"Manage Polls") ? "active":""?>" href="<?= url('hungryn137/adminpolls'); ?>"><?=__('Manage Polls')?></a></li>
              <li><a class="<?=menu($side_menu,"Restaurant Comments") ? "active":""?>" href="<?= url('hungryn137/admincomments'); ?>"><?=__('Restaurant Comments')?></a></li>
              <li><a class="<?=menu($side_menu,"Article Comments") ? "active":""?>" href="<?= url('hungryn137/adminarticlecomments'); ?>"><?=__('Article Comments')?></a></li>
              <li><a class="<?=menu($side_menu,"All Menu Request") ? "active":""?>" href="<?= url('hungryn137/adminmenurequest'); ?>"><?=__('All Menu Request')?></a></li>
            </ul>
          </li>

          <li class="py-5 "></li>

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->
