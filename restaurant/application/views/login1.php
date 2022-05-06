<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<link rel="shortcut icon" href="http://www.sufrati.com/sa/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--
 #####              ####                       #         #    
 #     #            #                           #              
 #        #     #  ####      # ###    ######  ######    ###    
  #####   #     #   #        ##      #     #    #         #    
       #  #     #   #        #       #     #    #         #    
 #     #  #    ##   #        #       #    ##    #         #    
  #####    #### #   #        #        #### #     ###    ##### 
  -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Restaurant Owners Login | <?php echo $sitename; ?></title>
<meta name="keywords" content="Restaurants,saudi arabia, lebanon, arabia,middle east, hotels, cafes, dining, delivery">
<meta name="description" content=" Restaurant directory and hotel dining guide of Arabia, Restaurants, home delivery, takeaway">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/helper.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/new.css">
<script type="text/javascript" src="<?php echo base_url();?>js/new/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/new/bootstrap-alert.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script>
</head>
<body>
<div id="header-container">
  <header>
    <div class="wrapper clearfix">
      <h1 id="title" class="left"> <a href="http://www.sufrati.com/" title="Restaurant Directory &amp; Hotel dining guide"> <img src="<?php  echo "http://uploads.azooma.co/sufratilogo/".$logo['image']; ?>" alt="<?php echo $sitename;?>"/> </a> </h1>
      <div class="right" id="banner"><img src="<?php echo site_url();?>images/top-photos.jpg" alt="Food Photos" id="top-photos"></div>
    </div>
    <div class="main-nav">
      <div class="wrapper clearfix">
        <div class="left">
          <h1 class="city-main-head black normal-head"><span>Restaurant</span> Owners</h1>
        </div>
        <div id="social-icons-top">
          <ul class="social-icons">
            <li class="facebook"><a target="_blank" href="https://www.facebook.com/Sufrati.com" title="Share on Facebook"> </a></li>
            <li class="twitter"><a target="_blank" href="http://www.twitter.com/sufrati" title="Share on Twitter"></a></li>
            <li class="linkIn"><a target="_blank" href="http://www.linkedin.com/company/2249129" title="Share on LinkIn"></a></li>
            <li class="youtube"><a target="_blank" href="http://www.youtube.com/videosufrati" title="Share on Youtube"> </a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</div>
<div id="main-container">
  <section class="overflow">
  <div class="wrapper clearfix">
    <div id="city-home-box" class="left white-box shadow">
      <h2 class="main-head black normal-head"> <span>Login</span> to your account</h2>
      <div class="overflow">
        <?php
		if($this->session->flashdata('error')){
			echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
		}
                if($this->session->flashdata('message')){
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
                  }
		?>
        <form name="loginform" id="loginform" action="<?php echo base_url();?>home/login_form_submit" method="post" >
          <div id="home-page-text" class="overflow ">
            <p>
              <input type="text" name="User" id="User" placeholder="Username - اسم المستخدم" class="reg-input required" value="" size="20" tabindex="10">
            </p>
            <p>
              <input type="password" name="Password" id="Password" placeholder="Password - كلمة السر" class="reg-input required" value="" size="20" tabindex="20">
            </p>
            <p>
              <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
              <span style="float:left;margin-right:105px;">
              <select class="reg-input" name="language" id="language" style="width:180px;">
                <option value="0">English - الإنجليزية</option>
                <option value="1">Arabic - العربية</option>
              </select>
              </span>
              <span>
              <input type="image" src="<?php echo site_url();?>images/login-btn.gif" value="Submit" alt="Submit">
              </span>
            </p>
            <p style="clear:both"><a href="<?php echo site_url('home/forgot');?>">Forgot your Password? - <span dir="rtl">نسيت كلمة المرور </span></a></p>
          </div>
        </form>
      </div>
    </div>
    <div id="city-home-box" class="right white-box shadow">
      <h2 class="main-head black normal-head"> <span>Create</span> your free business account</h2>
      <div class="overflow">
        <div id="home-page-text" class="overflow ">
          <p>Add your restaurant and take advantage of our free services. Sufrati.com connects you with your audience without failure. <br />
            <br />
            Specializing only in the field of dining, Sufrati.com is designed to make finding the restaurant of choice easy for diners, creating an easy and reliable way to get noticed.</p>
          <p style="margin:25px 0px;"> <a href="http://stage.azooma.co/restaurant/suggest">
            <input type="image" src="<?php echo site_url();?>images/create-btn.gif" value="" alt="">
            </a> </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<section class="article">
  <div class="wrapper clearfix">
    <div class="col-3 left">
      <div class="col-icons"><img src="<?php echo site_url();?>images/take-control-icon.jpg" alt="Take Control"></div>
      <h4><strong>Take control</strong> of your information</h4>
      <p>Verified owners and managers can edit their Sufrati.com page instantly to keep their important info up-to-date and accurate. This way our viewers can reach you without any confusion.</p>
    </div>
    <div class="col-3 left">
      <div class="col-icons"><img src="<?php echo site_url();?>images/promote-business-icon.jpg" alt="Take Control"></div>
      <h4><strong>Promote</strong> your business</h4>
      <p>Every month more than 600 thousand consumers decide where to eat on Sufrati.com. Claim your restaurant today and start using your Free profile page and if you decide to join one of our membership packages, we'll throw in a free 30-day ad! No credit card or any other obligation required.</p>
    </div>
    <div class="col-3 left">
      <div class="col-icons"><img src="<?php echo site_url();?>images/interact-customers-icon.jpg" alt="Take Control"></div>
      <h4><strong>Interact</strong> with your customers</h4>
      <p>By becoming an official member you can interact with your customers and give them the latest news about your Menus, events, locations and more. Sufrati.com offers you the easiest way to promote your offers directly to millions of potential customers all year round.</p>
    </div>
  </div>
</section>
<div id="footer-container">
  <footer class="wrapper">
    <h4>Proudly featured in</h4>
    <img src="<?php echo site_url();?>images/footer.jpg" title="Sufrati.com was proudly featured in Reauters, Zawya, Ameinfo, Arab news, Destination Jeddah Etc" alt="As Reviewed By Reauters, Zawya, Ameinfo, Arab news, Destination Jeddah Etc." id="featured-logos">
    <div>© 2013 Sufrati.com</div>
  </footer>
</div>
<script>
    $("#loginform").validate({
		messages: {
        User: "*",
        Password: "*"     
    }
	});    
	
	 var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8627357-3']);
  _gaq.push(['_setDomainName', 'sufrati.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
    </script>
</body>
</html>