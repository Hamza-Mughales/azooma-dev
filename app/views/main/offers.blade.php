<?php
	foreach ($offers as $offer) {
		$offername=($lang=="en")?stripcslashes($offer->offerName):stripcslashes($offer->offerNameAr);
		$restname=($lang=="en")?stripcslashes($offer->rest_Name):stripcslashes($offer->rest_Name_Ar);
		$restlogo=$offer->rest_Logo;
        if($restlogo==""){
            $restlogo="default_logo.gif";
        }
		?>
<div class="gold-box result-box overflow">
	<div class="sufrati-result-sub-col-1 overflow ">
		<div class="pull-left result-col-desc">
			<div>
				<a class="result-rest-name" href="<?php echo Azooma::URL($city->seo_url.'/offer/'.$offer->id.'#n');?>" title="<?php echo $offername.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
					<?php echo $offername;?>
				</a>
			</div>
			<div class="small">
				<b><?php echo ($lang=="en")?stripcslashes($offer->categoryName):stripcslashes($offer->categoryNameAr); ?></b>
				<?php echo ' '.Lang::get('messages.from').' '.$restname;?>
				<p>
					<?php echo ($lang=="en")?stripcslashes($offer->shortDesc):stripcslashes($offer->shortDescAr);?>
				</p>
			</div>
			<a class="btn btn-comment" href="<?php echo Azooma::URL($city->seo_url.'/offer/'.$offer->id.'#n');?>" title="<?php echo $offername.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
				<?php echo Lang::get('messages.view_offer');?>
			</a>
		</div>
		<div class="pull-left result-col-logo">
			<a class="rest-logo" href="<?php echo Azooma::URL($city->seo_url.'/'.$offer->seo_url.'#n');?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
				<img class="sufrati-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" />
			</a>
			
		</div>
	</div>
	<div class="sufrati-result-sub-col-2 ">
		<?php if($offer->image!=""){
			$offerimage=$offer->image;
			if($lang!="en"&&($offer->imageAr!="")){
				$offerimage=$offer->imageAr;
			}
		 ?>
		<a class="block" href="<?php echo Azooma::URL($city->seo_url.'/offer/'.$offer->id.'#n');?>" title="<?php echo $offername.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
			<span class="photo-cropper"></span>
            <span class="photo-container">
            	<img class="sufrati-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('images/offers/'.$offerimage);?>" alt="<?php echo $offername;?>"/>
            </span>
		</a>
		<?php  } ?>
	</div>
</div>
		<?php
	}