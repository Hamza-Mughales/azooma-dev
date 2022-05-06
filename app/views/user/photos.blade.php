<?php
if(count($usertotalphotos)>0){
    if(!isset($userphotos)){
        $userphotos=User::getUserPhotos($user->user_ID,$limit,$offset);
    }
	if(count($userphotos)>0){
		?>
		<ul class="gallery-list-profile d-flex">
		<?php $i=0;
		foreach ($userphotos as $photo) {
			$i++;
            if($lang=="en"){
                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($photo->rest_Name);
            }else{
                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($photo->rest_Name_Ar);
            }
            $city=MGeneral::getPossibleCity($photo->rest_ID);
            $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_Ar);
            ?>
             <?php 
                        $restlogo=($photo->rest_Logo=="")?"default_logo.gif":$photo->rest_Logo;
                        $restname=($lang=="en")?stripcslashes($photo->rest_Name):stripcslashes($photo->rest_Name_Ar);
                        ?>
            <div class="user-news-container">
			<div class="news-type" style="background-color:#ff3c3c">
				<i class="fas fa-image"></i>
			</div>
			<div class="news-content">
				<div class="content-header">
					<div class="content-left">
						<div class="content-image">
                        <a class="rest-logo" href="<?php echo Azooma::URL($city->seo_url.'/'.$photo->seo_url);?>"
                                title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <img src="<?php echo Azooma::CDN('logos/thumb/'.$restlogo);?>"
                                    alt="<?php echo $restname;?>" />
                            </a>
						</div>
						<div class="top">
							<div class="d-flex">
								<div class="content-title">
                                <a class="bold block" href="<?php echo Azooma::URL($city->seo_url.'/'.$photo->seo_url);?>"
                                title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo (strlen($restname)>22)?ucfirst(mb_substr($restname, 0,22,'UTF-8')).'..':$restname;?>
                            </a>
                            
								</div>
								<div class="content-type">
                                <?php echo (strlen($photoname)>30)?ucfirst(mb_substr($photoname, 0,29,'UTF-8')).'..':ucfirst($photoname);?>

								</div>
							</div>
							<div class="content-date">
                            <?php echo Azooma::ago($photo->enter_time);?>
							</div>
						</div>
						
					</div>
					<div class="content-right">
						<div class="content-action">
                                <?php    $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid')); 
                                if($checkuserliked > 0 ) {?>
                                <button class="btn btn-light btn-sm heart-btn liked"
                                data-image="<?php echo $photo->image_ID;?>">
                                <i class="fas fa-heart"></i> <?php echo Lang::get('messages.liked') ?>
                            </button>
                            <?php } else { ?>
                                <button class="btn btn-light btn-sm heart-btn"
                                data-image="<?php echo $photo->image_ID;?>">
                                <i class="far fa-heart"></i> <?php echo Lang::get('messages.like') ?>
                            </button>
                                <?php } ?>
                        </div>
                    </div>
				</div>
				<div class="contant-block">
                <div class="center-photo">
                <a title="<?php echo $photoname;?>" class="rest-logo ajax-link"
                            href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>">
                            <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>"
                                alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">

                        </a>
                        </div>
				</div>
			</div>
			</div>

			<?php	
		}
		?>
		</ul>
		<?php
	}
}
?>