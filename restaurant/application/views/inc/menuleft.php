<?php
$string=$this->uri->segment(1);
$subString=$this->uri->segment(2);
if($string==""){
    $string="home";
}
?>
<?php /*?> data-spy="affix" <?php */  ?>

<div id="spy-bar" >
<ul class="nav nav-list bs-docs-sidenav " >
         
    <li <?php if($string=="home" && $subString==""  ) echo 'class="active"';?> ><a href="<?php echo base_url('home');?>"><i class="icon-chevron-right"></i> <i class="icon-home"></i> Home</a></li>
    <li <?php if($string=="profile") echo 'class="active"';?> ><a href="<?php echo base_url('profile');?>"><i class="icon-chevron-right"></i> <i class="icon-file"></i> Profile Page</a></li>
    <li <?php if($string=="branches") echo 'class="active"';?> ><a href="<?php echo base_url('branches');?>"><i class="icon-chevron-right"></i> <i class="icon-map-marker"></i> Branches & Locations</a></li>
    <li <?php if($string=="menus") echo 'class="active main"';?> >
        <a href="<?php echo base_url('menus');?>"> <i class="icon-chevron-right"></i> <i class="icon-list-alt "></i> Menu Management</a>
            <div class="sub-menu <?php if($string=="menus") echo 'current-sub-menu';?>">
                 <div class="sub-menu-wrap">
                     <ul>
                         <li <?php if($string=="menus" && $subString!="pdf") echo 'class="active main"';?> >
                            <a href="<?php echo base_url('menus');?>"> >> Menus</a>
                         </li>
                         <li <?php if($subString=="pdf") echo 'class="active main"';?> >
                            <a href="<?php echo base_url('menus/pdf');?>"> >> PDF Menus</a>
                         </li>
                     </ul>
                 </div>
             </div>
    </li>
    <li <?php if($string=="mydiners") echo 'class="active"';?> ><a href="<?php echo base_url('mydiners');?>"><i class="icon-chevron-right"></i>  <i class="icon-user"></i> My Diners</a></li>
    <li <?php if($string=="home" && $subString=="comments") echo 'class="active"';?> ><a href="<?php echo base_url('home/comments');?>"><i class="icon-chevron-right"></i>  <i class="icon-list"></i> Customer Comments</a></li>
    <li <?php if($string=="gallery" || $subString=="userUploads") echo 'class="active"';?> >
        <a href="<?php echo base_url('gallery');?>"><i class="icon-chevron-right"></i>  <i class="icon-picture"></i> Photo Gallery</a>
        <div class="sub-menu <?php if($string=="gallery" || $subString=="userUploads" ) echo 'current-sub-menu';?>">
            <div class="sub-menu-wrap">
                <ul>
                    <li <?php if($string=="gallery" && $subString=="") echo 'class="active main"';?> >
                       <a href="<?php echo base_url('gallery');?>"> >> Restaurant Photos</a>
                    </li>
                    <li <?php if($subString=="userUploads") echo 'class="active main"';?> >
                       <a href="<?php echo base_url('home/userUploads');?>"> >> Users Photos</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li <?php if($string=="offers") echo 'class="active"';?> ><a href="<?php echo base_url('offers');?>"><i class="icon-chevron-right"></i>  <i class="icon-star"></i> Special Offers</a></li>
<!--    <li <?php if($string=="booking") echo 'class="active"';?> ><a href="<?php echo base_url('booking');?>"><i class="icon-chevron-right"></i> Booking</a></li>-->
    <li <?php if($string=="video") echo 'class="active"';?> ><a href="<?php echo base_url('video');?>"><i class="icon-chevron-right"></i>  <i class="icon-play"></i> Restaurant Videos</a></li>
<!--    <li <?php if($string=="polls") echo 'class="active"';?> ><a href="<?php echo base_url('polls');?>"><i class="icon-chevron-right"></i> Polls</a></li>-->
    
    <li <?php if($string=="settings") echo 'class="active"';?> ><a href="<?php echo base_url('settings');?>"><i class="icon-chevron-right"></i>  <i class="icon-briefcase"></i> Account Settings</a></li>
    <li <?php if($string=="accounts") echo 'class="active"';?> style="" ><a href="<?php echo base_url('accounts');?>" class="pink-bar" ><i class="icon-chevron-right"></i> Upgrade My Account</a></li>
</ul>
</div>