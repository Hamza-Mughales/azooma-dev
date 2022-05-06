<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <div id="n">
        <div class="" >
            <div class="spacing-container">
            </div>
            <div class="container">
                <div class="overflow">
                    <div id="user-photo-container" class="rest-logo pull-left sufrati-white-box">
                        <?php $userimage=($user->image=="")?'user-default.svg':$user->image; ?>
                        <img src="<?php echo Azooma::CDN('images/userx130/'.$userimage);?>" alt="<?php echo $username;?>" width="130" height="130"/>
                        <?php
                        if(Session::has('userid')&&Session::get('userid')==$user->user_ID){
                        ?>
                        <a id="photo-upload" href="<?php echo Azooma::URL('settings#phototab');?>" class="">
                            <i class="fa fa-camera"></i>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="user-profile-desc" class="pull-left">
                        <h1>
                            <?php echo $username;?>
                        </h1>
                        <div id="user-location-likes">
                        <?php if($userlocation!=""){ ?>
                        <div id="location-info">
                            <?php echo $userlocation;?> <i class="fa fa-map-marker"></i>
                        </div>
                        <?php }
                        if(count($userfavorites)>0){
                            $i=0;
                            ?>
                            <div>
                            <?php
                            echo Lang::get('messages.likes').' ';
                            foreach ($userfavorites as $cuisine) {
                                if($lang=="en"){
                                    echo stripcslashes($cuisine->cuisine_Name);
                                }else{
                                    echo stripcslashes($cuisine->cuisine_Name_ar);
                                }
                                $i++;
                                if($i==7){
                                    if(count($userfavorites)>$i){
                                        echo ' '.Lang::get('messages.and_more').'.';
                                    }
                                    break;
                                }else{
                                    if($i!=count($userfavorites)){
                                        echo ', ';    
                                    }
                                }
                            }
                            ?>
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                        <div class="overflow btn-group" id="user-bragging">
                            <?php if($usertotalcomments>0){
                                echo '<a class="pull-left btn btn-light" href="#user-reviews" ><span class="brag">'.$usertotalcomments.'</span> '.Lang::get('messages.reviews').'</a>';
                            }
                            if($usertotalphotos>0){
                                echo '<a class="pull-left btn btn-light" href="#user-photos" ><span class="brag">'.$usertotalphotos.'</span> '.Lang::get('messages.photos').'</a>';
                            }
                            if($usertotallikes>0){
                                echo '<a class="pull-left btn btn-light" href="#user-recommends" ><span class="brag">'.$usertotallikes.'</span> '.Lang::get('messages.likes').'</a>';
                            }
                            if($followers>0){
                                echo '<a class="pull-left btn btn-light" href="#followerstab" ><span class="brag" data-total-followers'.$user->user_ID.'="'.$followers.'">'.$followers.'</span> '.Lang::get('messages.followers').'</a>';
                            }
                            if($following>0){
                                echo '<a class="pull-left btn btn-light" href="#followingtab"><span class="brag">'.$following.'</span> '.Lang::get('messages.following').'</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div id="user-profile-follow" class="pull-right">
                        <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                        <a href="<?php echo Azooma::URL('settings');?>" class="btn btn-light settings-btn"><i class="fa fa-gear"></i> <?php echo Lang::get('messages.settings');?></a>
                        <?php }else{
                            if(isset($checkfollowing)&&$checkfollowing>0){
                                ?>
                            <button class="btn btn-danger follow-btn following-btn" data-following="1" data-user="<?php echo $user->user_ID;?>"><?php echo Lang::get('messages.following');?></button>
                                <?php
                            }else{
                        ?>
                            <button class="btn btn-danger follow-btn" data-following="0" data-user="<?php echo $user->user_ID;?>"><?php echo Lang::get('messages.follow');?></button>
                        <?php
                        }  } ?>
                    </div>
                </div>
                <div class="spacing-container">
                </div>
            </div>
            
            <div class="spacing-container">
            </div>
        </div>
        <div class="sufrati-head">
            <div class="container">
                <ul class="nav navbar-nav" id="user-profile-tabs">
                    <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                    <li class="active"> 
                        <a href="#news-feed" data-bs-toggle="tab">
                            <?php echo Lang::get('messages.news_feed');?>
                        </a>
                    </li>
                    <?php } ?>
                    <li <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ }else{ ?> class="active" <?php }?>> 
                        <a href="#user-activity" data-bs-toggle="tab">
                            <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ echo Lang::get('messages.my').' '; } ?><?php echo Lang::get('messages.activity');?>
                        </a>
                    </li>
                    <li >
                        <a href="#user-reviews" data-bs-toggle="tab">
                            <?php echo Lang::get('messages.reviews');?>
                        </a>
                    </li>
                    <li>
                        <a href="#user-recommends" data-bs-toggle="tab">
                            <?php echo Lang::choice('messages.recommendation',2);?>
                        </a>
                    </li>
                    <li>
                        <a href="#user-photos" data-bs-toggle="tab" title="<?php echo Lang::get('messages.photos');?>">
                            <?php echo Lang::get('messages.photos');?>
                        </a>
                    </li>
                    <li>
                        <a href="#lists" data-bs-toggle="tab" title="<?php echo Lang::get('messages.lists');?>">
                            <?php echo Lang::get('messages.lists');?>
                        </a>
                    </li>
                    <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                    <li>
                        <a href="#user-events" data-bs-toggle="tab">
                            <?php echo Lang::get('messages.organised_events');?>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo Azooma::URL('invite');?>" title="<?php echo Lang::get('messages.invite_friends');?>">
                            <?php echo Lang::get('messages.invite_friends');?>
                        </a>
                    </li>
                    <li class="hidden"> 
                        <a href="#followerstab" data-bs-toggle="tab">
                            <?php echo Lang::get('messages.followers');?>
                        </a>
                    </li>
                    <li class="hidden"> 
                        <a href="#followingtab" data-bs-toggle="tab">
                            <?php echo Lang::get('messages.following');?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="spacing-container"></div>
        <div class="container">
            <?php 
            if(Session::has('success')){
                    ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo Session::get('success');?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="spacing-container"></div>
        <div class="container">
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 no-padding no-border">
                        <div class="tab-content">
                        <?php
                            if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){
                                $newfeed=array(
                                    'lang'=>$lang,
                                    'curruser'=>$user,
                                    'limit'=>40,
                                    'offset'=>0,
                                    'curuserimage'=>$userimage,
                                    'curusername'=>$username,
                                    'news'=>$newsfeed
                                );
                            }
                            $activity=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>40,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'totalactivities'=>$totalactivities,
                                'useractivities'=>$useractivities
                            );
                            $reviews=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>15,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'totalcomments'=>$usertotalcomments,
                            );
                            $totalfoodrecommends=User::getTotalFoodRecommend($user->user_ID); 
                            $recommends=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>15,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'usertotallikes'=>$usertotallikes,
                                'totalfoodrecommends'=>$totalfoodrecommends
                            );
                            $lists=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>15,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'totallists'=>$usertotallists,
                            );
                            $photos=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>15,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'usertotalphotos'=>$usertotalphotos,
                            );
                            $follow=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'limit'=>15,
                                'offset'=>0,
                                'userimage'=>$userimage,
                                'username'=>$username,
                                'followers'=>$followers,
                                'following'=>$following,
                            );
                            if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                            <div class="tab-pane active" id="news-feed">
                                @include('user.news_feed',$newfeed)
                                <?php
                                if($totalactivities>40){
                                    ?>
                                    <div id="activity-morebtn-cnt">
                                        <button id="load-more-news" data-user="<?php echo $user->user_ID;?>" data-loaded="<?php echo count($useractivities);?>" data-scenario="activity" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php } ?>
                            <div class="tab-pane <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ }else{ echo 'active'; }?>" id="user-activity">
                                @include('user.activity',$activity)
                                <?php
                                if($totalactivities>40){
                                    ?>
                                    <div id="activity-morebtn-cnt">
                                        <button id="load-more-activity" data-user="<?php echo $user->user_ID;?>" data-loaded="<?php echo count($useractivities);?>" data-scenario="activity" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="user-reviews">
                                @include('user.reviews',$reviews)
                                <?php
                                if($usertotalcomments>15){
                                    ?>
                                    <div id="reviews-morebtn-cnt">
                                        <button id="load-more-review" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="reviews" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            @include('user.recommends',$recommends)
                            <div class="tab-pane" id="user-photos">
                                @include('user.photos',$photos)
                                <?php if($usertotalphotos>15){
                                    ?>
                                    <div id="photos-morebtn-cnt">
                                        <button id="load-more-followers" data-user="<?php echo $user->user_ID;?>" data-loaded="15" data-scenario="photos" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="user-events">
                                <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                                @include('user.events',$activity)
                                <?php }?>
                            </div>
                            @include('user.lists',$lists)
                            @include('user.followers',$follow)
                            @include('user.following',$follow)
                        </div>
                    </div>
                    <div class="sufrati-main-col-2">
                    </div>
                    <div class="sufrati-main-col-3 sufrati-white-box">
                        <?php 
                        $userrigh=array('lang'=>$lang);
                        $bannerarray=array('userprofile'=>true);
                        ?>
                        @include('user.userrightcol',$userrigh)
                        @include('inc.rightcol',$bannerarray)
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @include('inc.footer')
    <script type="text/javascript">
    var load_more_txt="<?php echo Lang::get('messages.load_more');?>", loading_txt="<?php echo Lang::get('messages.loading');?>";
    </script>
    <script type="text/javascript">
        require(['user'],function(){});
    </script>
    <!-- AddThis Button BEGIN -->
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Sufrati'};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
<!-- AddThis Button END -->
</body>
</html>