<?php
$string = $this->uri->segment(2);
$subString = $this->uri->segment(3);
if ($string == "") {
    $string = "home";
}
?>
<?php /* ?> data-spy="affix" <?php */ ?>

<div id="spy-bar" >
    <ul class="nav nav-list bs-docs-sidenav " >

        <li <?php if ($string == "home" && $subString == "") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/home'); ?>"> <i class="icon-home"></i><i class="icon-chevron-left"></i> الصفحه الرئيسية </a></li>
        <li <?php if ($string == "profile") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/profile'); ?>"><i class="icon-file"></i>  <i class="icon-chevron-left"></i> المعلومات </a></li>
        <li <?php if ($string == "branches") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/branches'); ?>"> <i class="icon-map-marker"></i> <i class="icon-chevron-left"></i> الفروع </a></li>
        <li <?php if ($string == "menus") echo 'class="active main"'; ?> >
            <a href="<?php echo site_url('ar/menus'); ?>"> <i class="icon-list-alt"></i> <i class="icon-chevron-left"></i> القائمة</a>
            <div class="sub-menu <?php if ($string == "menus") echo 'current-sub-menu'; ?>">
                <div class="sub-menu-wrap">
                    <ul>
                        <li <?php if ($string == "menus" && $subString != "pdf") echo 'class="active main"'; ?> >
                            <a href="<?php echo site_url('ar/menus'); ?>">>> القائمة  </a>
                        </li>
                        <li <?php if ($subString == "pdf") echo 'class="active main"'; ?> >
                            <a href="<?php echo site_url('ar/menus/pdf'); ?>"> >> PDF القائمة </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li <?php if ($string == "mydiners") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/mydiners'); ?>"> <i class="icon-user"></i> <i class="icon-chevron-left"></i>  عملائي </a></li>
        <li <?php if ($string == "home" && $subString == "comments") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/home/comments'); ?>"> <i class="icon-list"></i> <i class="icon-chevron-left"></i> التعليقات </a></li>
        <li <?php if ($string == "gallery" || $subString == "userUploads") echo 'class="active"'; ?> >
            <a href="<?php echo site_url('ar/gallery'); ?>"> <i class="icon-picture"></i> <i class="icon-chevron-left"></i> الصور</a>
            <div class="sub-menu <?php if ($string == "gallery" || $subString == "userUploads") echo 'current-sub-menu'; ?>">
                <div class="sub-menu-wrap">
                    <ul>
                        <li <?php if ($string == "gallery" && $subString == "") echo 'class="active main"'; ?> >
                            <a href="<?php echo site_url('ar/gallery'); ?>">>> المطاعم الصور </a>
                        </li>
                        <li <?php if ($subString == "userUploads") echo 'class="active main"'; ?> >
                            <a href="<?php echo site_url('ar/home/userUploads'); ?>"> >>  الصور المستخدمين   </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>    
        <li <?php if ($string == "offers") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/offers'); ?>"> <i class="icon-star"></i> <i class="icon-chevron-left"></i> العروض</a></li>
    <!--    <li <?php if ($string == "booking") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/booking'); ?>"><i class="icon-chevron-left"></i> الحجوزات</a></li>-->
        <li <?php if ($string == "video") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/video'); ?>"> <i class="icon-play"></i> <i class="icon-chevron-left"></i> كليبات الفيديو</a></li>
    <!--    <li <?php if ($string == "polls") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/polls'); ?>"><i class="icon-chevron-left"></i> الاستطلاعات</a></li>-->

        <li <?php if ($string == "settings") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/settings'); ?>"> <i class="icon-briefcase"></i> <i class="icon-chevron-left"></i> خيارات</a></li>
        <li <?php if ($string == "accounts") echo 'class="active"'; ?> ><a href="<?php echo site_url('ar/accounts'); ?>" class="pink-bar"><i class="icon-chevron-left"></i> للاشتراك</a></li>
    </ul>
</div>