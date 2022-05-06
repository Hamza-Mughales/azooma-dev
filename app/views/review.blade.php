<!doctype html>
<html lang="<?php echo $lang;?>">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# review: http://ogp.me/ns/review#">
    @include('inc.metaheader',$meta)
    <meta property="fb:app_id" content="268207349876072" /> 
    <meta property="og:type" content="review" /> 
    <meta property="og:url" content="<?php echo Azooma::URL($city->seo_url.'/review/'.$review->review_ID);?>"/> 
    <meta property="og:title" content="<?php echo Lang::choice('messages.review',1).' '.Lang::choice('messages.by',1).' '.$username.' '.Lang::get('messages.for').' '.$restname ;?>"/> 
    <?php $restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;?>
    <meta property="og:image" content="<?php echo Azooma::CDN('logos/'.$restlogo);?>" /> 
    <meta property="og:description" content="<?php echo mb_substr($review->review_Msg, 0,50,'UTF-8')?>" /> 
    <meta property="review:target" content="" />
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <?php  ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar);?>
    <div class="sufrati-white-box" id="n" itemscope itemtype="http://schema.org/Restaurant">
        <div class="spacing-container">
        </div>
        <div class="container">
            <div>
                <div class="pull-left">
                    <ol class="breadcrumb" itemprop="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                            <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo $cityname;?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#n');?>" title="<?php echo $restname.' '.$cityname;?>">
                                <?php echo $restname;?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo Lang::choice('messages.review',1);?>
                        </li>
                    </ol>
                </div>
                <div class="pull-right">
                    <div class="bread-social">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
                    </div>
                    <div class="bread-social">
                        <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo Lang::choice('messages.review',1).' '.Lang::choice('messages.by',1).' '.$username.' '.Lang::get('messages.for').' '.$restname ;?>
                </h1>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 sufrati-white-box">
                        <div id="social-share-list">
                            <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <div class="overflow sufrati-user-review" id="user-review-<?php echo $review->review_ID;?>" itemscope itemtype="http://data-vocabulary.org/Review">
                        <div class="pull-left sufrati-user-info">
                            <?php
                            $userimage=($user->image=="")?'user-default.svg':$user->image;
                            if($user->user_Status==1){
                                ?>
                                <a class="rest-logo" href="<?php echo Azooma::URL('user/'.$review->user_ID);?>" alt="<?php echo $username;?>">
                                <?php }else{
                                    ?>
                                <span class="rest-logo">
                                    <?php
                                }   
                                ?>
                                <img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>" width="60" height="60">
                                <?php if($user->user_Status==1){ ?>
                                </a>
                                <?php }else{    ?>
                                </span>
                                <?php } ?>
                                <div class="small">
                                    <?php echo $usertotalreviews.' <i class="fa fa-comment"></i>&nbsp;&nbsp;|&nbsp;&nbsp;'.$usertotalratings.' <i class="fa fa-star"></i>';?> 
                                </div>
                        </div>
                        <div class="pull-left sufrati-review-info">
                            <div class="review-author-date">
                                <div class="overflow">
                                    <span class="pull-left">
                                    <?php if($user->user_Status==1){
                                    ?>
                                    <a class="pull-left author" href="<?php echo Azooma::URL('user/'.$review->user_ID);?>" alt="<?php echo $username;?>">
                                    <?php }else{
                                        ?>
                                    <span class="pull-left author">
                                        <?php
                                    }   
                                    echo '<span itemprop="reviewer">'.$username.'</span>';
                                    if($user->user_Status==1){ ?>
                                    </a>
                                    <?php }else{    ?>
                                    </span>
                                    <?php } ?>
                                    &nbsp;<?php echo Lang::choice('messages.on',1);?>
                                    <a class="author" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#n');?>" title="<?php echo $restname.' '.$cityname;?>">
                                        <?php echo $restname;?>
                                    </a>
                                    </span>
                                    <span class="small pull-right"><time itemprop="dtreviewed" datetime="<?php echo date('Y-m-d',strtotime($review->review_Date));?>"><?php echo Azooma::Ago($review->review_Date);?></time></span>
                                </div>
                            </div>
                            <div class="review" itemprop="description">
                                <?php
                                if(Azooma::isArabic($review->review_Msg)){
                                    echo stripcslashes($review->review_Msg);
                                }else{
                                    echo htmlspecialchars(html_entity_decode(htmlentities(ucfirst(stripcslashes($review->review_Msg)),6,'UTF-8'),6,"UTF-8"),ENT_QUOTES,'utf-8');
                                }
                                ?>
                            </div>
                            <div class="spacing-container">
                            </div>
                            <div class="overflow">
                            <?php 
                            if(count($userrated)>0){ ?>
                                <div class="pull-left small-text">
                                    <?php echo Lang::get('messages.food');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Food;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo Lang::get('messages.service');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Service;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo Lang::get('messages.atmosphere');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Atmosphere;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo Lang::get('messages.value');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Value;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo Lang::get('messages.variety');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Variety;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo Lang::get('messages.presentation');?>&nbsp;:&nbsp;<span class="pink"><?php echo $userrated->rating_Presentation;?></span>
                                </div>
                                <?php } ?>
                                <?php if(!Session::has('userid')||(Session::has('userid')&&(Session::get('userid')!==$review->user_ID))){
                                    $checkuseragreed=0;
                                    if(Session::has('userid')){
                                        $checkuseragreed=MRestaurant::checkUserAgreed(Session::get('userid'),$review->review_ID);
                                    }
                                 ?>
                                <div class="pull-right">
                                    <button class="btn btn-light btn-sm review-recommend-btn <?php if($checkuseragreed>0){ echo 'agreed'; } ?>" type="button" data-review="<?php echo $review->review_ID;?>"><span><?php echo $commentupvotes;?></span> <i class="fa fa-heart"></i></button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="sufrati-main-col-2">
                    </div>
                    <div class="sufrati-main-col-3 sufrati-white-box">
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Sufrati'};
    require(['_review'],function(){});
    </script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
</body>
</html>