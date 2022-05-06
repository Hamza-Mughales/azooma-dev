<!doctype html>
<html lang="en">
<head>
<?php $this->load->view('inc/metaheader');?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>css/account/liteaccordion.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/account/liteaccordion.js"></script>
<link rel="shortcut icon" href="http://www.sufrati.com/sa/favicon.ico" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/newslider/jquery_cycle.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/newslider/structure.js"></script>
<style>
    .icon-remove{ opacity: .3 ; }
</style>
</head>

<body dir="rtl">
<?php $this->load->view('inc/ar/header');?>
<div class="top-nav sufrati-seperator">
  <div class="container hidden-overflow">
    <div class="left"> 
        <?php
            $restid=$this->session->userdata('rest_id');
            $permissions=$this->MGeneral->getRestPermissions($restid);
            if($permissions['accountType']==0){ ##FREE ACCOUNT
                echo 'عضو مجاني ';
            }elseif($permissions['accountType']==1){ ##BRONZE ACCOUNT
                echo ' العضو البرونزي ';
            }elseif($permissions['accountType']==2){ ##SILVER ACCOUNT
                echo ' العضو الفضي ';
            }elseif($permissions['accountType']==3){ ##GOLD ACCOUNT
                echo 'العضو الدهبي ';
            }
        ?> 
    </div>
    <ul class="nav pull-right settings">
      <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" > <?php echo (htmlspecialchars($rest['rest_Name_Ar'])); ?> إدارة <b class="caret"></b> </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('ar/settings');?>"> خيارات</a></li>
          <li class="divider"></li>  
          <li><a href="<?php echo site_url('ar/home/password');?>">تحديث كلمة السر</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo site_url('ar/home/logo');?>">تغيير الشعار</a></li>
<!--          <li class="divider"></li>
          <li><a href="<?php echo site_url();?>">Restaurant Reports</a></li>-->
          <li class="divider"></li>
          <li><a target="_blank" href="http://www.sufrati.com/saudi-arabian-dining/analytics/view/<?php echo $rest['rest_ID'];?>.html"> التقرير الشهري</a></li>
<!--          <li class="divider"></li>
          <li><a href="<?php echo site_url();?>">Theme selection</a></li>-->
          <li class="divider"></li>
          <li><a target="_blank" href="<? echo $this->config->item('sa_url').'rest/'.$rest['seo_url']; ?>">معاينة صفحة</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo site_url('home/logout');?>">Logout</a></li>
        </ul>
      </li>
    </ul>
    <span class="right-float"></span> </div>
</div>
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="page-header" style="margin-left: 0px;">
        <h1 >ترقية حسابك - <?php echo ucwords((htmlspecialchars($rest['rest_Name_Ar']))); ?></h1>
        <div class="right-float top-padding">
            <span class="btn-left-margin right-float">
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url();?>" class="btn" title="العودة">العودة</a>
            </span>
        </div>
      </div>
        <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
/*
?>
        <div class="row-fluid spacer ">
            <div class="slide-show">
                <div class="slide-show-inner" id="slideshow">
                <div class="slide"> <a href="#" > <img width="1160" height="484" class="center" src="<?php echo base_url(); ?>images/account/FREEMEMBER.jpg" alt="image" /></a> </div>                
                <div class="slide"> <a href="#" > <img width="1160" height="484" class="center" src="<?php echo base_url(); ?>images/account/SILVERMEMBER.jpg" alt="image" /></a> </div>
                <div class="slide"> <a href="#" > <img width="1160" height="484" class="center" src="<?php echo base_url(); ?>images/account/GOLDMEMBER.jpg" alt="image" /></a> </div>
                <div class="slide"> <a href="#" > <img width="1160" height="484" class="center" src="<?php echo base_url(); ?>images/account/VIDEOSERVICES.jpg" alt="image" /></a> </div>
              </div>
              <ul id="carouselnav" class="threeslides">
                <li > <a href="#" rel="nofollow" class="morebluebold"> عضو مجاني   </a> </li>                
                <li > <a href="#" rel="nofollow" class="morebluebold">  العضو الفضي   </a> </li>
                <li > <a href="#" rel="nofollow" class="morebluebold">  العضو الدهبي  </a> </li>
                <li > <a href="#" rel="nofollow" class="morebluebold"> عرض فيديو بالخدمات   </a> </li>

              </ul>
            </div>
        </div>
       <?php /*?> 
      <div class="accordion basic" id="demo">
        <ol>
          <li class="slide" name="one">
            <h2 class="free"><span><strong>Free Member</strong></span></h2>
            <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/FREEMEMBER.jpg" alt="image" /> </div>
          </li>
          <li class="slide" name="two">
            <h2 class="bronze"><span><strong>Bronze Member</strong></span></h2>
            <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/BRONZEMEMBER.jpg" alt="image"> </div>
          </li>
          <li class="slide" name="three">
            <h2 class="silver"><span><strong>Silver Member</strong></span></h2>
            <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/SILVERMEMBER.jpg" alt="image"> </div>
          </li>
          <li class="slide" name="four">
            <h2 class="gold"><span><strong>Gold Member</strong></span></h2>
            <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/GOLDMEMBER.jpg" alt="image"> </div>
          </li>
          <li class="slide" name="five">
            <h2 class="hdvideo"><span><strong>HD Video Services</strong></span></h2>
            <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/VIDEOSERVICES.jpg" alt="image"> </div>
          </li>
        </ol>
      </div>
      <?php */ ?>
        
     <div class="row-fluid spacer accordion">
    <article class="left span6 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#activities"> <a class="accordion-toggle" href="javascript:void(0);">  أختيار حساب سفرتي  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="activities" class="collapse in accordion-inner">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ملامح</th>             
              <th>الفضي</th>
              <th>الذهبي</th>
          </thead>
          <tbody>
            <tr>
                
          <td>معلومات المطعم</td>          
          <td class="center"><a href="#" data-rel="tooltip" title="Add and update all your business details and contact information."><i class="icon icon-ok"></i></a></td>
          <td class="center"><a href="#" data-rel="tooltip" title="Add and update all your business details and contact information."><i class="icon icon-ok"></i></td>
        </tr>
        <tr>
          <td>الفروع</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add and update branch location info, maps and more..."><i class="icon icon-ok"></i></a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add and update branch location info, maps and more..."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>القائمة</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add all your menu Items + add your PDF for customers to download."><i class="icon icon-ok"></i></a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add all your menu Items + add your PDF for customers to download."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>صور</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add and View 12 photos"><i class="icon icon-ok"></i></a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Add and View 20 photos"><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>قنوات الأخبار</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Your Updates will appear on sufrati.com News Feed on home page eg. When you change your menu, images, offers, contact numbers."><i class="icon icon-ok"></i></a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Your Updates will appear on sufrati.com News Feed on home page eg. When you change your menu, images, offers, contact numbers."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>عروض خاصة</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Display your Latest Offer on your profile page and in sufrati.com’s Special offers page instantly."> <i class="icon icon-ok"></i> </a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Display your Latest Offer on your profile page and in sufrati.com’s Special offers page instantly."> <i class="icon icon-ok"></i> </a></td>
        </tr>
        <tr>
          <td>تعليقات الاستجابة</td>
          <td class="center"><a data-rel="tooltip" href="#" title="Respond to important customer comments both good and bad."><i class="icon icon-ok"></i></a></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Respond to important customer comments both good and bad."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>نادي المعجبين</td>
          <td class="center"><i class="icon icon-remove"></i></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Fans will receive instant notifications direct to their emails and sufrati.com accounts about your latest updates eg. Menu, images, offers, contact numbers."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>تحميل الفيديو</td>
          <td class="center"><i class="icon icon-remove"></i></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Attract your customers with Video’s on your page."> <i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>استطلاع</td>
          <td class="center"><i class="icon icon-remove"></i></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Create polls and find out what your visitors think."><i class="icon icon-ok"></i></a></td>
        </tr>
        <tr>
          <td>الحجز</td>
          <td class="center"><i class="icon icon-remove"></i></td>
          <td class="center"><a data-rel="tooltip" href="#" title="Available for Gold in Early 2012"><i class="icon icon-ok"></i></a></td>
        </tr>
          </tbody>
        </table>
      </div>
    </article>
    <article class="left span6 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#notify"> <a class="accordion-toggle" href="javascript:void(0);">  أختيار العروض <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
          <div id="notify" class="collapse in accordion-inner">
            <form id="accountForm" action="<?php echo base_url('ar/accounts/save'); ?>" method="post">  
            <legend>حدد حسابك</legend>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
               
                  <th class="center">الفضي</th>
                  <th class="center">الذهبي</th>
              </thead>
              <tbody>
                  <tr>
                    
                      <td class="center"><input type="radio" <?php if($permissions['accountType']==2){ echo 'disabled="disabled"'; } ?> name="preset" id="preset" value="1" /></td>
                      <td class="center"><input type="radio" <?php if($permissions['accountType']==3){ echo 'disabled="disabled"'; } ?> name="preset" id="preset" value="2" /></td>
                  </tr>
              </tbody>
            </table>
          
            <legend>حدد المدة</legend>  
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                 <!-- <th class="center">ثلاثة أشهر</th>
                  <th class="center">ستة أشهر</th> -->
                  <th class="center">سنة واحدة</th>
                  
              </thead>
              <tbody>
                  <tr>
                      <!-- <td class="center"><input class="required" type="radio" name="duration" id="duration" value="3"></td>
                      <td class="center"><input class="required" type="radio" name="duration" id="duration" value="6"></td> -->
                      <td class="center"><input checked="checked" type="radio" name="duration" id="duration" value="12"></td>
                  </tr>
              </tbody>
            </table>

            <legend>أنت مهتما</legend>    
            <table class="table table-bordered table-striped">
              <tbody>
                  <tr>
                      <td>خدمات الفيديو</td>
                      <td class="center"><input type="checkbox" name="addservices[]" value="HD Video Services" id="hd"/></td>
                  </tr>
                  <tr>
                      <td>تصميم وتطوير الويب</td>
                      <td class="center"><input type="checkbox" name="addservices[]" value="Web Designing & Development" id="web" /></td>
                  </tr>
                  <tr>
                      <td>القائمة التصميم</td>
                      <td class="center"><input type="checkbox" name="addservices[]" value="Menu Design" id="menu" /></td>
                  </tr>
                  <tr>
                      <td>خدمات التصوير الفوتوغرافي</td>
                      <td class="center"><input type="checkbox" name="addservices[]" value="Photography Services" id="photo" /></td>
                  </tr>
                  <tr>
                      <td>العلامات التجارية</td>
                      <td class="center"><input type="checkbox" name="addservices[]" value="Branding" id="brand" /></td>
                  </tr>
              </tbody>
            </table>

            <legend>هل لديكم أي أسئلة؟</legend>    
            <table class="table table-bordered table-striped">
              <tbody>
                  <tr>
                      <td>
                          <textarea name="msg" id="msg" cols="45" rows="3" style="width:98%"></textarea>
                      </td>
                  </tr>                  
                  <tr>
                      <td><input type="submit" class="btn btn-primary right-float" value=" تقدم " /></td>
                  </tr>
              </tbody>
            </table>
           </form> 
        </div>
    </article>
  </div>
            
     
    </div>
  </div>
</div>
<?php $this->load->view('inc/footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/account/memshipaccordian.js"></script> 
<script>
 $(document).ready(function() {   
    $("[data-rel=tooltip]").tooltip();
        $("#accountForm").validate();
 });
</script>
    
</body>
</html>