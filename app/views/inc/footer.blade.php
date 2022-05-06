<?php

if(Session::get('sfcity')!=null){
	$cityid=Session::get('sfcity');
	$city=DB::select('SELECT city_Name,city_Name_ar,seo_url,country FROM city_list WHERE city_Status=1 AND city_ID='.$cityid.' LIMIT 1');
	if(count($city)>0){
		$cityurl=$city[0]->seo_url;
		$cityname=(Config::get('app.locale')=="en")?stripcslashes($city[0]->city_Name):stripcslashes($city[0]->city_Name_ar);
	}
	$city = $city[0];
}else{

	if(isset($_COOKIE['mycountry'])) {
	 $selectedCountry = $_COOKIE['mycountry'];
	 $mycountry=DB::table('aaa_country')->select('id','flag','name','nameAr')->where('name',$selectedCountry)->get();
        $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$mycountry[0]->id)->orderBy('city_Name','asc')->get();
        $defaultCity = [];
        $defualt_seo = "";
		$city= $mycities[0];
		$cityurl = $city->seo_url;
		$city->country = $mycountry[0]->id;
	}
	else{
	$city=null;
	}
}
?>
<section class="footer">
	<div class="container">
		<div class="row mb-4">
			<div class="col-lg-6 col-xs-6">
				{{-- Logo --}}
				<a class="footer-logo">
					<?php 
       				 $logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
						if(count($logo)>0){
						$logoimage=($lang=="en")?$logo->image:$logo->image_ar;
						?>
						     <a class="navbar-brand" href="<?php echo Azooma::URL($cityurl);?>">
						 <img
						 src="<?php echo Azooma::CDN('sufratilogo/'.$logoimage);?>" height="50" width="190"
						 alt="<?php echo Lang::get('messages.azooma');?>" /> </a>
						<?php } ?></a>
				</div>
				<div class="col-lg-6 col-xs-6">
					{{-- Lang Select --}}
					<div class="lang-select">
						<img src="<?php echo asset('img/lang_frame.png') ?>">

						<select class="form-select minimal" onchange="if (this.value) window.location.href=this.value">
							<option value="<?php echo Azooma::LanguageSwitch_new(Request::path('','ar'));?>" selected><?php echo ($lang=="en")? 'English' : "عربي" ;?></option>
							<option value="<?php echo Azooma::LanguageSwitch(Request::path('/'));?>"><?php echo ($lang=="en")? 'عربي' : "English" ;?></option>
						  </select>
					</div>
				</div>
			</div>

		<div class="row mt-4">
			<div class="col-lg-12">
				<div class="footer-div">
					<h4><?php echo Lang::get('messages.Explore-Azooma');?></h4>
					<div class="row">
						<div class="col-md-2 col-sm-12 footer-list">
							<ul>
								<li><a href="<?php echo Azooma::URL('page/about-us');?>"><?php echo Lang::get('messages.about_us');?></a></li>
								<li><a href="<?php echo Azooma::URL('contact-us');?>"><?php echo Lang::get('messages.contact_us');?> </a></li>
								<li><a href="<?php echo Azooma::URL('sitemap');?>"><?php echo Lang::get('messages.site_map');?></a></li>
								<li><a href="<?php echo Azooma::URL('privacy-terms');?>"> <?php echo Lang::get('messages.Termsofuse');?></a></li>
							</ul>
						</div>
						<div class="col-md-2 col-sm-12 footer-list">
							<?php if($city != null) { ?>
							<ul>
								<li><a href="<?php echo Azooma::URL($cityurl.'/latest');?>"><?php echo Lang::get('messages.latest');?> </a></li>
								<li><a href="<?php echo Azooma::URL($cityurl.'/home-delivery');?>"><?php echo Lang::get('messages.home_delivery');?> </a></li>
								<li><a href="<?php echo Azooma::URL($cityurl.'/fine-dining');?>"><?php echo Lang::get('messages.fine-dining');?> </a></li>
								<li><a href="<?php echo Azooma::URL($cityurl.'/sheesha');?>"><?php echo Lang::get('messages.sheesha');?></a></li>
							</ul>	
							<?php } ?>					
						</div>
						<div class="col-md-2 col-sm-12 footer-list">
							<?php if($city != null) { ?>						
							<ul>
								<li><a href="<?php echo Azooma::URL($cityurl.'/cuisines');?>"><?php echo Lang::get('messages.browse_by_cuisines').' ';?> </a></li>
								<li><a href="<?php echo Azooma::URL($cityurl.'/localities');?>"><?php echo Lang::get('messages.browse_by_locations').' ';?> s</a></li>
								<li><a href="<?php echo Azooma::URL('blog');?>"><?php echo Lang::get('messages.Azooma-Blog');?> </a></li>
								<li><a href="<?php echo Azooma::URL('recipes');?>"><?php echo Lang::get('messages.Azooma-Recipe');?></a></li>
							</ul>
							<?php } ?>		
						</div>
						<div class="col-md-2 col-sm-12 footer-list">
							<div class="mobile-social">
								<h5><?php echo Lang::get('messages.stay_in_touch');?></h5>
								<?php 
								if($city != null){
								   $country=MGeneral::getCountry($city->country);
								}else{
								   $country=MGeneral::getCountry(1);
								} 
								?>
									<ul>
										<li><a href="<?php echo $country->facebook;?>" title="facebook">
											<img src="<?php echo asset('img/icons/facebook.svg') ?>" alt="facebook">
										</a>
										</li>
										<li><a href="<?php echo $country->twitter;?>" title="twitter">
											<img src="<?php echo asset('img/icons/twitter.svg') ?>" alt="twitter">
										</a>
										</li>
										<li><a href="<?php echo $country->google;?>" title="google">
											<img src="<?php echo asset('img/icons/google.svg') ?>" alt="google">
										</a>
										</li>
										<li><a href="#" title="instagram">
											<img src="<?php echo asset('img/icons/instagram.svg') ?>" alt="instagram">
										</a>
										</li>
										<li><a href="<?php echo $country->youtube;?>" title="youtube">
											<img src="<?php echo asset('img/icons/youtube.svg') ?>" alt="youtube">
										</a>
										</li>
										
									</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-lg-12">
				<div class="footer-div">
					<h4><?php echo Lang::get('messages.about_us');?> </h4>
					<div class="row">
						<div class="col-lg-12">
							<p>Contrary to popular belief, Lorem Ipsum is not simply random text. 
								It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, 
								a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the
								word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and
								Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..",
								comes from a line in section 1.10.32.</p>
								<br>
								<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
									or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
									middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of
									over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free
									from repetition, injected humour, or non-characteristic words etc.</p>
						</div>
					
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="copyright-footer">
					<p><?php echo Lang::get('messages.footer_copy');?> </p>
				</div>
			</div>
		</div>
	</div>
</section>

{{-- <a href="https://plus.google.com/+Azoomaplus" rel="publisher" class="hidden"></a> --}}
<?php
if(Session::has('userid')){
	$user=DB::table('user')->select('user_Email','user_Status','user_ID')->where('user_ID',Session::get('userid'))->first();
	if($user->user_Status==0){
		?>
		<div id="sticky-note">
			<div class="container">
				<div class="inner-padding">
					<?php echo Lang::get('messages.account_not_activated_check_email',array('email'=>$user->user_Email));?>
					<a href="<?php echo Azooma::URL('reactivate/'.$user->user_ID);?>">
						<?php echo Lang::get('messages.click_to_send_email');?>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
@include('ajax.login');
<script src="<?php echo URL::asset('js/langlibrary.js');?>"></script>

<script src="<?php echo URL::asset('js/js.js');?>"></script>
<script src="<?php echo URL::asset('js/jquery-ui.js');?>"></script>

<script src="<?php echo URL::asset('js/popular.js');?>"></script>
<script src="<?php echo URL::asset('js/wow.min.js');?>"></script>
<script src="<?php echo URL::asset('js/rangeslider.min.js');?>"></script>
<script src="<?php echo URL::asset('js/jquery.lazyload.min.js');?>"></script>
<script src="<?php echo URL::asset('js/new-custom.js');?>"></script>
<script>
	$('#azooma-loader').fadeOut(1000);
</script>
<script>
	document.documentElement.className += 'js';
		var require={
			baseUrl:originalbase+'/js/',
			paths: {
				'gplus':'https://apis.google.com/js/client:platform.js',
				'async':'async',
			},
			shim:{
				'underscore-min':{
					'exports':'_'
				}
			}
		}
	</script>
	
<script src="<?php echo URL::asset('js/require.js');?>"></script>

<script type="text/javascript">
if(typeof city!="undefined"){
	var _popularcategories='<?php echo Lang::get('messages.popular').' '.Lang::get('messages.categories');?>', _searchhelpers=[
		{name:'<?php echo Lang::get('messages.near_you');?>',url:'near-me'},
		{name:'<?php echo Lang::get('messages.latest').' '.Lang::choice('messages.restaurants',2);?>',url:'latest'},
		{name:'<?php echo Lang::get('messages.home-delivery');?>',url:'home-delivery'},
		{name:'<?php echo Lang::get('messages.fine-dining');?>',url:'fine-dining'},
		{name:'<?php echo Lang::get('messages.special_offers');?>',url:'offers'},
		{name:'<?php echo Lang::get('messages.catering');?>',url:'catering'},
		{name:'<?php echo Lang::choice('messages.hotels',2);?>',url:'hotels'},
		{name:'<?php echo Lang::get('messages.sheesha');?>',url:'sheesha'},
		{name:'<?php echo Lang::get('messages.popular').' '.Lang::choice('messages.restaurants',2);?>',url:'popular'},
	];
}

</script>
 
<div id="fb-root"></div>
