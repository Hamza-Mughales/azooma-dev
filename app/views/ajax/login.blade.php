{{-- Start Login Modal --}}
<div class="modal" id="login-modal-main" tabindex="-1" aria-labelledby="LoginModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
		
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?php echo Lang::get('messages.connect_with_azooma');?></h5>
			<button type="button"  class="btn-close sufrati-close-popup" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
			</div>
		<div class="modal-body login-model">
			<div class="login-block show">
				<div class="head">
					<h2><?php echo Lang::get('messages.login');?> </h2>
					<span><?php echo Lang::get('messages.dont_have_an_account');?> <a href="#" class="register-same-model pink"><?php echo Lang::get('messages.register');?></a></span>
				</div>
				<form class="login-popup-form" id="login-form" action="<?php echo Azooma::URL('login/l');?>" method="post">
					<div class="form-group row">
						<input type="email" class="form-control" name="user-email" id="user-email" placeholder="<?php echo Lang::get('messages.email_address');?>"/>
					</div>
					<div class="form-group row">
						<input type="password" class="form-control" name="user-password" id="user-password" placeholder="<?php echo Lang::get('messages.password');?>"/>
					</div>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group d-flex justify-content-between" id="remember-me-container">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" value="1" checked>
							<label class="form-check-label" for="rememberme">
								<?php echo Lang::get('messages.remember_me');?>
							</label>
						</div>
						<a class="text-color" href="javascript:void(0);" id="forgot-password-link" title="<?php echo Lang::get('messages.forgot_password');?>">
							<?php echo Lang::get('messages.forgot_password');?>
						</a>
					</div>
					<div class="form-group row">
						<input class="btn btn-light big-main-btn" id="login-button" type="submit" value="<?php echo Lang::get('messages.login');?>" />

					</div>
				</form>
			</div>
			<div class="register-block hide">
				<div class="col-md-12 reg-con">
					<div class="head">
						<h2><?php echo Lang::get('messages.register');?></h2>
						<span class="register-subtitle"><?php echo Lang::get('messages.already_member');?> 
							<a class="login-same-model pink" href="javascript:void(0);">
								<?php echo Lang::get('messages.login');?>
							</a></span>
					</div>
					{{-- Register Form --}}
					<form class="register-form" id="register-form" action="<?php echo Azooma::URL('login/r');?>" method="post">

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
							<div class="spinner-grow spin-load" id="register-load-last" role="status" style="display: none;margin:0 auto; color:#EE5337">
								<span class="visually-hidden">Loading...</span>
							</div>
							<button class="big-main-btn" id="register-form-final" style="width: 100%"><?php echo Lang::get('messages.register');?></button>
						</div>
					</form>
				</div>
			</div>

			<div class="forget-block hide">
				<div class="head">
					<h2>	<?php echo Lang::get('messages.forgot_password');?></h2>
				</div>
				<form id="forgot-form" action="<?php echo Azooma::URL('forgot');?>" method="post" >
					<div class="form-group row">
						<p class="help-block"><?php echo Lang::get('messages.forgot_helper');?></p>
					</div>
					<div class="form-group row">
						<input type="email" class="form-control" name="forgotemail" id="forgotemail" placeholder="<?php echo Lang::get('messages.email');?>"/>
					</div>	
					<div class="form-group d-flex jusify-content-between" >
						<div id="reset-password-cnt">
							<input class="btn btn-light login-popup-button big-main-btn" id="forgot-button" type="submit" value="<?php echo Lang::get('messages.reset');?>" />
						</div>
						<a href="javascript:void(0);" id="back-to-login" class="btn"><?php echo Lang::get('messages.back_to_login');?></a>
					</div>
				</form>
			</div>
			
			<div class="form-login-options">
				<div class="form-hr-or">
					<span>OR</span>
				</div>
				{{-- <a href="javascript:void(0);" class="big-trans-btn facebook-login-btn">
					<i class="fa fa-facebook"></i> <?php echo Lang::get('messages.connect_facebook');?>
				</a> --}}
				<button id="connect-google-btn" class="big-trans-btn" style="margin-bottom: 1rem">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path style="fill:#FBBB00;" d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
	c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
	C103.821,274.792,107.225,292.797,113.47,309.408z"/>
<path style="fill:#518EF8;" d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
	c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
	c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"/>
<path style="fill:#28B446;" d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
	c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
	c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"/>
<path style="fill:#F14336;" d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
	c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
	C318.115,0,375.068,22.126,419.404,58.936z"/>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
  <?php echo Lang::get('messages.connect_with_google');?>
				</button>
			
			</div>
		</div>
	</div>
	</div>
</div>
{{-- End Login Modal --}}
