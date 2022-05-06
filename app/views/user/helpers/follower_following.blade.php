<?php
foreach ($userfollowers as $follow) {
    $fuserimage=($follow->image=="")?'user-default.svg':$follow->image;
    $fusername=($follow->user_NickName=="")?stripcslashes($follow->user_FullName):stripcslashes($follow->user_NickName);
    ?>
    <div class="follower-box">
      <div class="user-avatar">
        <a class="rest-logo" href="<?php echo Azooma::url('user/'.$follow->user_ID);?>" title="<?php echo $fusername;?>">
          <img src="<?php echo Azooma::CDN('images/100/'.$fuserimage);?>" alt="<?php echo $fusername;?>"/>
        </a>
        </div>
        <div class="user-info">
          <?php
            $location=User::getLocation($follow);
            ?>
            <div class="user-location"><i class="fa fa-map-marker"></i> <?php echo stripcslashes($location);?></div>
            <a class="user-title" href="<?php echo Azooma::url('user/'.$follow->user_ID);?>" title="<?php echo $fusername;?>">
              <?php echo $fusername;?>
            </a>
            
            <div class="numbers"><?php echo $follow->followers.' '.Lang::get('messages.followers').' - '.$follow->following.' '.Lang::get('messages.following');?> </div>

          <?php if(Session::has('userid')){
            if(Session::get('userid')==$follow->user_ID){

            }else{
              $checkfollowing=User::checkFollowing(Session::get('userid'),$follow->user_ID);
              if($checkfollowing>0){
                ?>
                <button class="btn btn-light follow-btn following-btn big-trans-btn" data-following="1" data-user="<?php echo $follow->user_ID;?>"><?php echo Lang::get('messages.following');?></button>
                <?php
              } else{
                ?>
                  <button class="btn btn-danger follow-btn big-trans-btn" data-following="0" data-user="<?php echo $follow->user_ID;?>"><?php echo Lang::get('messages.follow');?></button>
                <?php    
              } 
            }
            
          }else{
            ?>
            <button class="btn btn-danger follow-btn big-trans-btn" data-following="0" data-user="<?php echo $follow->user_ID;?>"><?php echo Lang::get('messages.follow');?></button>
        <?php }
          ?>
      </div>
    </div>
    <?php
  }
?>
