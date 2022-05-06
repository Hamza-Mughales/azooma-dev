

<div class="d-flex justify-content-between">
<?php if($following>0){ ?>    
          	<?php 
            $userfollowing=User::getFollowing($user->user_ID,$limit,$offset);
            $fol=array(
                'lang'=>$lang,
                'user'=>$user,
                'userimage'=>$userimage,
                'username'=>$username,
                'userfollowers'=>$userfollowing,
            );
            ?>
            @include('user.helpers.follower_following',$fol)
            <?php
               if($following>$limit){
              ?>
                <button id="load-more-following" style="margin: 2rem auto;" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="following" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button big-trans-btn" ><?php echo Lang::get('messages.load_more');?></button>
              <?php
            }
            ?>
    
	<?php
}
?>
            </div>
