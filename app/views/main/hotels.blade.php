<?php foreach ($hotels as $hotel) {
$hotelname=($lang=="en")?stripcslashes($hotel->name):stripcslashes($hotel->nameAr);
$hotellogo=$hotel->logo;
if($hotellogo===""){
	$hotellogo='default_logo.gif';
}
$restaurant=MHotel::getHotelRestaurant($hotel->id,$city->city_ID);
?>
<div class="gold-box result-box overflow">
	<div class="sufrati-result-sub-col-1 overflow ">
		<div class="pull-left result-col-desc">
			<div>
				<a class="result-rest-name" href="<?php echo Azooma::URL($city->seo_url.'/hotel/'.$hotel->url.'#n');?>" title="<?php echo $hotelname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
					<?php echo (strlen($hotelname)>18)?mb_substr($hotelname, 0,18,'UTF-8').'..':$hotelname;?>
				</a>
			</div>
			<div >
				<?php echo Lang::get('messages.a').' '.$hotel->star.' <i class="fa fa-star"></i> '.Lang::choice('messages.hotels',1);?>
			</div>
		</div>
		<div class="pull-left result-col-logo">
			<a class="rest-logo" href="<?php echo Azooma::URL($city->seo_url.'/hotel/'.$hotel->url.'#n');?>" title="<?php echo $hotelname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
				<img class="sufrati-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('logos/70/'.$hotellogo);?>" />
			</a>
		</div>
	</div>
	<div class="sufrati-result-sub-col-2">
		<a class="block" href="<?php echo Azooma::URL($city->seo_url.'/hotel/'.$hotel->url.'#n');?>" title="<?php echo $hotelname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
			<span class="photo-cropper"></span>
            <span class="photo-container">
            	<?php if((count($restaurant)>0)&&($restaurant->coverphoto!=null)){ ?>
            	<img class="sufrati-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('Gallery/400x/'.$restaurant->coverphoto);?>" alt="<?php echo $hotelname;?>"/>
            	<?php } ?>
            </span>
		</a>
	</div>
</div>
<?php } ?>