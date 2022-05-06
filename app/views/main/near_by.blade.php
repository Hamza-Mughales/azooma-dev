<?php 
if(count($restaurants)>0){
	$gold=$silver=$bronze=$free=array();
    $type=1;
    $alreadyloaded=array();
    $cityid=$city->city_ID;
    $cuisineid=0;
    $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
    if(count($restaurants)>0){
	    foreach ($restaurants as $rest) {
	    	($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
			$restlogo=$rest->logo;
	        if($restlogo==""){
	            $restlogo="default_logo.gif";
	        }
			$resbanner = $rest->thephoto;
			$likes= MRestaurant::getRestaurantLikeInfostatic($rest->id);
			$nameID = str_replace(' ', '', $rest->name);
			$ratinginfo= MRestaurant::getRatingInfo($rest->id);
			$priceGet = MRestaurant::GetPriceRange($rest->id);
				if(count($ratinginfo)>0){
					$ratinginfo=$ratinginfo[0];
					if($ratinginfo->total>0){
						$totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
					}else{
						$totalrating=0;
					}
				}
	    	?>
			
				{{-- Resturant Box Start --}}
				<a href=" <?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" class="col-md-2 col-md-4 col-sm-6 col-xs-6 free-box"  id="<?php echo $nameID?>" >

					<div class="resturant-box">
						<input type="text" value="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" class="resturl" style="display: none">

						<div class="box-img">
							<?php if($resbanner!=""){ ?>
								<img   class="rest-banner" src="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" alt="<?php echo $restname;?>"/>
								<input type="text" value="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" class="rest_image" style="display: none">
								<?php } else { ?>
									<div class="rest-default-img"></div>
									<input type="text" value="<?php echo Config::get('settings.uploadurl') .'/azooma/cities/two.png';?>" class="rest_image" style="display: none">
								<?php } ?>
							<div class="logo">
								<img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
							</div>
							<?php  if (property_exists($rest, 'latitude') && property_exists($rest, 'longitude')) { ?>
							<input type="number" value="<?php echo $rest->latitude ?>" class="laten" style="display: none">
							<input type="number" value="<?php echo $rest->longitude ?>" class="langen" style="display: none">
							<?php } ?>
							<input type="text" value="<?php echo $restname ?>" class="restname" style="display: none">
						</div>
						<div   class="box-details">
							<div class="box-info">
								<div class="info-title">
									<h3><?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?></h3>
									
								</div>
								<div class="info-rate">
									<?php 
									if(count($ratinginfo)>0){
										?>
									<div class="rating-stars">
										<i class="fa fa-star pink"></i>
									</div>
		
									<?php
										}?>  <?php echo '<span class="total-rating" itemprop="ratingValue">'.($totalrating/2).' </span> ('.$ratinginfo->total.')' ; ?>
								</div>
								<div class="info-type">
									<?php echo Azooma::LangSupport($rest->class_category);?></b>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->type):stripcslashes($rest->typeAr);?>
									<input type="text" value="	<?php echo Azooma::LangSupport($rest->class_category);?></b>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->type):stripcslashes($rest->typeAr);?>" class="rest_info_type" style="display: none">

								</div>
								<?php echo ($lang=="en")?stripcslashes($rest->location.', '.$rest->district):stripcslashes($rest->locationAr.', '.$rest->districtAr); echo ' ('.round($rest->distance,1).'kms)' ?>

							
							</div>
							<div class="box-icon">
								<div class="likes-number">
									<i class="fa fa-heart"></i> <?php echo $likes[0]->total;?>
								</div>
									<span class="priceRange"><?php echo azooma::langsupport($priceGet->price_range);?></span>
										
										<input type="text" value="<?php echo azooma::langsupport($priceGet->price_range);?>" class="rest_priceRange" style="display: none">

							</div>
						</div>
					</div>
									</a>
			{{-- Resturant Box End --}}

	    	<?php
	    	}
	    }
	}else{
		?>
		<h2>
			<?php echo Lang::get('messages.no_restaurant_found_near_you_in',array('name'=>$cityname));?>
		</h2>
		<div>
			<a href="<?php echo Azooma::URL($city->seo_url.'/add-restaurant');?>" class="big-trans-btn"><?php echo Lang::get('messages.add_restaurant');?></a>
		</div>
		<?php
	}