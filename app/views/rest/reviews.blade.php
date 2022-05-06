
	<div class="sufrati-white-box inner-padding put-border">
		<h2 class="rest-page-second-heading">
			<?php echo $restname.' '.Lang::get('messages.critics_reviews').' ('.count($criticreviews).')';?>
		</h2>
		<?php 
		$i=0;
		foreach ($criticreviews as $criticreview) { $i++;
			?>
			<div class="review-box review-box-imp">
				<div class="box-head">
					<div class="box-right">
						<?php echo Lang::choice('messages.by',1).' <span itemprop="reviewer">'.$criticreview->author.'</span>';?>
					</div>
				</div>
				<div class="box-content">
					<p class="review"><span itemprop="summary"><?php echo mb_substr(strip_tags(htmlspecialchars_decode(stripslashes($criticreview->description))),0,140,'UTF-8');?>....</span> <a itemprop="url" href="<?php echo Azooma::URL('blog/'.$criticreview->url);?>" title="<?php echo ($lang=="en")?stripcslashes($criticreview->name):stripcslashes($criticreview->nameAr);?>"><?php echo Lang::get('messages.read_more');?></a></p>
				</div>
				
			</div>


		
			<?php
		}
		?>
	</div>

<?php 
if(count($userreviews)>0){
	?>
<h2>	<?php echo $restname.' '.Lang::get('messages.reviews').' ('.$totalreviews.')';?></h2>
<?php $reviewhelper=array(
	'userreviews'=>$userreviews,
);  ?>
@include('rest.helpers._reviews',$reviewhelper)
<?php if($totalreviews>count($userreviews)){ ?>
	<div id="review-morebtn-cnt">
	    <button id="load-more-reviews" data-rest="<?php echo $rest->rest_ID;?>" data-loaded="<?php echo count($userreviews);?>" data-total="<?php echo $totalreviews;?>" data-scenario="reviews" class="big-trans-btn load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
	</div>
	<?php  
	}
	?>
<?php }  ?>

