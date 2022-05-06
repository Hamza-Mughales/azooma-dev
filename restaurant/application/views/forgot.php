<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $sitename; ?>- Forgot Restaurant Login</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css" type="text/css" />
<script type="text/javascript">
    var base="<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url();?>js/new/jquery.js"></script>
<script type="text/javascript" src="<?php echo site_url('js/bootstrap.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('js/bootstrap.min.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/admincommon.js"></script>
</head>
<body class="login">
<div class="main-container">
  
    <div class="main-head">
    
  </div>
  
  <div class="form-container">
   
    
        <div class="login-head">
            <div class="left-pane">
                <h1> <a  href="<?php echo base_url();?>" title="<?php echo $sitename;?>"> <img src="<?php  echo "http://uploads.azooma.co/sufratilogo/".$logo['image']; ?>" alt="<?php echo $sitename;?>"/> </a> </h1>
            </div>
            <div class="login-pane">

            </div>
        </div>
      
      <div class="login-forgot">
       <?php
		if($this->session->flashdata('error')){
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
		}
                if($this->session->flashdata('message')){
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
                  }
		?>
        <div class="title-text"> <span class="logintitle">Restaurant Access - بوابة مطعمك</span> </div>
        <form name="loginform" id="loginform" action="<?php echo base_url();?>home/restpassword" method="post">
          <p>
            <input type="text" name="user_name" id="rest_name" placeholder="User Name - اسم المستخدم " class="input required "  value="" size="20" tabindex="10" />
          </p>
          <p>
            <input type="text" name="user_email" id="user_email" placeholder="Your Email Address - البريد الإلكتروني " class="input required" value="" size="20" tabindex="20" />
          </p>
         
          <p>
            <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
            <input type="hidden" name="rest_id_hdn" id="rest_id_hdn" value="" />
            
            <input type="submit" name="wp-submit" class="submit btn btn-primary" id="wp-submit" value="Submit" tabindex="100" />
            <a class="submit btn btn-inverse" href="<?php echo base_url('home/login');?>" >Cancel</a>
            
          </p>
          
          
          
        </form>
        <script>
    $("#loginform").validate();    
    </script>     
      
    </div>
  </div>
</div>
</body>
</body>
</html>
