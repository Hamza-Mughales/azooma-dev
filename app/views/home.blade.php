<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
    <meta property="fb:app_id" content="268207349876072"/> 
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
    <meta property="og:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
    <meta property="og:url" content="<?php echo Azooma::URL();?>">
    <meta property="og:site_name" content="Azooma">
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    <?php 
		$nonav=array('nonav'=>true);
		// dd($featured); 
	?>
    
	@include('inc.header',$nonav)

	{{-- Home Section Start --}}
	<section class="international-home">
		<div class="international-slider owl-carousel owl-theme <?php if($lang == 'ar'){ echo 'owl-rtl'; } ?>">
			<?php
			$i=0;
			foreach ($featured as $feat) {
			?>
			<div class="home-slider">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="home-image">
								<img src="<?php echo upload_url('images/' . $feat['image']) ?>" alt="<?php echo ($lang=="en")?stripcslashes($feat['img_alt']):stripcslashes($feat['img_alt_ar']);?></a>">
							</div>
							<div class="home-content">
								<div class="center international">
									<h1 style="color:#fff" class="wow bounceInUp" data-wow-duration="1s"><?php echo ($lang=="en")?stripcslashes($feat['a_title']):stripcslashes($feat['a_title_ar']); ?> <br>
										<?php // echo Lang::get('messages.home_banner_title2'); ?> 
										<span class="countryname"><?php echo ($lang=="en")?stripcslashes($feat['city_ID']):stripcslashes($feat['city_ID']);?></span>
									</h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>

	</section>
	<script>
		var rtlmode = false;
		<?php if($lang == 'ar'){?>
			rtlmode = true;
		<?php } ?>
		$('.international-slider').owlCarousel({
		loop: false,
		margin: 0,
		nav: false,
		dots: true,
		items: 1,
		autoplay:true,
		autoplayTimeout:5000,
		rtl: rtlmode,
	});
	</script>
	{{-- Home Section End --}}

	{{-- Features Section Start --}}
	<section class="international-features">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title-side">
						<h2 class="wow fadeInDown text-center" data-wow-duration="1s"><?php echo Lang::get('messages.Azooma-Features'); ?> </h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					{{-- Boxes --}}
					<div class="feature-boxes">
						{{-- Box 01 --}}
						<div class="feature-box wow fadeInUp" data-wow-duration="0.6s">
							<div class="box-icon">
								<img src="<?php echo asset('img/icons/booktable.png') ?>" alt="book-table">
							</div>
							<div class="box-title">
								<?php echo Lang::get('messages.BookaTable'); ?> 
							</div>
							<div class="box-description">
								<?php echo Lang::get('messages.BookaTableBox'); ?> 
							</div>
							<a href="#" title="<?php echo Lang::get('messages.BookaTable'); ?>" class="big-main-btn"> <?php echo Lang::get('messages.LetsDine'); ?></a>
						</div>
						{{-- Box 02 --}}
						<div class="feature-box wow fadeInUp" data-wow-duration="1s">
							<div class="box-icon">
								<img src="<?php echo asset('img/icons/places.png') ?>" alt="places">
							</div>
							<div class="box-title">
								<?php echo Lang::get('messages.AzommaPlaces'); ?> 
							</div>
							<div class="box-description">
								<?php echo Lang::get('messages.resturantBox'); ?> 
							</div>
							<a href="#" title="Places" class="big-main-btn"> <?php echo Lang::get('messages.LetsGo'); ?>  </a>
						</div>
						{{-- Box 03 --}}
						<div class="feature-box wow fadeInUp" data-wow-duration="1.5s">
						
							<div class="box-icon">
								<img src="<?php echo asset('img/icons/order.png') ?>" alt="book-table">
							</div>
							<div class="box-title">
								<?php echo Lang::get('messages.Orderfood'); ?>
							</div>
							<div class="box-description">
								<?php echo Lang::get('messages.OrderfoodBox'); ?> 
							</div>
							<a href="#" title="<?php echo Lang::get('messages.OrderfoodBox'); ?> " class="big-main-btn"> <?php echo Lang::get('messages.LetsEat'); ?> </a>
						</div>
						{{-- Box 04 --}}
						<div class="feature-box wow fadeInUp" data-wow-duration="2s">
						
							<div class="box-icon">
								<img src="<?php echo asset('img/icons/orgnize.png') ?>" alt="book-table">
							</div>
							<div class="box-title">
								<?php echo Lang::get('messages.Organizeevent'); ?> 
							</div>
							<div class="box-description">
								<?php echo Lang::get('messages.OrganizeeventBox'); ?> 
							</div>
							<a href="#" title="	<?php echo Lang::get('messages.OrganizeeventBox'); ?>  " class="big-main-btn"> <?php echo Lang::get('messages.LetsParty'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	{{-- Features Section End --}}

	{{-- Explore Section Start --}}
	<section class="international-explore">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title-side justify-content-center">
						<h2 class="wow fadeInDown text-center" data-wow-duration="1s"><?php echo Lang::get('messages.Explore-Azooma'); ?></h2>
					</div>
				</div>
			</div>
			<div class="row boxes">
				{{-- 01 Big Box --}}
				<div class="col-lg-6 col-sm-12">
					<div class="container-fluid" style="padding:0" style="height: 100%">
						<div class="row" style="height: 100%">
							<div class="col-12" style="height: 100%">
									<div class="container-fluid mb-4" style="height: 100%">
									
										<div class="row" style="height: 62%">
									
											<div class="col-lg-12 wow fadeInUp" data-wow-duration="3s">
												<?php 
												
												if(count($countries) > 0 && isset($countries[key($countries) + 1]) ){
													// Get First Country
													reset($countries);
													$firstKey = key($countries);
													$country = $countries[$firstKey];
														?>
												<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#country-<?php echo $country->id; ?>" class="country-box" title="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/flag/'.$country->flag;?>" alt="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
														</div>
														<?php
														$i=0;
														$mycity=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
														foreach ($mycity as $curcity) {
														$localities = MListings::getAllLocalities2($curcity->city_ID);					
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														}
														
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
											
													</div>
												</a>
												<?php }  ?>
											</div>
										</div>
										<div class="row mt-3 two-cites" style="height: 35%">
											{{-- 02 Small Box --}}
											<div class="col-lg-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
												<?php 
													reset($countries);
													$firstKey = key($countries);
													$country = $countries[$firstKey];
													$tcities=$country->cities;
													if(count($tcities)>0){  
														$total=count($tcities); 
														$splitter=round($total/6); 
															$city = $tcities[0];
														
																	
														?>
													<a class="country-box" href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/city/'.$city->city_thumbnail;?>" alt="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>
														</div>
														<?php
														$i=0;
														$localities = MListings::getAllLocalities2($city->city_ID);					
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
													</div>
												</a>
												<?php } ?>
											</div>
											{{-- 03 Small Box --}}
											<div class="col-lg-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
												<?php 
												reset($countries);
													$firstKey = key($countries);
													$country = $countries[$firstKey];
													$tcities=$country->cities;
													if(count($tcities)>0){  
														$total=count($tcities); 
														$splitter=round($total/6); 
															$city = $tcities[1];
																	
																	
														?>
													<a class="country-box" href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/city/'.$city->city_thumbnail;?>" alt="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>
														</div>
														<?php
														$i=0;
														$localities = MListings::getAllLocalities2($city->city_ID);					
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
													</div>
												</a>
												<?php }?>
											</div>
										</div>
									</div>						
							</div>
						</div>
					</div>
				</div>
				{{-- Other Boxes --}}
				<div class="col-lg-6 col-sm-12">
					<div class="container-fluid" style="padding:0" style="height: 100%">
						<div class="row" style="height: 100%">
							<div class="col-12" style="height: 100%">
									<div class="container-fluid mb-4" style="height: 100%">
										<div class="row mb-3 two-cites" style="height: 35%">
											{{-- 02 Small Box --}}
											<div class="col-lg-6 col-sm-12 wow fadeInUp" data-wow-duration="2s">
												<?php 
												if(count($countries) > 0 && isset($countries[key($countries) + 2]) ){
													// Get First Country
													reset($countries);
													$firstKey = key($countries);
													$country = $countries[$firstKey + 2]; {
														?>
												<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#country-<?php echo $country->id; ?>" class="country-box" title="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/flag/'.$country->flag;?>" alt="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
														</div>
														<?php
														$i=0;
														$mycity=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
														foreach ($mycity as $curcity) {
														$localities = MListings::getAllLocalities2($curcity->city_ID);					
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														}
														
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
													</div>
												</a>
												<?php } } ?>
											</div>
											{{-- 03 Small Box --}}
											<div class="col-lg-6 col-sm-12 mb-4 wow fadeInUp" data-wow-duration="2s">
												<?php 
												if(count($countries) > 0 && isset($countries[key($countries) + 3]) ){
													// Get First Country
													reset($countries);
													$firstKey = key($countries);
													$country = $countries[$firstKey + 3]; {
														?>
												<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#country-<?php echo $country->id; ?>" class="country-box" title="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/flag/'.$country->flag;?>" alt="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
														</div>
														<?php
														$i=0;
														$mycity=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
														foreach ($mycity as $curcity) {
														$localities = MListings::getAllLocalities2($curcity->city_ID);					
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														}
														
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
													</div>
												</a>
												<?php } } ?>
											</div>
										</div>
										<div class="row" style="height: 62%">
											{{-- 04 Meduim Box --}}
											<div class="col-lg-12 wow fadeInUp" data-wow-duration="3s">
												<?php 
												if(count($countries) > 0 && isset($countries[key($countries) + 4]) ){
													// Get First Country
													reset($countries);
													$firstKey = key($countries);
													

													$country = $countries[$firstKey + 4]; {
														?>
												<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#country-<?php echo $country->id; ?>" class="country-box" title="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													<div class="box-img">
														<img src="<?php echo Config::get('settings.uploadurl') .'/images/flag/'.$country->flag;?>" alt="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>">
													</div>
													<div class="box-info">
														<div class="box-title">
															<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
														</div>
														<?php
														$i=0;
														$mycity=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail','city_ID')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
														foreach ($mycity as $curcity) {
														$localities = MListings::getAllLocalities2($curcity->city_ID);	
																	
														if(count($localities)>0){
															foreach ($localities as $locality) {
																$i += $locality->total;
																}
															}
														}
														
														?>
														<div class="box-numbers"><?php echo $i ; ?> <?php echo Lang::get('messages.Places'); ?></div>
													</div>
												</a>
												<?php } } ?>
											</div>
										</div>
									</div>						
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- Cities List --}}
			<div class="row mt-4 city-links">
				<button class="big-white-btn mt-4 mb-4 cites-show show" type="button" data-bs-toggle="collapse" data-bs-target="#showcites" aria-expanded="false">
					<?php echo Lang::get('messages.showmore'); ?> <i class="fas fa-angle-down"></i>
				  </button>
				
				<div class="collapse row" id="showcites">
					<hr class="mb-2 mt-2">
					<?php 
					if(count($countries)>0){ foreach ($countries as $country) { $tcities=$country->cities;
						if(count($tcities)>0){  $total=count($tcities); $splitter=round($total/6); $citysplitted=array_chunk($tcities,8);
							foreach ($citysplitted as $cities) { $i = 1;		
							foreach ($cities as $city) {
								$i++;
								if($i < 20){
							?>
							{{-- City Box --}}
							<div class="col-md-2 col-md-4 col-sm-6 col-xs-6">
								<a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
								<div class="city-box">
									{{-- City Info --}}
									<div class="box-info">
										{{-- Title --}}
										<span class="box-title"><?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?></span>
									</div>
								</div>
								</a>
							</div>
					<?php }   } } } } } ?>
				</div>
			</div>
			<script>
				$('.cites-show').click(function(){
					if ($(this).hasClass("show")) {
						$(this).html('	<?php echo Lang::get("messages.showless"); ?> <i class="fas fa-angle-up"></i>');
						$(this).removeClass('show');
					}
					else{
						$(this).html('	<?php echo Lang::get("messages.showmore"); ?> <i class="fas fa-angle-down"></i>');
						$(this).addClass('show');
					}
				});
			</script>
		</div>
	</section>
	{{-- Explore Section End --}}

	{{-- Register Restaurant Section Start --}}
	<section class="rest-reg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title-side">
						<h2 class="wow fadeInDown" data-wow-duration="1s"><?php echo Lang::get('messages.Areyouarestaurantowner'); ?> </h2>
					</div>
				</div>
			</div>
			<div class="row rest-add-section">
				<div class="col-md-6 col-sm-12">
					<img src="<?php echo URL::asset('img/owner.png'); ?>" alt="register restaurant">
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="reg-block">
						<div class="block-title"><?php echo Lang::get('messages.RegisteryourRestaurant'); ?></div>
						<div class="desc"><?php echo Lang::get('messages.RegisteryourRestaurantDec'); ?></div>
						<a href="<?php echo Azooma::URL($city->seo_url);?>/add-restaurant" class="big-main-btn"><?php echo Lang::get('messages.RegisterNow'); ?></a>
					</div>
					<div class="reg-block">
						<div class="block-title"><?php echo Lang::get('messages.FavoriterestaurantnotyetonAzooma'); ?></div>
						<div class="desc"><?php echo Lang::get('messages.RegisteryourRestaurantDec'); ?></div>
						<a href="<?php echo Azooma::URL($city->seo_url);?>/add-restaurant" class="big-main-btn"><?php echo Lang::get('messages.Suggestarestaurant'); ?> </a>
					</div>
				</div>
			</div>
		</div>
	</section>
	{{--  Register Restaurant Section End --}}

		<?php if(count($countries) > 0){
			// Get First Country
			reset($countries);
			// $firstKey = key($countries);
			$i = 0;
			foreach ($countries as $country) {
				$i++;
				if($i == 5) break;
			
		?>
		<div class="modal fade" id="country-<?php echo $country->id; ?>" tabindex="-1" aria-labelledby="<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>" aria-hidden="true" tabindex="-1">
			<div class="modal-dialog" style="max-width: 60%;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <ion-icon name="close-outline"></ion-icon></button>
					</div>
					<div class="modal-body cities-model">
						<?php 

						$tcities=$country->cities;
						if(count($tcities)>0){  $total=count($tcities); $splitter=round($total/6); $citysplitted=array_chunk($tcities,8);
							foreach ($citysplitted as $cities) {
								$i = 0;
								$imagess = array("one.webp", "two.png", "three.png", "four.png", "five.jpg", "sex.png");
								
								foreach ($cities as $city) { $i++;
									$random_image = array_rand($imagess);

																		
								?>
							<a class="country-box" href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
							<div class="box-img">
								<?php
								if ($city->city_thumbnail != "") {?>
								<img src="<?php echo Config::get('settings.uploadurl') .'/images/city/'.$city->city_thumbnail;?>" alt="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
								<?php } else {?>
									<img src="<?php echo Config::get('settings.uploadurl') .'/azooma/cities/'.$imagess[$random_image];?>" alt="<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>">
								<?php } ?>
							</div>
							<div class="box-info">
								<div class="box-title">
									<?php echo $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>
								</div>
								<?php
								$i=0;
								$localities = MListings::getAllLocalities2($city->city_ID);					
								if(count($localities)>0){
									foreach ($localities as $locality) {
										$i += $locality->total;
										}
									}
								?>
								<div class="box-numbers"><?php echo $i; ?> <?php echo Lang::get('messages.Places'); ?></div>
							</div>
						</a>
				<?php } } } else { ?>
					<h4>	<?php echo Lang::get('messages.sorry_no_cities'); ?></h4>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } } ?>
	@include('inc.footer')

</body>
</html>