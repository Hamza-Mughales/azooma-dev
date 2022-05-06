<?php
$t=0;
foreach ($userreviews as $review) {
	$t++;
	$username=($review->user_NickName=="")?stripcslashes($review->user_FullName):stripcslashes($review->user_NickName);
	$userimage=($review->image=="")?'user-default.svg':$review->image;
	$checkuseragreed=0;
    if(Session::has('userid')){
        $checkuseragreed=MRestaurant::checkUserAgreed(Session::get('userid'),$review->review_ID);
    }
	?>

<div class="review-box">
	<div class="box-head">
		<?php if($review->user_Status==1){
				?>
		<a class="rest-logo" href="<?php echo Azooma::URL('user/'.$review->user_ID);?>" alt="<?php echo $username;?>">
			<?php }else{
					?>
			<span class="rest-logo">
				<?php
				}	
				?>
				<img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>">
				<?php if($review->user_Status==1){ ?>
		</a>
		<?php }else{	?>
		</span>
		<?php } ?>
		<div class="box-title">
			<h4> <?php if($review->user_Status==1){
					?>
				<a class="author" href="<?php echo Azooma::URL('user/'.$review->user_ID);?>"
					alt="<?php echo $username;?>">
					<?php }else{
						?>
					<span class="pull-left author">
						<?php
					}	
					echo '<span itemprop="reviewer">'.$username.'</span>';
					if($review->user_Status==1){ ?>
				</a>
				<?php }else{	?>
				</span>
				<?php } ?>
				<a href="<?php echo Azooma::URL($city->seo_url.'/review/'.$review->review_ID);?>"
					class="small pull-right normal-text"></a></h4>
					<?php 
					$Rattingavg = 0;
					$userrated=User::checkUserRated($review->user_ID,$rest->rest_ID,$city->city_ID);
					if(count($userrated)>0){ 
						// Rate calc
						$Rattingavg = ($userrated->rating_Food + $userrated->rating_Service + $userrated->rating_Atmosphere + $userrated->rating_Value + $userrated->rating_Variety + $userrated->rating_Presentation ) / 60;
						$Rattingavg = $Rattingavg * 5;
						$Rattingavgloop =  number_format((float)$Rattingavg, 0, '', '');
						$Rattingavg = number_format((float)$Rattingavg, 1, '.', '');
					}
					?>
			<span class="box-rate"><?php echo $review->totalreviews.' Reviews - '.$review->totalratings.' Rattings';?> </span>
		</div>
		<div class="box-right">
			<?php if(isset($Rattingavgloop) && $Rattingavgloop > 0)  {  ?>
				<ul class="stars">
					
				<?php for ($x = 0; $x < $Rattingavgloop; $x++) { ?>
					<li><i class="fas fa-star red"></i></li>
				<?php } ?>

				<?php $Rattingavgloop = 5 - $Rattingavgloop;  for ($x = 0; $x < $Rattingavgloop; $x++) { ?>
					<li><i class="fas fa-star"></i></li>
				<?php } ?>

			</ul>
			<span class="rate-num mt-2"><?php  echo $Rattingavg; ?></span> <?php } ?> - 
			<time itemprop="dtreviewed"
					datetime="<?php echo date('Y-m-d',strtotime($review->review_Date));?>"><?php echo Azooma::Ago($review->review_Date);?></time>
		</div>
	</div>
	<div class="box-content">
		<p class="review">
		<?php
			if(Azooma::isArabic($review->review_Msg)){
				echo stripcslashes($review->review_Msg);
			}else{
				echo htmlspecialchars(html_entity_decode(htmlentities(ucfirst(stripcslashes($review->review_Msg)),6,'UTF-8'),6,"UTF-8"),ENT_QUOTES,'utf-8');
			}
			?>
			</p>
			<?php 
			$userrated=User::checkUserRated($review->user_ID,$rest->rest_ID,$city->city_ID);
			if(count($userrated)>0){ ?>
				<div class="small-text">
					<?php echo Lang::get('messages.food');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Food;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo Lang::get('messages.service');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Service;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo Lang::get('messages.atmosphere');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Atmosphere;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo Lang::get('messages.value');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Value;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo Lang::get('messages.variety');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Variety;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo Lang::get('messages.presentation');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Presentation;?></span>
				</div>
				<?php } ?>
			
	</div>
	<?php if(!Session::has('userid')||(Session::has('userid')&&(Session::get('userid')!==$review->user_ID))){ ?>
		<div class="box-footer">
			<button class="btn btn-light btn-sm review-recommend-btn <?php if($checkuseragreed>0){ echo 'agreed'; } ?>" type="button" data-review="<?php echo $review->review_ID;?>"><span><?php echo $review->upvotes;?></span> <i class="fa fa-heart"></i></button>
		</div>
		<?php } ?>
</div>

<?php } ?>