<!doctype html>
<html lang="<?php echo $lang;?>"
    prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# sufratiletseat: http://ogp.me/ns/fb/sufratiletseat#">

<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
    <meta property="fb:app_id" content="268207349876072" />
    <meta property="og:type" content="sufratiletseat:restaurant" />
    <meta property="og:title"
        content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
    <meta property="og:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
    <meta property="og:url" content="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>">
    <?php
    $restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
    if(count($cover)>0){ 
        $img= Azooma::CDN('Gallery/'.$cover[0]->image_full);
    }else{
        $img=Azooma::CDN('logos/'.$restlogo);
    }
    ?>
    <meta property="og:image" content="<?php echo $img;?>">
    <meta property="og:site_name" content="Sufrati">
    <meta property="fb:admins" content="100000277799043">
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@sufrati">
    <meta name="twitter:creator" content="@sufrati">
    <meta name="twitter:url" content="<?php echo Request::url();?>">
    <meta name="twitter:title"
        content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
    <meta name="twitter:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
    <meta name="twitter:image" content="<?php echo $img;?>">
    <?php 
    $llikers=0;
    if(count($likes)>0){
        $llikers=$likes[0]->likers;
    }
    if(count($ratinginfo)>0){
        $ratinginfo=$ratinginfo[0];
        if($ratinginfo->total>0){
            $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
        }else{
            $totalrating=0;
        }
    }
    ?>
    <meta name="twitter:label1" content="<?php echo ucfirst(Lang::choice('messages.rating',2));?>">
    <meta name="twitter:data1" content="<?php echo $totalrating.'/10';?>">
    <meta name="twitter:label2" content="<?php echo Lang::get('messages.likes');?>">
    <meta name="twitter:data2" content="<?php echo $llikers;?>">
    <meta name="twitter:app:id:iphone" content="709229893">
    <meta name="twitter:app:id:ipad" content="709229893">
    <meta name="twitter:app:id:googleplay" content="com.LetsEat.SufratiLite">
    <?php 
    if(count($menu)<=0&&count($pdfs)<=0){
        ?>
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <?php
    }
    ?>
</head>

<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')

    {{-- Breadcrumb Section Start --}}
    <section class="Breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <ul class="breadcrumb-nav">
                        <li>
                            <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>"
                                title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $restname;?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="breadcrumb-social">
                        <div class="social">
                            <a href="https://twitter.com/share"><i class="fa fa-twitter"></i> Tweet</a>
                        </div>
                        <div class="social">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Request::url();?>"><i
                                    class="fa fa-facebook"></i> Share</a>
                            {{-- <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Breadcrumb Section End --}}

    {{-- Restaurant Cover Start  --}}
    <section class="restaurant-cover">
        <div class="container">
            <div class="row covers">
                <div class="col-md-8 col-sm-12 cover-center">
                    {{-- Main Cover --}}
                    <div class="cover-image main-cover">
                        <?php if(count($cover)>0){ ?>
                        <img src="<?php echo Azooma::CDN('Gallery/'.$cover[0]->image_full);?>"
                            alt="<?php echo $restname;?>">
                        <?php }  else {
                            	$i = 0;
								$imagess = array("defualt_rest.jpg");
                                $random_image = array_rand($imagess);?>
                            <img src="<?php echo  asset('img/default/rest/'.$imagess[ $random_image]);?>"
                            alt="<?php echo $restname;?>">
                            <?php } ?>
                    </div>
                    <ul class="small-covers">
                        <?php $totalCovers=0; if(count($sufratiphotos)>0){  $i = 0;
                        foreach ($sufratiphotos as $photo) {  
                            if($i == 4) break;
                            if($lang=="en"){
                                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($rest->rest_Name);
                            }else{
                                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_Ar);
                            } ?>
                        <?php  $totalCovers++; if ($i != 3) {?>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>"
                                class="load-gallery-tab ajax-link">
                                <img itemprop="photo"
                                    src="<?php echo Azooma::CDN('Gallery/150x150/'.$photo->image_full);?>">
                            </a>
                        </li>
                        <?php } else {  ?>
                            
                        <li>
                            <a href="#gallary">
                                <img itemprop="photo"
                                    src="<?php echo Azooma::CDN('Gallery/150x150/'.$photo->image_full);?>">
                                <div class="more-photos">
                                    <div class="text-center">
                                        <div class="strong">
                                            + <?php echo count($sufratiphotos); ?>
                                        </div>
                                        <span><?php echo Lang::get('messages.show_all_photos');?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php  $i++;} } else {
                            $imagess = array("defualt_rest.jpg");
                            for($ie = 0; $ie < 4; $ie++){
                                $random_image = array_rand($imagess);

                            
                            ?>
                                <li>
                                    <a href="#"
                                        class="load-gallery-tab">
                                        <img itemprop="photo"
                                            src="<?php echo  asset('img/default/rest/'.$imagess[ $random_image]);?>">
                                    </a>
                                </li>

                        <?php } } if($totalCovers < 4 && count($sufratiphotos)>0){  
                        $imagess = array("defualt_rest.jpg");
                        $coverlen =  4 - $totalCovers;
                        for($ie = 0; $ie < $coverlen; $ie++){
                            $random_image = array_rand($imagess);

                        
                        ?>
                            <li>
                                <a href="#"
                                    class="load-gallery-tab">
                                    <img itemprop="photo"
                                        src="<?php echo  asset('img/default/rest/'.$imagess[ $random_image]);?>">
                                </a>
                            </li>

                        <?php } }?>
                        <li>
                            <div class="add-photo" id="add-photo-btn">
                                <div class="add-content">
                                    <img src="<?php echo asset('img/icons/camera.svg') ?>">
                                    <span><?php echo Lang::get('messages.add_photo');?></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 right-box">
                    {{-- Like Box --}}
                    <div class="likes">
                        <div class="small-mob">
                            <?php 
                            if($likes[0]->total!=0){
                                $percentage=round(($likes[0]->likers/$likes[0]->total)*100);
                            }else{
                                $percentage=0;
                            }
                            ?>
                            <div class="color">
                                <div class="big-num"><b><?php echo $percentage; ?></b>%</div>
                                <span><?php echo Lang::get('messages.like_it');?></span>
                            </div>
                            <div class="mob-total">
                                <div class="total">
                                    <?php echo '<b>'.$likes[0]->total.'</b> '.Lang::choice('messages.people_have_voted',$likes[0]->total);?>
                                </div>
                                <div class="user-images">
                                    <?php 
                        if(count($likers)>0){
                            foreach ($likers as $user) {
                                $userimage=($user->image=="")?'user-default.svg':$user->image;
                                $username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
                                    ?>
                                    <a href="<?php echo Azooma::URL('user/'.$user->user_ID);?>"
                                        title="<?php echo $username;?>">
                                        <img src="<?php echo Azooma::CDN('images/user_thumb/'.$userimage);?>"
                                            width="30" height="30" alt="<?php echo $username;?>" />
                                    </a>
                                    <?php
                            }
                        }
                        ?>
                                </div>
                                <hr>
                            </div>
                            <div id="rest-like-btns" class="btn-group mini-bottom">
                                <?php if(!Session::has('userid')||!isset($userliked)){ ?>
                                <a href="javascript:void(0)" class="rest-like-btn like-btn like"
                                    data-rest="<?php echo $rest->rest_ID;?>"><i class="fa fa-thumbs-up"></i>
                                    <?php echo Lang::get('messages.like_it');?></a>
                                <a href="javascript:void(0)" class="rest-like-btn like-btn dislike"
                                    data-rest="<?php echo $rest->rest_ID;?>"><i
                                        class="fa fa-thumbs-down"></i>
                                    <?php echo Lang::get('messages.dont_like_it');?></a>

                                <?php }else{  ?>
                                <a href="javascript:void(0)" class="like-btn liked active"
                                    data-liked="<?php echo $userliked->status;?>"
                                    data-rest="<?php echo $rest->rest_ID;?>"><i class="fa fa-thumbs-up"></i>
                                    <?php 
                                    if($userliked->status==1){
                                        echo Lang::get('messages.you_like_this');
                                    }else{
                                        echo Lang::get('messages.you_dont_like_this');
                                    }
                                    ?></a>
                                      <a href="javascript:void(0)" class="like-btn <?php if($userliked->status!=1){ echo 'like'; } else { echo 'dislike'; } ?>"
                                      data-rest="<?php echo $rest->rest_ID;?>"><i class="fa fa-thumbs-<?php if($userliked->status!=1){ echo 'up'; } else { echo 'down'; } ?>"></i>
                                      <?php 
                                      if($userliked->status!=1){
                                          echo Lang::get('messages.like_it');
                                      }else{
                                          echo Lang::get('messages.dont_like_it');
                                      }
                                      ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="add-list" id="add-to-list-btn">
                            <div>
                                <i class="fa fa-list"></i>
                                <?php echo Lang::get('messages.add_to_list'); ?>
                            </div>
                        </button>
                        <?php 
                            if(count($pdfs)>0){
                            $i=0;
                            foreach ($pdfs as $pdf) { 
                                $i++;
                                if($i>1){
                                    break;
                                }
                                $menuaa=$pdf->menu;
                                if($lang=="ar"&&$pdf->menu_ar!=""){
                                    $menuaa=$pdf->menu_ar;
                                }
                                ?>
                            <a target="_blank" class="pdf-download" href="aj/downloadmenu/<?php echo $rest->rest_ID?>/<?php echo $pdf->id?>" >
                                <div>
                                    <i class="fas fa-file-pdf"></i>
                                    <?php echo Lang::get('messages.download_pdf_menu'); ?>
                                </div>
                            </a>
                        </button>
                        <?php } } else{ ?>
                            <button disabled class="pdf-download"
                           >
                            <div>
                                <i class="fas fa-file-pdf"></i>
                                <?php echo Lang::get('messages.download_pdf_menu'); ?>
                            </div>
                        </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Restaurant Cover End  --}}

    {{-- Restaurant Main Info Start  --}}
    <section class="restaurant-header mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 rest-info-all">
                            <div class="info-detailes">
                                <div class="restaurant-logo">
                                    <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>"
                                        id="rest-profile-logo">
                                        <img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
                                    </a>

                                </div>
                                <div class="restaurant-title">
                                    <h1><?php echo $restname;?> - <?php echo $cityname; ?>
                                        <?php if(count($openhours)>0){
                                            if(($openhours[0]->week_days_start!="")&&($openhours[0]->week_days_close!="")&&($openhours[0]->week_ends_start!="")&&($openhours[0]->week_ends_close!="")){
                                        ?>
                                        <div class="res-status" id="rest-close-or-open">
                                            <?php
                                                $weekday=TRUE; 
                                                $date=date('w');
                                                if($city->country==1){
                                                    if($date==6||$date==5){
                                                        $weekday=FALSE;
                                                    }
                                                }else{
                                                    if($date==6||$date==0){
                                                        $weekday=FALSE;
                                                    }
                                                }
                                                if($weekday){
                                                    $opentime=$openhours[0]->week_days_start;
                                                    $closetime=$openhours[0]->week_days_close;
                                                }else{
                                                    $opentime=$openhours[0]->week_ends_start;
                                                    $closetime=$openhours[0]->week_ends_close;
                                                }
                                                $closetime=str_replace(' pm', '', $closetime);
                                                $closetime=str_replace(' am', '', $closetime);
                                                $opentime=str_replace(' am', '', $opentime);
                                                $opentime=str_replace(' pm', '', $opentime);
                                                if((date('H:i',strtotime($opentime)) <date('H:i')) && 
                                                    (
                                                    (date('H:i',strtotime($closetime))>date('H:i',strtotime('12:00')) &&
                                                    (date('H:i')<date('H:i',strtotime($closetime)))) || 
                                                    ( 
                                                    (date('H:i',strtotime($closetime))<date('H:i',strtotime('12:00'))) && 
                                                    (date('H:i')>date('H:i',strtotime('12:00')) ) 
                                                    )
                                                )
                                                ){
                                                    ?>
                                            <div class="online"><?php echo Lang::get('messages.online'); ?></div>
                                            <?php
                                                }else{
                                                    ?>
                                            <div class="offline"><?php echo Lang::get('messages.offline'); ?></div>
                                            <?php
                                                }
                                                ?>
                                        </div>
                                        <?php } } ?>
                                    </h1>
                                    <span><?php echo Lang::get('messages.a').' '.Azooma::LangSupport($rest->class_category);
                                        echo ($lang=="en")?' '.stripcslashes($rest->cuisine):' '.stripcslashes($rest->cuisineAr);
                                        if(count($type)>0){
                                            echo ($lang=="en")?stripcslashes(' '.$type[0]->name):stripcslashes(' '.$type[0]->nameAr);    
                                        }
                                        ?> - <?php $t=0; foreach ($cuisines as $cuisine) { $t++;
                                            ?>
                                        <a
                                            href="<?php echo Azooma::URL($city->seo_url.'/'.$cuisine->seo_url.'/restaurants');?>">
                                            <?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar); ?>
                                        </a>
                                        <?php  
                                            if($t!=count($cuisines)){
                                                echo ", ";
                                            }
                                        }
                                        ?></span>
                                    <div class="rate">
                                        <?php 
                                            if(count($ratinginfo)>0){
                                                ?>
                                        <div class="rating-stars">
                                            <?php 
                                            $totalrating = $totalrating /2;
                                                $k=5-round($totalrating);
                                                for($i=0;$i<round($totalrating);$i++){
                                                    echo '<i class="fa fa-star pink"></i>&nbsp;&nbsp;';
                                                }
                                                    for($i=0;$i<$k;$i++){
                                                        echo '<i class="fa fa-star"></i>';
                                                        if($i<($k-1)){
                                                            echo '&nbsp;&nbsp;';
                                                        }
                                                    }
                                                    ?>
                                        </div>

                                        <?php
                                                }
                                                ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="restaurant-actions">
                                <a href="<?php echo Azooma::ExtURL($rest->rest_WebSite);?>" target="_blank"><i
                                        class="fa fa-globe"></i>
                                    <?php echo Lang::get('messages.view_website');?></a>

                                <a href="#write-reviews" class="go-same-page"><i
                                        class="far fa-star"></i>
                                    <?php echo Lang::get('messages.write_review');?></a>

                                <a href="#locations" class="go-same-page"><i
                                        class="fas fa-location-arrow"></i>
                                    <?php echo Lang::get('messages.locations');?></a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#time"><i class="fa fa-clock-o"></i>
                                    <?php echo Lang::get('messages.open_hours');?> </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{-- Restaurant content Start --}}
                            <section class="restaruant-content">
                                <ul class="restaurant-nav">
                                    <li class="active" data-bs-target="about"><?php echo Lang::get('messages.about_us');?>
                                    </li>
                                    <li data-bs-target="menu"><?php echo Lang::get('messages.menu');?></li>
                                    <li data-bs-target="gallary"><?php echo Lang::get('messages.gallery');?></li>
                                    <li data-bs-target="reviews"><?php echo Lang::get('messages.reviews');?></li>
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 res-nav">
                                        <div class="restaurant-content about show">
                                            {{-- Overview --}}
                                            <?php
                                        $aboutdata=array(
                                            'rest'=>$rest,
                                            'restname'=>$restname,
                                            'cityname'=>$cityname,
                                            'cuisines'=>$cuisines,
                                            'city'=>$city,
                                            'lang'=>$lang,
                                            'mostagreedcomment'=>$mostagreedcomment,
                                            'features'=>$features,
                                            'restbranches'=>$restbranches,
                                            'openhours'=>$openhours,
                                            'minigallery'=>$minigallery,
                                            'pdfs'=>$pdfs,
                                        );                        
                                        ?>
                                            @include('rest.about',$aboutdata)
                                        </div>
                                        <div class="restaurant-content menu">
                                            <?php 
                                            $menudata=array(
                                                'rest'=>$rest,
                                                'restname'=>$restname,
                                                'city'=>$city,
                                                'lang'=>$lang,
                                                'menu'=>$menu,
                                                'pdfs'=>$pdfs,
                                            );    
                                        ?>
                                            @include('rest.menu',$menudata)
                                        </div>
                                        <div class="restaurant-content gallary">
                                            <?php 
                                        $gallerydata=array(
                                                'rest'=>$rest,
                                                'restname'=>$restname,
                                                'city'=>$city,
                                                'cityname'=>$cityname,
                                                'lang'=>$lang,
                                                'videos'=>$videos,
                                                'sufratiphotos'=>$sufratiphotos,
                                                'userphotos'=>$userphotos
                                            );
                                            ?>
                                            @include('rest.gallery',$gallerydata)
                                        </div>
                                        <div class="restaurant-content reviews">
                                            <?php 
                                        $reviewdata=array(
                                                'rest'=>$rest,
                                                'restname'=>$restname,
                                                'city'=>$city,
                                                'lang'=>$lang,
                                                'userreviews'=>$userreviews,
                                                'criticreviews'=>$criticreviews,

                                            );
                                            ?>
                                            @include('rest.reviews',$reviewdata)
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Restaurant content End --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 ">
                    <div class="restaurant-side">

                        <div class="rating">
                            <div class="head">
                                <h2><?php echo Lang::get('messages.rating_info'); ?></h2>

                                <span>
                                    <span style="font-size: 14px; margin:0 5px;">
                                    <?php 
                                    if(count($ratinginfo)>0){
                                        
                                        if ($totalrating > 0) {
                                            $totalrating = $totalrating;
                                            switch (TRUE) {
                                                case ($totalrating >= 1 && $totalrating < 3.5):
                                                    $ratingtext = "not_good";
                                                    break;
                                                case ($totalrating >= 3.5 && $totalrating < 5):
                                                    $ratingtext = "pleasant";
                                                    break;
                                                case ($totalrating >= 5 && $totalrating < 6.5):
                                                    $ratingtext = "good";
                                                    break;
                                                case ($totalrating >= 6.5 && $totalrating < 7):
                                                    $ratingtext = "very_good";
                                                    break;
                                                case ($totalrating >= 7 && $totalrating < 9.5):
                                                    $ratingtext = "superb";
                                                    break;
                                                case ($totalrating >= 9.5 && $totalrating <= 10):
                                                    $ratingtext = "excellent";
                                                    break;
                                            }
                                        }else{
                                            if($ratinginfo->total>0){
                                                $ratingtext='not_good';
                                            }else{
                                                $ratingtext='rate_it';    
                                            }
                                        }
                                        $totalrating = $totalrating;
                                        ?>
                                        <b><?php echo Lang::get('messages.'.$ratingtext);?></b>
                                        </span>
                                        <i
                                        class="fa fa-star pink"></i><?php echo '<span id="total-rating-value" itemprop="ratingValue">'.($totalrating).'</span>';?>
                                    <?php echo'(<span id="total-rating-count" itemprop="ratingCount">'.$ratinginfo->total.'</span>';?>)
                                    <?php  } ?>
                                </span>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.food');?> </span>
                                <div class="progress">
                                    <?php 
                                            $foodavg=0;
                                            if($ratinginfo->total>0){
                                                $foodavg=round($ratinginfo->totalfood/$ratinginfo->total);
                                            }
                                        ?>
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $foodavg; ?>"
                                        aria-valuemin="0" style="width:<?php echo $foodavg *10; ?>%" aria-valuemax="5">
                                    </div>
                                </div>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.service');?> </span>
                                <div class="progress">
                                    <?php 
                                           $serviceavg=0;
                                        if($ratinginfo->total>0){
                                            $serviceavg=round($ratinginfo->totalservice/$ratinginfo->total);
                                        }
                                        ?>
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $serviceavg; ?>" aria-valuemin="0"
                                        style="width:<?php echo $serviceavg *10; ?>%" aria-valuemax="5"></div>
                                </div>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.atmosphere');?> </span>
                                <div class="progress">
                                    <?php 
                                         $atmosphereavg=0;
                                        if($ratinginfo->total>0){
                                            $atmosphereavg=round($ratinginfo->totalatmosphere/$ratinginfo->total);
                                        }
                                        ?>
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $atmosphereavg; ?>" aria-valuemin="0"
                                        style="width:<?php echo $atmosphereavg *10; ?>%" aria-valuemax="5"></div>
                                </div>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.value');?> </span>
                                <div class="progress">
                                    <?php 
                                        $valueavg=0;
                                        if($ratinginfo->total>0){
                                            $valueavg=round($ratinginfo->totalvalue/$ratinginfo->total);
                                        }
                                        ?>
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $valueavg; ?>" aria-valuemin="0"
                                        style="width:<?php echo $valueavg *10; ?>%" aria-valuemax="5"></div>
                                </div>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.variety');?> </span>
                                <div class="progress">
                                    <?php 
                                        $varietyavg=0;
                                            if($ratinginfo->total>0){
                                                $varietyavg=round($ratinginfo->totalvariety/$ratinginfo->total);
                                            }
                                        ?>
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $varietyavg; ?>" aria-valuemin="0"
                                        style="width:<?php echo $varietyavg *10; ?>%" aria-valuemax="5"></div>
                                </div>
                            </div>
                            {{-- Rate Box --}}
                            <div class="rate-box">
                                <span class="prog-type"> <?php echo Lang::get('messages.presentation');?> </span>
                                <div class="progress">
                                    <?php 
                                            $presentationavg=0;
                                            if($ratinginfo->total>0){
                                                $presentationavg=round($ratinginfo->totalpresentation/$ratinginfo->total);
                                            }
                                        ?>
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="<?php echo $presentationavg; ?>" aria-valuemin="0"
                                        style="width:<?php echo $presentationavg*10; ?>%" aria-valuemax="5"></div>
                                </div>
                            </div>
                            <a href="#write-reviews" class="big-trans-btn go-same-page"><i class="fa fa-star"></i>
                                <?php echo Lang::get('messages.add_your_rating');?></a>
                      
                        </div>
                        <div class="business mt-4">
                            <hr>
                            <h3> <?php echo Lang::get('messages.work_here_claim_this').' '.Lang::get('messages.claim_this_business');?>
                            </h3>
                            <ul class="rest-claim-list">
                                <li>
                                    <?php echo Lang::get('messages.work_here_claim_this_helper_1');?>
                                </li>
                                <li>
                                    <?php echo Lang::get('messages.work_here_claim_this_helper_2');?>
                                </li>
                            </ul>
                            <button class="big-main-btn" id="claim-business-btn">
                                <?php echo '<i class="fa fa-briefcase"></i> '.Lang::get('messages.claim_this_business');?>
                            </button>
                        </div>
                 

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Restaurant Main Info End  --}}


 
    {{-- Time Modal --}}
    <div class="modal fade" id="time" tabindex="-1" aria-labelledby="Open Houres" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo Lang::get('messages.open_hours');?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                </div>
                <div class="modal-body open-hours">
                    <?php
                    if($openhours[0]->week_days_start!=""&&$openhours[0]->week_days_close!=""){ ?>
                    <div class="d-flex mb-4">
                        <div class="day">
                            <?php echo Lang::get('messages.weekday');?>
                        </div>
                        <div class="time">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->week_days_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->week_days_close);
                            $close=str_replace(' pm', '', $close);
                            if($city->country==1){
                                $weekdays="Su,Mo,Tu,We,Th";
                                $weekends="Fr,Sa";
                            }else{
                                $weekdays="Mo,Tu,We,Th,Fr";
                                $weekends="Sa,Su";
                            }
                            ?>
                            <time itemprop="openingHours"
                                datetime="<?php echo $weekdays.' '.$open.'-'.$close;?>"><?php echo $open.' to '.$close; ?></time>
                        </div>
                    </div>
                    <?php } 
                    if($openhours[0]->week_ends_start!=""&&$openhours[0]->week_ends_close!=""){ ?>
                    <div class="d-flex mb-4">
                        <div class="day">
                            <?php echo Lang::get('messages.weekend');?>
                        </div>
                        <div class="time">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->week_ends_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->week_ends_close);
                            $close=str_replace(' pm', '', $close);
                            ?>
                            <time itemprop="openingHours"
                                datetime="<?php echo $weekends.' '.$open.'-'.$close;?>"><?php echo $open.' to '.$close; ?></time>
                        </div>
                    </div>
                    <?php }
                    $checkramadan=Config::get('app.ramadan');
                    if($checkramadan){
                     if($openhours[0]->iftar_start!=""&&$openhours[0]->iftar_close!=""){ ?>
                    <div class=" overflow rest-timing-table">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.iftar');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                                $open=str_replace(' am', '', $openhours[0]->iftar_start);
                                $open=str_replace(' pm', '', $open);
                                $close=str_replace(' am', '', $openhours[0]->iftar_close);
                                $close=str_replace(' pm', '', $close);
                                ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php
                     }
                     if($openhours[0]->suhur_start!=""&&$openhours[0]->suhur_close!=""){ ?>
                    <div class="overflow rest-timing-table">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.suhur');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                                $open=str_replace(' am', '', $openhours[0]->suhur_start);
                                $open=str_replace(' pm', '', $open);
                                $close=str_replace(' am', '', $openhours[0]->suhur_close);
                                $close=str_replace(' pm', '', $close);
                                ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php
                     }   
                    }else{
                    if($openhours[0]->breakfast_start!=""&&$openhours[0]->breakfast_close!=""){ ?>
                    <div class="overflow rest-timing-table">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.breakfast');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->breakfast_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->breakfast_close);
                            $close=str_replace(' pm', '', $close);
                            ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php }
                    if($openhours[0]->brunch_start!=""&&$openhours[0]->brunch_close!=""){ ?>
                    <div class="overflow rest-timing-table">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.brunch');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->brunch_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->brunch_close);
                            $close=str_replace(' pm', '', $close);
                            ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php }
                    if($openhours[0]->lunch_start!=""&&$openhours[0]->lunch_close!=""){ ?>
                    <div class="overflow rest-timing-table">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.lunch');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->lunch_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->lunch_close);
                            $close=str_replace(' pm', '', $close);
                            ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php }
                    if($openhours[0]->dinner_start!=""&&$openhours[0]->dinner_close!=""){ ?>
                    <div class="overflow rest-timing-table last">
                        <div class="pull-left rest-timing-table-col1">
                            <?php echo Lang::get('messages.brunch');?>
                        </div>
                        <div class="pull-left rest-timing-table-col2">
                            <?php
                            $open=str_replace(' am', '', $openhours[0]->dinner_start);
                            $open=str_replace(' pm', '', $open);
                            $close=str_replace(' am', '', $openhours[0]->dinner_close);
                            $close=str_replace(' pm', '', $close);
                            ?>
                            <?php echo $open.' to '.$close; ?>
                        </div>
                    </div>
                    <?php }
                }
                     ?>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')

    <script type="text/javascript">
        var addthis_config = {
            "data_track_addressbar": false,
            'services_expanded': 'facebook,twitter,print,email',
            'services_compact': 'facebook,twitter,print,email',
            'ui_cobrand': 'Sufrati'
        };
    </script>
    {{-- Start Photo Upload Modal --}}
    <?php if(Session::has('userid')){ ?>
    <div class="modal" id="photo-upload-form" tabindex="-1" aria-labelledby="photo-upload-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5> <?php echo Lang::get('messages.add_your_photo'); ?> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo Azooma::URL($city->seo_url.'/aj/photo');?>" role="form" method="post"
                        enctype="multipart/form-data">

                        <div class="form-group row">
                            <input class="form-control " rows="3" name="photo-caption"
                                placeholder="<?php echo Lang::get('messages.photo_caption').'('.Lang::get('messages.photo_caption_helper').')';?>">
                        </div>
                        <div class="form-group row">

                            <div class="relative image-upload-btn" style="    height: 60px;">
                                <input type="file" name="photo" accept="image/*" class="photo-btn"
                                    onchange="readFile(this);" />
                            </div>
                            <p class="help-block">
                                <span
                                    style="color:red">*</span><?php echo Lang::get('messages.please_select_png_jpg');?>
                            </p>
                            <div class="image-placeholder">
                            </div>
                        </div>

                        <div class="form-group row">
                            <input type="hidden" name="rest" value="<?php echo $rest->rest_ID;?>" />
                            <button type="button"
                                class="submit-photo big-main-btn"><?php echo Lang::get('messages.submit');?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    {{-- End Photo Upload Modal --}}

    {{-- Start Claim Modal --}}
    <div class="modal" id="claim-pop" tabindex="-1" aria-labelledby="claim-pop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <?php echo Lang::get('messages.claim_your_restaurant');?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                </div>
        
                <div class="modal-body">
                    <div class="head">
                     
                        <span> <?php echo Lang::get('messages.claim_helper');?></span>
                    </div>
                    <?php if(Session::has('userid')){
                        $user=User::checkUser(Session::get('userid'),true);
                        $username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
                    } ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <form action="<?php echo Azooma::URL($city->seo_url.'/aj/claim');?>" method="post"
                                role="form" id="claim-rest-form">
                                <div class="form-group row">
                                    <input class="form-control required" type="text" name="claim_name" id="claim_name"
                                        placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.name');?>"
                                        <?php if(Session::has('userid')){?> value="<?php echo $username;?>"
                                        <?php } ?> />
                                </div>
                                <div class="form-group row">
                                    <input class="form-control required" type="email" name="claim_email"
                                        placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.email');?>"
                                        <?php if(Session::has('userid')){?> value="<?php echo $user->user_Email;?>"
                                        disabled="disabled" <?php } ?> />
                                </div>
                                <div class="form-group row">
                                    <input class="form-control required" type="tel" name="claim_tel"
                                        placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.number');?>" />
                                </div>
                                <div class="form-group row">
                                    <select class="form-control required" id="claim_position" name="claim_position">
                                        <option value=""><?php echo Lang::get('messages.your_position');?> </option>
                                        <option value="Owner"><?php echo Lang::get('messages.owner');?> </option>
                                        <option value="Manager"><?php echo Lang::get('messages.manager');?> </option>
                                        <option value="Employee"><?php echo Lang::get('messages.employee');?> </option>
                                        <option value="Other"><?php echo Lang::get('messages.other');?> </option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <input class="form-control" type="tel" name="headoffice"
                                        placeholder="<?php echo Lang::get('messages.head_office');?>" />
                                </div>
                                <div class="form-group row">
                                    <input class="form-control" type="text" name="website"
                                        placeholder="<?php echo Lang::get('messages.website');?>" />
                                </div>
                                <div class="form-group row">
                                    <textarea class="form-control" rows="3" name="comments"
                                        placeholder="<?php echo Lang::get('messages.additional_comments');?>"></textarea>
                                </div>
                                <input type="hidden" name="rest" value="<?php echo $rest->rest_ID;?>" />
                                <div class="form-group row">
                                    <button class="big-main-btn" type="submit"
                                        id="claim-restaurant-btn"><?php echo Lang::get('messages.claim_your_restaurant');?></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <h4>
                                <?php echo Lang::get('messages.claim_head_1');?>
                            </h4>
                            <p>
                                <?php echo Lang::get('messages.claim_desc_1');?>
                            </p>
                            <h4>
                                <?php echo Lang::get('messages.claim_head_2');?>
                            </h4>
                            <p>
                                <?php echo Lang::get('messages.claim_desc_2');?>
                            </p>
                            <h4>
                                <?php echo Lang::get('messages.claim_head_3');?>
                            </h4>
                            <p>
                                <?php echo Lang::get('messages.claim_desc_3');?>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- End Cllaim Modalaimb --}}

    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
 
    {{-- <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXFAxSgXP7b5D25WEtjxkYqoWM2PjxaLg&callback=initialize&libraries=places">
    </script> --}}
    <?php if(count($restbranches) > 0){ ?>
    <script>
        function initialize() {
            initMap();
            initMap2();
            }
        function initMap() {
            const myLatLng = {
                lat: <?php echo $restbranches[0] -> latitude ?> ,
                lng: <?php echo $restbranches[0] -> longitude ?>
            };
            const map = new google.maps.Map(document.getElementById("rest-map"), {
                zoom: 11,
                disableDefaultUI: true,
                mapTypeId: "roadmap",
                center: myLatLng,
            }); 
            <?php
            if (count($restbranches) > 0) {
                foreach($restbranches as $branch) {
                    ?>
                    var marker = new google.maps.Marker({
                        position: {
                            lat: <?php echo $branch -> latitude; ?> ,
                            lng : <?php echo $branch -> longitude; ?>
                        },
                        map,
                        url: "#<?php echo $restname; ?>",
                        title: "<?php echo $restname; ?>",
                        label: {
                            text: "<?php echo $restname; ?>",
                            color: "black",
                            fontSize: "8px"
                        }
                    });


                    <?php
                }
            } ?>
        }

        function initMap2() {
            const myLatLng = {
                lat: <?php echo $restbranches[0] -> latitude ?> ,
                lng: <?php echo $restbranches[0] -> longitude ?>
            };
            const map = new google.maps.Map(document.getElementById("rest-map-2"), {
                zoom: 11,
                disableDefaultUI: true,
                mapTypeId: "roadmap",
                center: myLatLng,
            }); 
            <?php
            if (count($restbranches) > 0) {
                $i = 0;
                foreach($restbranches as $branch) {
                    $i++;
                    ?>
                    var marker = new google.maps.Marker({
                        position: {
                            lat: <?php echo $branch -> latitude; ?> ,
                            lng : <?php echo $branch -> longitude; ?>
                        },
                        map,
                        url: "#<?php echo $restname; ?>",
                        title: "<?php echo $i; ?>",
                        label: {
                            text: "<?php echo $i; ?>",
                            color: "black",
                            fontSize: "8px"
                        }
                    });


                    <?php
                }
            } ?>
        }
    </script>
    <?php } ?>
    <script src="<?php echo URL::asset('js/restaurant.js');?>"></script>
    <script>
        $(window).on( 'hashchange', function(e) {
        var ar = ""+decodeURIComponent(location.hash)+"";
        ar = ar.replace(/\s/g, '').substr(1);
        $('.restaurant-nav li').removeClass('active');
        $("[data-bs-target='"+ar+"']").addClass('active');
        $('.res-nav .show').removeClass('show');
        $('.res-nav .' + ar).addClass('show');
        });
        if(window.location.hash) {
        var ar = ""+decodeURIComponent(location.hash)+"";
        ar = ar.replace(/\s/g, '').substr(1);
        $('.restaurant-nav li').removeClass('active');
        $("[data-bs-target='"+ar+"']").addClass('active');
        $('.res-nav .show').removeClass('show');
        $('.res-nav .' + ar).addClass('show');
        } 
</script>
<script type="text/html" id="add-to-list-form-tpl">
    <div class="modal-content center-model" id="add-to-list-form">
        <div class="modal-header">
            <h5 class="modal-title">   <?php echo Lang::get('messages.my_lists');?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
        </div>
        <div class="modal-body">
            <form role="form" method="post" action="<?php echo Azooma::URL($city->seo_url.'/aj/addtolist');?>">
                <?php if(isset($userlists)) { ?>
                <?php foreach ($userlists as $list) { ?>
                <div class="checkbox form-group d-flex justify-content-between">
                    <label>
                        <input class="form-check-input" type="checkbox" name="userlist[]" id="userlist<?php echo $list->id;?>" value="<?php echo $list->id;?>" <?php if(isset($userlisthasrestaurant)&&isset($userlisthasrestaurant[$list->id])){ echo 'checked'; } ?>/> 
                            <span style="padding:0 5px"><?php echo stripcslashes($list->name);?></span>
                        </label>
                        <a class="pull-right normal-text" target="_blank" href="<?php echo Azooma::URL('user/'.Session::get('userid').'#lists');?>"><i class="fa fa-list-ul"></i></a>

                </div>
                <?php }  } ?>
                <div class="input-group has-feedback">
                    <span class="input-group-text" id="basic-addon1">  <i class="fa fa-plus form-control-feedback"></i></span>
                    <input class="form-control" type="text" name="new-user-list" id="new-user-list" placeholder="<?php echo Lang::get('messages.add_new_list');?>"/> 
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 d-md-flex justify-content-end">
                        <button type="button" class="btn btn-light btn-lg btn-block sufrati-close-popup"><?php echo Lang::get('messages.cancel');?></button>
                        <input type="hidden" name="rest" value="<?php echo $rest->rest_ID;?>"/>
                        <button type="button" class="big-main-btn" id="save-to-list-btn"><?php echo Lang::get('messages.add_to_list');?></button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
    </div>
</script>
<script src="<?php echo URL::asset('js/branch.js');?>"></script>
</body>

</html>