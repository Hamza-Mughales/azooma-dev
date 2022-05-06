<div class="row restaurants-boxes">
<?php 
if(count($restaurants)>0){
	$gold=$silver=$bronze=$free=array();
	foreach($restaurants as $val){
		if(!isset($nosplitting)){
	        switch($val->rest_Subscription){
	            case 3:
	                $gold[]=$val;
	                break;
	            case 2:
	                $silver[]=$val;
	                break;
	            case 1:
	                $bronze[]=$val;
	                break;
	            case 0:
	                $free[]=$val;
	                break;
	        }
	    }else{
	    	$gold[]=$val;
	    }
    }
    if((!isset($nosplitting))&&$sort=="member"){
        shuffle($gold);
        shuffle($silver);
        shuffle($bronze);
        shuffle($free);
    }
    $type=3;
    $alreadyloaded=array();
    $cityid=$city->city_ID;
    $cuisineid=0;
    $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
    if(count($gold)>0){
	    foreach ($gold as $rest) {
	    	($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
	    	$restlogo=$rest->logo;
	        if($restlogo==""){
	            $restlogo="default_logo.gif";
	        }
			$resbanner = $rest->thephoto;
			$nameID = str_replace(' ', '', $rest->name);
			// echo print_r($rest);
			$likes= MRestaurant::getRestaurantLikeInfostatic($rest->id);
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
		<a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" class="col-md-2 col-md-4 col-sm-6 col-xs-6 gold-box"  id="<?php echo $nameID?>"   >
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
	    $banner1=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
	    if(count($banner1)>0){
	    	$alreadyloaded[]=$banner1->id;
	    	$banner1image=$banner1->image;
			if($lang!="en"&&$banner1->image_ar!=""){
				$banner1image=$banner1->image_ar;
			}
	    ?>
	    <div class="results-ad-seperator result-box">
	    	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner1->id);?>" rel="no-follow">
	    		<img src="<?php echo Azooma::CDN('banner/'.$banner1image,2);?>" width="657" height="50" alt="<?php echo stripcslashes($banner1->title);?>"/>
	    	</a>
	    </div>
	    <?php
		}
	}

    //Silver
    if(count($silver)>0){
    	foreach ($silver as $rest) {
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
		<a href=" <?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" class="col-md-2 col-md-4 col-sm-6 col-xs-6 silver-box"  id="<?php echo $nameID?>" >
		

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
	    $banner2=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
	    if(count($banner2)>0){
	    	$alreadyloaded[]=$banner2->id;
	    	$banner2image=$banner2->image;
			if($lang!="en"&&$banner2->image_ar!=""){
				$banner2image=$banner2->image_ar;
			}
	    ?>
	    <div class="results-ad-seperator result-box">
	    	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner2->id);?>" rel="no-follow">
	    		<img src="<?php echo Azooma::CDN('banner/'.$banner2image,2);?>" width="657" height="50" alt="<?php echo stripcslashes($banner2->title);?>"/>
	    	</a>
	    </div>
	    <?php
		}
    }

    //Bronze
    if(count($bronze)>0){
    	foreach ($bronze as $rest) {
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
				<a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" class="col-md-2 col-md-4 col-sm-6 col-xs-6 bronze-box"  id="<?php echo $nameID?>" >

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
    	$banner3=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
	    if(count($banner3)>0){
	    	$alreadyloaded[]=$banner3->id;
	    	$banner3image=$banner3->image;
			if($lang!="en"&&$banner3->image_ar!=""){
				$banner3image=$banner3->image_ar;
			}
    	?>
    	<div class="results-ad-seperator result-box">
	    	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner3->id);?>" rel="no-follow">
	    		<img src="<?php echo Azooma::CDN('banner/'.$banner3image,2);?>" width="657" height="50" alt="<?php echo stripcslashes($banner3->title);?>"/>
	    	</a>
	    </div>
    	<?php
    	}
    }

    //Free
    if(count($free)>0){
    	$i=0;
    	foreach ($free as $rest) {
    		$i++;
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
    	$type=3;
    	$banner4=Ads::getRandomAd($type,$cityid,$cuisineid,$alreadyloaded);
	    if(count($banner4)>0){
	    	$alreadyloaded[]=$banner4->id;
	    	$banner4image=$banner4->image;
			if($lang!="en"&&$banner4->image_ar!=""){
				$banner4image=$banner4->image_ar;
			}
	    	?>
	    <div class="results-ad-seperator result-box">
	    	<a role="banner" href="<?php echo Azooma::URL('ads/'.$banner4->id);?>" rel="no-follow">
	    		<img src="<?php echo Azooma::CDN('banner/'.$banner4image,2);?>" width="657" height="50" alt="<?php echo stripcslashes($banner4->title);?>"/>
	    	</a>
	    </div>
	    	<?php
	    }
    }
	?>

	 <?php
    // if(isset($paginator)){
    // 	echo $paginator->appends($var)->links();	
    // }
    
}
?>
</div>
