<?php 
$lang= Config::get('app.locale');
//Subscribe newsletter
//Follow users
//Like restaurants
//trending restaurants
//popular restaurants
//Vote 
//etc
?>

<div class="user-side">
<?php if(Session::has('userid')){
	if(Session::has('fbid')){
?>

<?php } } ?>
<?php
$cityid=1;
if(Session::has('sfcity')){
	$cityid=Session::get('sfcity');
}
$city=DB::table('city_list')->select('city_ID','seo_url','country')->where('city_ID',$cityid)->first();
$latestpoll=MPoll::getLatestPoll($city->country);
$checkuservoted=null;
if(count($latestpoll)>0){
	$checkuservoted=MPoll::checkUserVoted($latestpoll->id);	
}
if(count($latestpoll)>0&&count($checkuservoted)<=0){
	$polloptions=MPoll::getOptionsWithResult($latestpoll->id);
	?>
	<div class="right-col-block">
		<div class="right-col-head">
			<a href="<?php echo Azooma::URL('poll/'.$latestpoll->id);?>" title="<?php echo ($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar); ?>">
				<?php echo ($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar); ?>
			</a>
		</div>
		<div class="right-col-desc">
			<form action="<?php echo Azooma::URL('poll/'.$latestpoll->id);?>" method="post" class="poll-vote-form">
				<?php 
				if(count($polloptions)>0){
					foreach ($polloptions as $option) {
						?>
						<div class="radio">
							<label>
								<input name="polloption" value="<?php echo $option->id;?>" type="radio" /> <?php echo ($lang=="en")? stripcslashes($option->field):stripcslashes($option->field_ar); ?>
							</label>
						</div>
						<?php
					}
				}
				?>
				<div class="btn-group">
					<button type="submit" id="col-poll-submit-btn" class="btn btn-danger"><?php echo Lang::get('messages.add_vote');?></button> 
					<a href="<?php echo Azooma::URL('poll/'.$latestpoll->id.'?results=1#n');?>" class="btn btn-light"><?php echo Lang::get('messages.view_results') ?></a>
				</div>
			</form>
		</div>
	</div>

	<?php
}else{
	//restaurant like suggestions or followsuggestions
	if(!isset($userprofile)){
	$k=rand(1,2);
	$userid=0;
	if(Session::has('userid')){
		$userid=Session::get('userid');
	}

	$restaurantsuggestions=User::likeSuggestions($userid);
	if(count($restaurantsuggestions)>0){
	?>
	<div class="user-profile-side">
		<h2> <?php echo Lang::get('messages.you_might_like');?></h2>
		<ul class="res">
			<?php
				foreach ($restaurantsuggestions as $rest) {
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
				$restlogo=($rest->rest_Logo=="")?'default_logo.gif':$rest->rest_Logo;
				$kcity=MGeneral::getPossibleCity($rest->rest_ID);
				$ratinginfo= MRestaurant::getRatingInfo($rest->rest_ID);
				if(count($ratinginfo)>0){
					$ratinginfo=$ratinginfo[0];
					if($ratinginfo->total>0){
						$totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
					}else{
						$totalrating=0;
					}
				}
				?>

			<li class="row">
				<div class="col-3">
					<a class="rest-logo" href="<?php echo Azooma::URL($kcity->seo_url.'/'.$rest->seo_url);?>"
						title="<?php echo $restname;?>">
						<img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>"
							width="60" height="60">
					</a>
				</div>
				<div class="col-6">
					<a class="title" href="<?php echo Azooma::URL($kcity->seo_url.'/'.$rest->seo_url);?>"
						title="<?php echo $restname;?>">
						<?php echo $restname;?>
					</a>
					<span
						class="category"><?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?></span>
					<span class="rate"> <?php 
							if(count($ratinginfo)>0){
								?>
						<div class="rating-stars">
							<?php 
								$k=5-round($totalrating/2);
								for($i=0;$i<round($totalrating/2);$i++){
									echo '<i class="fa fa-star pink"></i>&nbsp;&nbsp;';
								}
									for($i=0;$i<$k;$i++){
										echo '<i class="fa fa-star"></i>';
										if($i<($k-1)){
											echo '&nbsp;&nbsp;';
										}
									}
									?>
						</div>

						<?php
								}?> <?php echo '<span id="total-rating-value" itemprop="ratingValue">'.($totalrating/2).'</span>';?></span>
				</div>
				<div class="col-3">
					<?php
						  if(Session::has('userid')){
						  $checklike= User::getUserLikesCustom($userid, $rest->rest_ID);
						  if(count($checklike) > 0){

						  ?>
					<button class="big-trans-btn rest-like-btn mini-like-btn liked"
						data-rest="<?php echo $rest->rest_ID;?>">
						<i class="far fa-thumbs-down"></i> <?php echo Lang::get('messages.liked');?>
					</button>
					<?php } else { ?>
					<button class="big-trans-btn rest-like-btn mini-like-btn like"
						data-rest="<?php echo $rest->rest_ID;?>">
						<i class="far fa-thumbs-up"></i> <?php echo Lang::get('messages.like');?>
					</button>
					<?php } } else { ?>
					<button class="big-trans-btn rest-like-btn mini-like-btn like"
						data-rest="<?php echo $rest->rest_ID;?>">
						<i class="far fa-thumbs-up"></i> <?php echo Lang::get('messages.like');?>
					</button>
					<?php }?>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php }

		$followsuggestions=User::followSuggestions($userid);
		if(count($followsuggestions)>0){
		?>
		<div class="user-profile-side">
			<h2> <?php echo Lang::get('messages.suggested_users');?></h2>
			<ul class="res">
				<?php
					foreach ($followsuggestions as $user) {
						$username=($user->user_NickName!='')?stripcslashes($user->user_NickName):stripcslashes($user->user_FullName);
						$userimage=($user->image=="")?'user-default.svg':$user->image;
					?>
	
				<li class="row">
					<div class="col-3">
						<a class="rest-logo" href="<?php echo Azooma::URL('user/'.$user->user_ID);?>" title="<?php echo $username;?>">
	                        <img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>" width="60" height="60">
	                    </a>
					</div>
					<div class="col-6">
						<a class="title" href="<?php echo Azooma::URL('user/'.$user->user_ID);?>" title="<?php echo $username;?>">
							<?php echo $username;?>
						</a>
						<span class="category"><?php  echo '<span data-total-followers'.$user->user_ID.'="'.$user->followers.'">'.$user->followers.'</span> '.Lang::get('messages.followers').', '.$user->following.' '.Lang::get('messages.following'); ?></span>

	                       
					</div>
					<div class="col-3">
						<button class="big-trans-btn btn btn-danger follow-btn" data-following="0" data-user="<?php echo $user->user_ID;?>">
							<?php echo Lang::get('messages.follow');?>
						</button>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php
		}
	
	}
}
?>
<div class="right-col-spacing-container">
</div>
<?php
if(!isset($nobanner)){
$alreadyloaded=array();
if(isset($currentcuisineid)){
	$cuisineid=$currentcuisineid;
}else{
	$cuisineid=0;
}
$type=2;
$cityid=0;
if(Session::has('sfcity')){
	$cityid=Session::get('sfcity');
}
$banner1=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
if(count($banner1)>0){
	$alreadyloaded[]=$banner1->id;
	$banner1image=$banner1->image;
	if($lang!="en"&&$banner1->image_ar!=""){
		$banner1image=$banner1->image_ar;
	}
?>
<div data-type="ad-banner" data-size="245x125" role="banner" class="put-border right-banner">
	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner1->id);?>" rel="no-follow">
		<img src="<?php echo Azooma::CDN('banner/'.$banner1image,2);?>" alt="<?php echo stripcslashes($banner1->title);?>"/>
	</a>
</div>
<?php 
$banner2=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
if(count($banner2)>0){
	$alreadyloaded[]=$banner2->id;
	$banner2image=$banner2->image;
	if($lang!="en"&&$banner2->image_ar!=""){
		$banner2image=$banner2->image_ar;
	}
 ?>
<div data-type="ad-banner" data-size="245x250" role="banner" class="put-border right-banner">
	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner2->id);?>" rel="no-follow">
		<img src="<?php echo Azooma::CDN('banner/'.$banner2image,2);?>" alt="<?php echo stripcslashes($banner2->title);?>"/>
	</a>
</div>
<?php
$banner3=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
if(count($banner3)>0){
	$alreadyloaded[]=$banner3->id;
	$banner3image=$banner3->image;
	if($lang!="en"&&$banner3->image_ar!=""){
		$banner3image=$banner3->image_ar;
	}
	?>
<div data-type="ad-banner" data-size="245x125" role="banner" class="put-border right-banner">
	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner3->id);?>" rel="no-follow">
		<img src="<?php echo Azooma::CDN('banner/'.$banner3image,2);?>" alt="<?php echo stripcslashes($banner3->title);?>"/>
	</a>
</div>
<div class="right-col-spacing-container">
</div>
	<?php
	$banner4=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
if(count($banner4)>0){
	$alreadyloaded[]=$banner4->id;
	$banner4image=$banner4->image;
	if($lang!="en"&&$banner4->image_ar!=""){
		$banner4image=$banner4->image_ar;
	}
	?>
<div data-type="ad-banner" data-size="245x125" role="banner" class="put-border right-banner">
	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner4->id);?>" rel="no-follow">
		<img src="<?php echo Azooma::CDN('banner/'.$banner4image,2);?>" alt="<?php echo stripcslashes($banner4->title);?>"/>
	</a>
</div>
	<?php
} //banner4
} //banner3
 } //banner2
} //banner1
} //banner
?>

</div>

