<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
    echo $metastring;
    }
    ?>
</head>
<body <?php if($lang=="ar"){?>class="arabic" <?php } ?>itemscope itemtype="http://schema.org/WebPage">
    <?php $nonav=array('nonav'=>true); ?>
    @include('inc.header',$nonav)


{{-- Register Page --}}
<section class="register-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 reg-con">
                <h2>Sign Up</h2>
                <span class="register-subtitle"><?php echo Lang::get('messages.already_member');?> 
                    <a class="login-link" href="javascript:void(0);">
                        <?php echo Lang::get('messages.login');?>
                    </a></span>
                {{-- Register Form --}}
                <form class="register-form" id="register-form" action="<?php echo Azooma::URL('login/checkemail');?>" method="post">
                    <div class="form-group row">
                        <input type="text" class="form-control" name="registername" id="registername" placeholder="<?php echo Lang::get('messages.fullname');?>"/>
                    </div>
                    <div class="form-group row">
                        <input type="email" class="form-control" name="registeremail" id="registeremail" placeholder="<?php echo Lang::get('messages.email_address');?>"/>
                    </div>
                    <div class="form-group row">
                        <input type="text" class="form-control" name="registerphone" id="registerphone" placeholder="<?php echo Lang::get('messages.phone_number');?>"/>
                    </div>
                    
                    <script src="<?php echo URL::asset('js/intlTelInput.min.js');?>"></script>
                    <script>
                        $("#registerphone").intlTelInput({
                            hiddenInput: "full_phone",
                            utilsScript: "https://intl-tel-input.com/node_modules/intl-tel-input/build/js/utils.js"
                        });
                    </script>
                    <div class="form-group row">
                        <input type="password" class="form-control" name="registerpassword" id="registerpassword" placeholder="<?php echo Lang::get('messages.password');?>"/>
                    </div>
                    <div class="overflow form-group" id="label-bottom-margin">
                        <label for="agreeprivacy" class="small">
                            <?php echo Lang::get('messages.signing_up_agree');?> 
                            <a href="<?php echo Azooma::URL('privacy-terms');?>" title="<?php echo Lang::get('messages.privacy_policy');?>"><?php echo Lang::get('messages.privacy_policy');?></a>
                            <?php echo Lang::get('messages.and');?> 
                            <a href="<?php echo Azooma::URL('privacy-terms');?>" title="<?php echo Lang::get('messages.terms_conditions');?>"><?php echo Lang::get('messages.terms_conditions');?></a>
                        </label>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group row">
                        <div class="spinner-grow spin-load" id="register-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        <button class="big-main-btn" id="register-button-first"><?php echo Lang::get('messages.register');?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-12 mobile-valid" style="display: none">
                <div class="captcha">
                <h4 class="mb-2">Please verify that you are human</h4>
                 <div id="recaptcha-container" style="display: flex; justify-content: center;"></div>
                 </div>
                 <div id="resend">
                    {{-- <div id="myTimer"></div>
                    <button type="button" id="#resendcode-register">Resend</button>
                  </div> --}}
               
                <div id="successAuth" style="display: none;text-align:center"></div>
                <div class="alert alert-danger" id="error" style="display: none;"></div>
                <form class="register-form" id="register-form-final" action="<?php echo Azooma::URL('login/r');?>" method="post" style="display:none">
                    <div class="form-group row">
                        <input type="text" id="verification" class="form-control" placeholder="Verification code">
                    </div>
                    <div class="form-group row">
                        <div class="spinner-grow spin-load" id="register-load-last" role="status" style="display: none;margin:0 auto; color:#EE5337">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button class="big-main-btn" id="register-button-finish"><?php echo Lang::get('messages.register');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    window.onload = function () {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

   
</script>
@include('inc.footer')
<script type="text/javascript" >
require(['popular'],function(){});
</script>

</body>
</html>