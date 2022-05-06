<?php
foreach ($likesuggestions as $rest) {
	$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
	$restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
	$city=MGeneral::getPossibleCity($rest->rest_ID);
	?>
	<div class="overflow follow-users-list rest-like-sugst">
	      <div class="pull-left user-logo follow-col-1">
	        <a class="rest-logo" href="<?php echo Azooma::url($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
	          <img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>"/>
	        </a>
	      </div>
	      <div class="pull-left follow-col-2">
	          <a class="normal-text block" href="<?php echo Azooma::url($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
	            <?php echo $restname;?>
	          </a>
	          <div>
	          	<?php echo Lang::get('messages.a').' '.Azooma::LangSupport($rest->class_category).' ';
	                echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr);
	                echo ($lang=="en")?stripcslashes(' '.$rest->type):stripcslashes(' '.$rest->typeAr);
                ?>
	          </div>
    	</div>
    	<div class="pull-left follow-col-3">
    		<div class="btn-group rest-like-btns" data-rest="<?php echo $rest->rest_ID;?>">
    			<button class="btn rest-like-btn like-btn like" data-rest="<?php echo $rest->rest_ID;?>"><i class="fa fa-heart"></i> <?php echo Lang::get('messages.like_it');?></button>
                <button class="btn btn-light like-btn dislike" data-rest="<?php echo $rest->rest_ID;?>"><?php echo Lang::get('messages.dont_like_it');?></button>
    		</div>
    	</div>
    </div>
	<?php
}


