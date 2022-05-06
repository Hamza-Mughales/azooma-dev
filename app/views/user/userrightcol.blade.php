<div class="right-col-block">
	<?php
	//Like and Follow suggestions
	$userid=0;
	if(Session::has('userid')){
		$userid=Session::get('userid');
	}
	$restaurantsuggestions=User::likeSuggestions($userid);
	$followsuggestions=User::followSuggestions($userid);
	if(count($restaurantsuggestions)>0){
	?>
	<div class="right-col-head">
		<?php echo Lang::get('messages.you_might_like');?>
	</div>
	<div class="right-col-desc">
		<?php
		 	foreach ($restaurantsuggestions as $rest) {
			$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
			$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
			$kcity=MGeneral::getPossibleCity($rest->rest_ID);
			?>
			<div class="overflow right-list-col">
                <div class="pull-left list-col-left">
                    <a class="rest-logo" href="<?php echo Azooma::URL($kcity->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
                        <img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>" width="60" height="60">
                    </a>
                </div>
                <div class="pull-left list-col-right">
                    <div>
                        <a class="bold" href="<?php echo Azooma::URL($kcity->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
                            <?php echo $restname;?>
                        </a>
                    </div>
                    <div>
                    	<div class="content-desc">
                    		<?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?>
                    	</div>
                        <button class="rest-like-btn btn" data-rest="<?php echo $rest->rest_ID;?>">
		    				<?php echo Lang::get('messages.like');?>
		    			</button>
                    </div>
                </div>
            </div>
			<?php
		}
		?>
		<div class="right-col-spacing-container"></div>
		<div class="overflow">
			<a class="btn btn-sm btn-light" href="<?php echo Azooma::URL('likesuggestions');?>"><?php echo Lang::get('messages.view_more');?></a>
			<a class="pull-right btn btn-sm btn-light" href="<?php echo Azooma::URL('userpreference');?>"><?php echo Lang::get('messages.change_preferences');?></a>
		</div>
	</div>
	<div class="right-col-spacing-container"></div>
	<?php }
	if(count($followsuggestions)>0){
		?>
	<div class="right-col-head">
		<?php echo Lang::get('messages.suggested_users');?>
	</div>
	<div class="right-col-desc">
		<?php
		 	foreach ($followsuggestions as $user) {
		 		$username=($user->user_NickName!='')?stripcslashes($user->user_NickName):stripcslashes($user->user_FullName);
		 		$userimage=($user->image=="")?'user-default.svg':$user->image;
		 		?>
		 		<div class="overflow right-list-col">
	                <div class="pull-left list-col-left">
	                    <a class="rest-logo" href="<?php echo Azooma::URL('user/'.$user->user_ID);?>" title="<?php echo $username;?>">
	                        <img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>" width="60" height="60">
	                    </a>
	                </div>
	                <div class="pull-left list-col-right">
	                    <div>
	                        <a class="bold" href="<?php echo Azooma::URL('user/'.$user->user_ID);?>" title="<?php echo $username;?>">
	                            <?php echo $username;?>
	                        </a>
	                    </div>
	                    <div>
	                    	<div class="content-desc">
	                    		<?php  echo '<span data-total-followers'.$user->user_ID.'="'.$user->followers.'">'.$user->followers.'</span> '.Lang::get('messages.followers').', '.$user->following.' '.Lang::get('messages.following'); ?>
	                    	</div>
	                        <button class="btn btn-danger follow-btn" data-following="0" data-user="<?php echo $user->user_ID;?>">
			    				<?php echo Lang::get('messages.follow');?>
			    			</button>
	                    </div>
	                </div>
	            </div>
		 		<?php
		 	}
		?>
		<div class="right-col-spacing-container"></div>
		<div class="overflow">
			<a class="btn btn-sm btn-light" href="<?php echo Azooma::URL('usersuggestions');?>" title="<?php echo Lang::get('messages.view_more');?>"><?php echo Lang::get('messages.view_more');?></a>
		</div>
	</div>	
	<div class="right-col-spacing-container"></div>
		<?php
	}
	?>
</div>