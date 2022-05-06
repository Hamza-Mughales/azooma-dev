
 <div class="d-flex justify-content-between" style="width: 100%">

 <?php if($usertotallikes>0){ ?>    
      <div class="user-recommends" style="width: 100%">
       <h4><?php echo Lang::choice('messages.restaurants',2);?> - <?php echo $usertotallikes;?></h4>
        <div id="userLikes">
          	<?php 
            if(!isset($restlikes)){
                $restlikes=User::getUserLikes($user->user_ID,$limit,$offset);
            }
              if(count($restlikes)>0){
                $restliket=array(
                    'lang'=>$lang,
                    'user'=>$user,
                    'userimage'=>$userimage,
                    'username'=>$username,
                    'restlikes'=>$restlikes,
                );
                ?>
                <div class="row" style="width: 100%;margin:0">
                  @include('user.helpers.like_rest',$restliket)

                  </div>
                  <?php
                  if($usertotallikes>$limit){
                    ?>
                  <button id="load-more-restlikes" style="margin: 2rem auto;" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="restlikes" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button big-trans-btn" ><?php echo Lang::get('messages.load_more');?></button>

                    <?php
                  }
                  ?>
                </div>
                <?php
              }
          	?>
      </div>

      <?php
    }
      
      if($totalfoodrecommends>0){
        $userfoods=User::getUserFoodRecommend($user->user_ID,$limit,$offset);
        if(count($userfoods)>0){
          $foodliket=array(
              'lang'=>$lang,
              'user'=>$user,
              'userimage'=>$userimage,
              'username'=>$username,
              'userfoods'=>$userfoods,
          );
      ?>
      
      <div class="user-recommends" style="width: 100%">
      <h4> <?php echo Lang::get('messages.food');?> -  <?php echo $totalfoodrecommends;?></h4>
        <div>
              <div class="row" style="width: 100%;margin:0">
                    @include('user.helpers.like_dish',$foodliket)
                        <?php
                  if($totalfoodrecommends>$limit){
                    ?>
                    <div id="restlikes-morebtn-cnt">

                    <button id="load-more-restlikes" style="margin: 2rem auto;" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="restlikes" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button big-trans-btn" ><?php echo Lang::get('messages.load_more');?></button>
                    </div>
                    <?php
                  }
                  ?>
                  </div>
                </div>
      </div>
      <?php } } ?>

    </div>