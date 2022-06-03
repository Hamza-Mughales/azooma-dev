<!DOCTYPE html>
<html >
    <head>
<html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> <?php echo $sitename; ?> - Login</title>
        
        <style>
            #particles-js {
                background-image: url(<?= asset('img/login02.jpg') ?>);
                background-position: bottom;
                background-size: cover;
            }
            .alert-error {
                font-size: 12px;
                color: #c83b35;
                max-width: 80%;
                margin: auto;
                margin-top: -54px;
            }
        </style>
        <link href="<?= asset(css_path() . 'css/font-awesome.min.css' )?>"  rel="stylesheet">
        <link href="<?= asset(css_path() . 'login.css?2' )?>"  rel="stylesheet">
        <link rel="shortcut icon" href="{{url('favicon_en.png')}}" type="image/png"/>      

    </head>
    
    <body id="particles-js"></body>
    <div class="animated bounceInDown">
        <div class="container">
            <span class="error animated tada" id="msg"></span>
            <?php
                echo $errors->all() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>
			    <strong>Oh snap!</strong> please add all fields.</div>' : '';
            ?> 
            <form name="loginform" id="loginform" class="box" action="" method="post">
                
                <h4>
                    <img width="160" src="<?= asset('img\logo.png' )?>" alt="">
                </h4>
                <h5><?= __('Login to your account') ?>.</h5>
                <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<div class="alert alert-error"><strong>' . $message . '</strong></div>';
                    }
                ?>
                <input type="text" value="<?=isset($_COOKIE['remember_me_user_name']) ? $_COOKIE['remember_me_user_name'] :""?>" name="User" placeholder="<?= __('Username')?>" value="<?php echo Input::old('User'); ?>" required>
                <i class="typcn typcn-eye" id="eye"></i>
                <input type="password" name="Password" placeholder="Passsword" id="Password" value="<?=isset($_COOKIE['remember_me_password']) ? $_COOKIE['remember_me_password'] :""?>" required>
           
                 <label>
                    <input name="remember_me" value="on" type="checkbox" <?=isset($_COOKIE['remember_me']) && $_COOKIE['remember_me']=='on' ? "checked":""?> >
                    <span></span>
                    <small class="rmb"><?= __('Remember me')?></small>
                </label> 
                {{-- <a href="#" class="forgetpass"><?= __('Forget Password?')?></a> --}}
                <input type="submit" value="Sign in" class="btn1" style="margin-top: 34px">
            </form>
        </div> 
        <div class="footer">
        <span>Made with <i class="fa fa-heart pulse"></i> By Azooma</a></span>
        </div>
    </div>

</html>
