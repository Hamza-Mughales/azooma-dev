<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
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
                            <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                            <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo Lang::get('messages.gallery');?>
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

    {{-- Azooma Tabs Nav Section Start --}}
    <section class="azooma-tabs-nav">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li class="active"><a href="#photos"> <?php echo Lang::get('messages.photos');?></a></li>
                        <li><a href="#videos">   <?php echo Lang::get('messages.videos');?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Azooma Tabs Nav Section End --}}
    {{-- Gallary Start --}}
    <section class="gallary">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                {{-- Azooma Tabs Div Section Start --}}
                <section class="azooma-tabs-dev">
                        <div class="row">
                            <div class="col-12">
                                <div class="azooma-tab show" data-bs-target="photos">
                                    <div class="tab-head">
                                        <h2>  <?php echo Lang::get('messages.photos');?></h2>
                                        <a href="<?php echo Azooma::URL($city->seo_url.'/photos');?>" title="<?php echo Lang::get('messages.view_all').' '.Lang::get('messages.photos');?>" >
                                            <?php echo Lang::get('messages.view_all');?>
                                        </a>
                                    </div>
                                    <?php
                                    if(count($sufratiphotos)>0){
                                        $i=0;
                                        ?>
                                        <ul class="restaruant-images-gallary mb-4">
                                        <?php
                                        foreach ($sufratiphotos as $photo) {
                                            $photoname=($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar);
                                            $i++;
                                            ?>
                                            <li>
                                                <div class="image-block"  onclick="window.location='<?php echo Azooma::URL($city->seo_url.'/photos');?>'">
                                                    <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>" alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
                                                    <div class="image-info" data-bs-toggle="modal" data-bs-target="#img<?php echo $photo->image_ID;?>">
                                                        <h3 class="title"><?php echo $photoname; ?></h3>
                                                    </div>
                                                   <?php 
                                                    if(Session::has('userid')){
                                                        $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
                                                    }
                                                    if(Session::has('userid')&&$checkuserliked>0){
                                                        ?>
                                                        <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                                                            <i class="fas fa-heart"></i> <?php echo $photo->likes ?>
                                                        </button>
                                                        <?php
                                                    }else{
                                                    ?>
                                                        <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                                                            <i class="far fa-heart"></i> <?php echo $photo->likes ?>
                                                        </button>
                                                    <?php } ?>
                                                    </div>      
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="azooma-tab" data-bs-target="videos">
                                    <div class="tab-head">
                                        <h2>
                                            <?php echo Lang::get('messages.videos');?>
                                        </h2>
                                        <a href="<?php echo Azooma::URL('videos');?>" title="<?php echo Lang::get('messages.view_all').' '.Lang::get('messages.videos');?>">
                                            <?php echo Lang::get('messages.view_all');?>
                                        </a>
                                    </div>
                                    <?php
                                    if(count($videos)>0){
                                        $i=0;
                                        ?>
                                        <ul class="restaruant-images-gallary mb-4">
                                        <?php
                                        foreach ($videos as $video) {
                                            $i++;
                                            if($lang=="en"||($lang=="ar"&&$video->youtube_ar=="")){
                                                parse_str( parse_url( $video->youtube_en, PHP_URL_QUERY ), $var );
                                            }else{
                                                parse_str( parse_url( $video->youtube_ar, PHP_URL_QUERY ), $var );
                                            }
                                            
                                            $youtube="";
                                            if(isset($var['v'])){
                                                $youtube=$var['v'];
                                            }
                                            ?>
                                            <li class="<?php if($i%3==0){ echo "last-image "; } ?>video-thumb ">
                                            <div class="video-block" onclick="window.location='<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>'">
                                                <img src="http://img.youtube.com/vi/<?php echo $youtube;?>/mqdefault.jpg" alt="<?php echo ($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar); ?>">
                                                <div class="image-info" data-bs-toggle="modal" data-bs-target="#img<?php echo $photo->image_ID;?>">
                                                    <h3 class="title">   <?php echo ($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar); ?></h3>
                                                </div>
                                            </div>      
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                </section>
                {{-- Azooma Tabs Div Section End --}}
            </div>
            <div class="col-md-4 col-sm-12">
                @include('inc.rightcol')
            </div>
        </div>
    </div>
</section>
    {{-- Gallary End --}}

 
      
    @include('inc.footer')
</body>
</html>