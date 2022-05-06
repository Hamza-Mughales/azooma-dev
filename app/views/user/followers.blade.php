<div class="d-flex justify-content-between">
<?php if($followers>0){ ?>    
          	<?php 
            $userfollowers=User::getFollowers($user->user_ID,$limit,$offset);
            $fol=array(
                'lang'=>$lang,
                'user'=>$user,
                'userimage'=>$userimage,
                'username'=>$username,
                'userfollowers'=>$userfollowers,
            );
            ?>
            @include('user.helpers.follower_following',$fol)
            <?php
            if($followers>$limit){
              ?>
                <button id="load-more-followers" style="margin: 2rem auto;" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="followers" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button big-trans-btn" ><?php echo Lang::get('messages.load_more');?></button>
              <?php
            }
            ?>
    
	<?php
}
?>
            </div>
