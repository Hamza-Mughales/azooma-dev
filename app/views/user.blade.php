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
    <section class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12" style="position: relative;">
                {{-- Profile Header Start --}}
                <section class="profile-header">
                    <div class="container">
                        <div class="row header-box">
                            <div class="col-12 info">
                                {{-- User Avatar --}}
                                <div class="user-avatar">
                                    <?php $userimage=($user->image=="")?'user_no_image.jpg':$user->image; ?>
                                    <?php if($user->image == ""){ ?>
                                    <img src="<?php echo Azooma::CDN('images/user-default.svg');?>"
                                        alt="<?php echo $username;?>" width="130" height="130" />
                                    <?php } else{ ?>
                                    <img src="<?php echo Azooma::CDN('images/userx130/'.$user->image);?>"
                                        alt="<?php echo $username;?>" width="130" height="130" />
                                    <?php } ?>
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
                                <div class="user-info">
                                    <h4 class="title">
                                        <?php echo $username;?>
                                    </h4>
                                    <?php if($userlocation!=""){ ?>
                                    <span class="location">
                                        <i class="fa fa-map-marker"></i> <?php echo $userlocation;?>
                                    </span>
                                    <?php } ?>
                                    <div class="user-numbers">
                                        <?php
                                      
                                        if($usertotallikes>0){
                                            echo '<a class="number-btn" href="#user-recommends" ><span class="brag"> <i class="fas fa-heart"></i> '.$usertotallikes.'</span> '.Lang::get('messages.recommends').'</a>';
                                        }
                                        if($followers>0){
                                            echo '<a class="number-btn" href="#user-followers" ><i class="fas fa-user-plus"></i> <span class="brag" data-total-followers'.$user->user_ID.'="'.$followers.'"> '.$followers.'</span> '.Lang::get('messages.followers').'</a>';
                                        }
                                        if($following>0){
                                            echo '<a class="number-btn" href="#user-following"><i class="fas fa-user"></i>  <span class="brag">'.$following.'</span> '.Lang::get('messages.following').'</a>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="user-setting-btn">
                                    <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                                    <a href="<?php echo Azooma::URL('settings');?>"
                                        class="btn btn-light settings-btn big-trans-btn m-0"><i class="fa fa-gear"></i>
                                        <?php echo Lang::get('messages.settings');?></a>
                                    <?php }else{
                                        if(isset($checkfollowing)&&$checkfollowing>0){
                                            ?>
                                    <button class="btn btn-danger follow-btn following-btn big-main-btn m-0" data-following="1"
                                        data-user="<?php echo $user->user_ID;?>"><?php echo Lang::get('messages.following');?></button>
                                    <?php
                                        }else{
                                    ?>
                                    <button class="btn btn-danger follow-btn big-trans-btn m-0"
                                        style="padding: 5px 1rem;" data-following="0"
                                        data-user="<?php echo $user->user_ID;?>"><?php echo Lang::get('messages.follow');?></button>
                                    <?php
                                    }  } ?>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                            {{-- User Profile Nav Menu Start --}}
                                <section class="user-profile-nav">
                                    <ul class="nav-list">
                                        <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                                            <li> 
                                                <a href="#news-feed" class="active">
                                                    <?php echo Lang::get('messages.news_feed');?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <li> 
                                                <?php if($lang == 'ar'){   ?>
                                                    <a href="#user-activity" <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ }else{ ?> class="active" <?php }?>>
                                                        <?php echo Lang::get('messages.activity');?> <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ echo Lang::get('messages.my').' '; } ?>
                                                    </a>
                                                    <?php } else { ?>
                                                        <a href="#user-activity" <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ }else{ ?> class="active" <?php }?>>
                                                            <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ echo Lang::get('messages.my').' '; } ?><?php echo Lang::get('messages.activity');?>
                                                        </a>
                                                    <?php } ?>
                                            </li>
                                            <li>
                                                <a href="#user-reviews">
                                                    <?php echo Lang::get('messages.reviews');?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#user-photos">
                                                    <?php echo Lang::get('messages.photos');?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#lists" title="<?php echo Lang::get('messages.lists');?>">
                                                    <?php echo Lang::get('messages.lists');?>
                                                </a>
                                            </li>    
                                          
                                    </ul>
                                </section>
                                {{-- User Profile Nav Menu End --}}
                            </div>
                        </div>
                    </div>
                </section>
                {{-- Profile Header End --}}
                {{-- User Profile Main Start --}}
                <section class="user-profile-tabs">
                    <div class="container">
                        <div class="row">
                            {{-- User Tabs --}}
                            <div class="col-md-12 col-sm-12 azooma-tabs">
                            <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                                <div class="profile-tab <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){?> show <?php }else{ ?>  <?php }?>" id="news-feed">
                                   <div class="mynews">
                                   <?php
                                            $newfeed=array(
                                                'lang'=>$lang,
                                                'curruser'=>$user,
                                                'limit'=>10,
                                                'offset'=>0,
                                                'curuserimage'=>$userimage,
                                                'curusername'=>$username,
                                                'news'=>$newsfeed
                                            );
                                    ?>
                                        @include('user.news_feed',$newfeed)
                        
                                   </div>
                                   
                                   <?php
                                if(count($totalactivities)>20){
                                    ?>
                                        <button id="load-more-news"  style="margin: 2rem auto;" data-user="<?php echo $user->user_ID;?>" data-loaded="<?php echo count($useractivities);?>" data-scenario="activity" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button" ><?php echo Lang::get('messages.load_more');?></button>
                                    <?php
                                }
                                ?>
                                </div>
                            <?php } ?>
                            <div class="profile-tab <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ }else{ ?> show <?php }?>" id="user-activity">
                            <?php 
                                $activity=array(
                                        'lang'=>$lang,
                                        'user'=>$user,
                                        'limit'=>10,
                                        'offset'=>0,
                                        'userimage'=>$userimage,
                                        'username'=>$username,
                                        'totalactivities'=>$totalactivities,
                                        'useractivities'=>$useractivities
                                    );
                            ?>
                                @include('user.activity',$activity)
                            </div>
                            <div class="profile-tab d-flex" id="user-reviews">
                                <?php 
                                $reviews=array(
                                    'lang'=>$lang,
                                    'user'=>$user,
                                    'limit'=>15,
                                    'offset'=>0,
                                    'userimage'=>$userimage,
                                    'username'=>$username,
                                    'totalcomments'=>$usertotalcomments,
                                );
                                ?>
                                @include('user.reviews',$reviews)
                            </div>
                            <div class="profile-tab d-flex" id="user-recommends">
                                <?php 
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
                                ?>
                                @include('user.recommends',$recommends)
                            </div>
                            <div class="profile-tab d-flex" id="user-photos">
                                <?php 
                                $photos=array(
                                            'lang'=>$lang,
                                            'user'=>$user,
                                            'limit'=>15,
                                            'offset'=>0,
                                            'userimage'=>$userimage,
                                            'username'=>$username,
                                            'usertotalphotos'=>$usertotalphotos,
                                        );
                                ?>
                                @include('user.photos',$photos)
                            </div>
                            <div class="profile-tab" id="user-followers">
                                <?php 
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
                                ?>
                                @include('user.followers',$follow)
                            </div>
                            <div class="profile-tab" id="user-following">
                                <?php 
                                $following=array(
                                    'lang'=>$lang,
                                    'user'=>$user,
                                    'limit'=>15,
                                    'offset'=>0,
                                    'userimage'=>$userimage,
                                    'username'=>$username,
                                    'followers'=>$followers,
                                    'following'=>$following,
                                        );
                                ?>
                                @include('user.following',$following)
                            </div>
                            <div class="profile-tab d-flex" id="user-events">
                            <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
                                @include('user.events',$activity)
                                <?php }?>
                            </div>
                            <div class="profile-tab d-flex" id="lists">
                                <?php 
                                $lists=array(
                                    'lang'=>$lang,
                                    'user'=>$user,
                                    'limit'=>15,
                                    'offset'=>0,
                                    'userimage'=>$userimage,
                                    'username'=>$username,
                                    'totallists'=>$usertotallists,
                                );
                                ?>
                                 @include('user.lists',$lists)
                            </div>
                            
                            </div>
                            {{-- User Side Nav --}}
                        </div>
                    </div>
                </section>
                {{-- User Profile Main End --}}
            </div>
            <div class="col-md-4 col-sm-12">
                @include('inc.rightcol')
            </div>
        </div>
    </section>
  
  

 
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

<script src="<?php echo URL::asset('js/user.js');?>"></script>
<!-- AddThis Button END -->
</body>
</html>