<div class="register-step-3" id="step3-container">
	<div class="row steps-header">
		<div class="col-md-6 col-sm-12">
			<h2>All Restaurants</h2>
		</div>
		<div class="col-md-6 col-sm-12">
			<button type="submit" class="big-main-btn user-step3-btn step-btn mb-4"><?php echo Lang::get('messages.next');?></button>
		</div>
	</div>
		<div class="row">
			<?php 
			if(count($restaurants)>0){
				foreach ($restaurants as $rest) {
					$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
					$restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
					?>
					<div class="col-md-2 col-md-4 col-sm-6">
						<div class="rest-logo">
							<img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>">
							<button class="rest-like-btn mini-like-btn btn btn-block" data-rest="<?php echo $rest->rest_ID;?>">
								<i class="far fa-thumbs-up"></i> <?php echo Lang::get('messages.like');?>
							</button>
						</div>
						<div class="rest-info">
							<a class="info-title" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
								<b><?php echo $restname;?></b>
							</a>
							<div class="info-likes">
								<?php echo ($rest->totallikes>0)?'<span id="liked-persons-'.$rest->rest_ID.'">'.$rest->totallikes.'</span>':'';echo ' '.Lang::choice('messages.people_likes_this',$rest->totallikes);?> 
							</div>
							<div>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
</div>