<?php
if(count($restaurants)>0){
	foreach ($restaurants as $rest) {
		($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
    	$restlogo=$rest->logo;
        if($restlogo==""){
            $restlogo="default_logo.gif";
        }
		?>
		<div class="gold-box result-box overflow">
    		<div class="Azooma-result-sub-col-1 overflow ">
    			<div class="pull-left result-col-desc">
    				<div>
	    				<a class="result-rest-name" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
	    					<?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?>
	    				</a>
	    			</div>
	    			<div class="small">
	    				<b><?php echo Azooma::LangSupport($rest->class_category);?></b>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->type):stripcslashes($rest->typeAr);?>
	    			</div>
	    			<div class="result-summary-icons">
	    				<i class="fa fa-truck " data-bs-toggle="tooltip" title="<?php echo Lang::get('messages.delivery_available');  ?>"></i>
	    				<?php if($rest->menu!=0){ ?>
	    				<i class="fa fa-book" data-bs-toggle="tooltip" title="<?php echo Lang::get('messages.menu_available'); ?>"></i>
	    				<?php } if($rest->sufrati_favourite>0){ ?>
	    					<i class="fa fa-star" data-bs-toggle="tooltip" title="<?php echo Lang::get('messages.azooma_recommended'); ?>"></i>
	    				 <?php } ?>
	    				 <?php echo $rest->branches.' '.Lang::choice('messages.branch_branches',$rest->branches);?>
	    			</div>
    			</div>
    			<div class="pull-left result-col-logo">
	    			<a class="rest-logo" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
	    				<img class="Azooma-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" />
	    			</a>
	    			<?php 
	    			if(Session::has('userid')){
	    				$checkliked=Azooma::checkUserLiked($rest->id,Session::get('userid'));
	    			}
	    			if(!Session::has('userid')||(count($checkliked)<=0)){
	    			?>
	    			<button class="rest-like-btn btn mini-like-btn" data-rest="<?php echo $rest->id;?>" >
	    				<?php echo Lang::get('messages.like');?>
	    			</button>
	    			<?php }else{
	    				if(Session::has('userid')&&count($checkliked)>0){
	    					?>
	    					<button class="rest-like-btn btn mini-like-btn liked" data-rest="<?php echo $rest->id;?>" data-liked="<?php echo $checkliked->status;?>">
			    				<?php
			    				if($checkliked->status==1){
                                    echo '<i class="fa fa-heart"></i>  '.Lang::get('messages.liked');
                                }else{
                                    echo Lang::get('messages.disliked');
                                }
			    				?>
			    			</button>
	    					<?php
	    				}
	    			} ?>
	    		</div>
    		</div>
    		<div class="Azooma-result-sub-col-2 rateit-list">
    			<form class="form-horizontal" role="form" id="add-rating-block">
                    <div class="form-group row">
                        <label for="foodMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.food');?></label>
                        <div class="col-sm-9">
                            <input name="foodMini" id="foodMini" data-slider-id="foodMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Food;?>" value="<?php echo $userrated->rating_Food;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider" />
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="serviceMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.service');?></label>
                        <div class="col-sm-9">
                            <input name="serviceMini" id="serviceMini" data-slider-id="serviceMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Service;?>" value="<?php echo $userrated->rating_Service;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider"/>
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="atmosphereMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.atmosphere');?></label>
                        <div class="col-sm-9">
                            <input name="atmosphereMini" id="atmosphereMini" data-slider-id="atmosphereMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Atmosphere;?>" value="<?php echo $userrated->rating_Atmosphere;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider"/>
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="valueMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.value');?></label>
                        <div class="col-sm-9">
                            <input name="valueMini" id="valueMini" data-slider-id="valueMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Value;?>" value="<?php echo $userrated->rating_Value;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider"/>
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="varietyMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.variety');?></label>
                        <div class="col-sm-9">
                            <input name="varietyMini" id="varietyMini" data-slider-id="varietyMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Variety;?>" value="<?php echo $userrated->rating_Variety;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider"/>
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentationMini" class="col-sm-3 control-label"><?php echo Lang::get('messages.presentation');?></label>
                        <div class="col-sm-9">
                            <input name="presentationMini" id="presentationMini" data-slider-id="presentationMiniSlider" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="2" <?php if(isset($userrated)&&count($userrated)>0){ ?> data-slider-value="<?php echo $userrated->rating_Presentation;?>" value="<?php echo $userrated->rating_Presentation;?>" <?php }else{ ?> data-slider-value="0" value="0" <?php } ?> class="pop-slider"/>
                            <span class="icon-emo"><i></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input name="rest" value="<?php echo $rest->id;?>" type="hidden"/>
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-light btn-sm" id="submit-rating-btn"><?php echo Lang::get('messages.add_your_rating');?></button>
                        </div>
                    </div>
                </form>
    		</div>
    	</div>
		<?php
	}
}