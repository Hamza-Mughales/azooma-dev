
<?php 
if($lang=="en"){
	$photoname= ($photo->title!="")?stripcslashes($photo->title):stripcslashes($photo->rest_Name).' '.Lang::get('messages.photo');
}else{
	$photoname= ($photo->title_ar!="")?stripcslashes($photo->title_ar):stripcslashes($photo->rest_Name_ar).' '.Lang::get('messages.photo');
}
?>
<!-- Modal -->
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $photoname ?></h5>
        <button type="button"  class="btn-close sufrati-close-popup" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
        </div>
        <div class="modal-body">
            <div class="modal-start-gallary">
                <div class="owner-avatar">
                    <?php 
                    if($photo->user_ID!=NULL){
                        $user=User::checkUser($photo->user_ID);
                        $user=$user[0];
                        $userimage=($user->image=="")?'user-default.svg':$user->image;
                        $username=($user->user_NickName=="")?ucfirst(stripcslashes($user->user_FullName)):ucfirst(stripcslashes($user->user_NickName));
                    ?>
                    <div class="pull-left by-logo">
                        <a class="rest-logo" href="<?php echo Azooma::URL('user/'.$photo->user_ID);?>" title="<?php echo $username;?>">
                            <img src="<?php echo Azooma::CDN('images/user_thumb/'.$userimage);?>" alt="<?php echo $username;?>"/>
                            <?php echo $username;?>
                        </a>
                    </div>
                    <div class="pull-left by-details">
                        <time>
                            <?php echo Azooma::ago($photo->enter_time);?>
                        </time>
                    </div>
                    <?php
                }else{
                    $restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
                    $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                    ?>
                    <div class="pull-left by-logo">
                        <a class="rest-logo" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                            <img src="<?php echo Azooma::CDN('logos/thumb/'.$restlogo);?>" alt="<?php echo $restname;?>"/>
                            <?php echo (strlen($restname)>22)?ucfirst(mb_substr($restname, 0,22,'UTF-8')).'..':$restname;?>

                        </a>
                    </div>
                    <div class="pull-left by-details">
                       
                        <time>
                            <?php echo Azooma::ago($photo->enter_time);?>
                        </time>
                    </div>
                    <?php
                }
                ?>
                </div>
                
            </div>
        <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>" alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
        <?php 
            if(Session::has('userid')){
                $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
            }
            if(Session::has('userid')&&$checkuserliked>0){
                ?>
                <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                    <i class="fas fa-heart"></i>  <?php echo Lang::get('messages.liked');?>
                </button>
                <?php
            }else{
            ?>
                <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                    <i class="far fa-heart"></i>  <?php echo Lang::get('messages.like');?>
                </button>
            <?php } ?>
    </div>
      
    </div>

