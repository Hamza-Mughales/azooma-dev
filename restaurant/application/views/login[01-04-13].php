<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $sitename; ?>- Restaurant Login</title>
<link rel="shortcut icon" href="http://www.sufrati.com/sa/favicon.ico" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/new/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/new/bootstrap-alert.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script>


<script type='text/javascript'>
//var googletag = googletag || {};
//googletag.cmd = googletag.cmd || [];
//(function() {
//var gads = document.createElement('script');
//gads.async = true;
//gads.type = 'text/javascript';
//var useSSL = 'https:' == document.location.protocol;
//gads.src = (useSSL ? 'https:' : 'http:') + 
//'//www.googletagservices.com/tag/js/gpt.js';
//var node = document.getElementsByTagName('script')[0];
//node.parentNode.insertBefore(gads, node);
//})();
</script>

<script type='text/javascript'>
//googletag.cmd.push(function() {
//googletag.defineSlot('/6866964/Sufrati.com-saudi', [560, 90], 'div-gpt-ad-1344948428819-0').addService(googletag.pubads());
//googletag.defineSlot('/6866964/Sufrati_side_banner', [267, 250], 'div-gpt-ad-1346506023410-0').addService(googletag.pubads());
//googletag.pubads().enableSingleRequest();
//googletag.enableServices();
//});
</script>


</head>
<body class="login">
<div class="main-container">
  
    <div class="main-head">
    
  </div>
  
  <div class="form-container">
   
    
        <div class="login-head">
            <div class="left-pane">
                <h1> <a  href="<?php echo base_url();?>" title="<?php echo $sitename;?>"> <img src="<?php if(file_exists($this->config->item('sa_url').'images/'.$logo['image'])){ echo $this->config->item('sa_url');?>images/<?php echo $logo['image']; }else{ echo "http://www.sufrati.com/sa/images/".$logo['image']; } ?>" width="365" height="75" alt="<?php echo $sitename;?>"/> </a> </h1>
            </div>
            <div class="login-pane">

            </div>
        </div>
      <div class="login-inner">
          <?php
		if($this->session->flashdata('error')){
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
		}
                if($this->session->flashdata('message')){
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
                  }
		?>
      <div class="left-pane">
        <ul id="account-features" class="clearfix">
          <li>
            <div class="feature-icon-wrap"> <span class="deals-icon inline-block"></span> </div>
            <h3 class="red">Take Control of Your Information</h3>
            <p class="feature-description">Verified owners and managers can edit their Sufrati.com page instantly to keep their important info up-to-date and accurate. This way our viewers can reach you without any confusion</p>
          </li>
          <li>
            <div class="feature-icon-wrap"> <span class="message-customers-icon inline-block"></span> </div>
            <h3 class="red">Promote Your Business</h3>
            <p class="feature-description">Every month more than 600 thousand consumers decide where to eat on Sufrati.com. Claim your restaurant today and start using your Free profile page and if you decide to join one of our membership packages, we'll throw in a free 30-day ad! No credit card or any other obligation required.</p>
          </li>
          <li>
            <div class="feature-icon-wrap"> <span class="message-customers-icon inline-block"></span> </div>
            <h3 class="red">Interact With Your Customers</h3>
            <p class="feature-description">By becoming an official member you can interact with your customers and give them the latest news about your Menus, events, locations and more. Sufrati.com offers you the easiest way to promote your offers directly to millions of potential customers all year round.</p>
          </li>
        </ul>
        <div id="create-account-button-wrapper"> <a href="<? echo $this->config->item('sa_url').'suggest/'; ?>" class="btn btn-success btn-large">Create your free account now</a> </div>
      </div>
      <div class="login-pane">
          
        <div id="top-banner" role="banner">
            <div id='div-gpt-ad-1344948428819-0' class="banner">
                <script type='text/javascript'>
//                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1344948428819-0'); });
                </script>
            </div>
        </div>
          <div id="login-form">
        <div class="title-text"> <span class="logintitle">Restaurant Access - بوابة مطعمك</span> </div>
        <form name="loginform" id="loginform" class="left" action="<?php echo base_url();?>home/login_form_submit" method="post">
          <p>
            <input type="text" name="User" id="user_login" placeholder="Username - اسم المستخدم" class="input required" value="" size="20" tabindex="10" />
          </p>
          <p>
            <input type="password" name="Password" id="user_pass" placeholder="Password - كلمة السر" class="input required" value="" size="20" tabindex="20" />
          </p>
          <p>
            <select class="chzn-select" name="language" id="language" style="width:180px;">
              <option value="0">English - الإنجليزية</option>
              <option value="1">Arabic - العربية</option>
            </select>
              <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
            <input type="submit" name="wp-submit" class="submit btn btn-primary" id="wp-submit" value="Login - دخول" tabindex="100" />
          </p>
          <p class="clear"> <a class="submit clear" href="<?php echo base_url();?>home/forgot" >Forgot Password - نسيت كلمة المرور</a> </p>
          
          </div>   
        </form>
        
      </div>
    </div>
  </div>
    <script>
    $("#loginform").validate();    
    </script>     
      
</div>
</body>
</body>
</html>
