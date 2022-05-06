<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(count($video)>0){
        if($lang=="en"||($lang=="ar"&&$video[0]->youtube_ar=="")){
            parse_str( parse_url( $video[0]->youtube_en, PHP_URL_QUERY ), $var );
        }else{
            parse_str( parse_url( $video[0]->youtube_ar, PHP_URL_QUERY ), $var );
        }
        
        $youtube="";
        if(isset($var['v'])){
            $youtube=$var['v'];
        }
    }
    ?>
    <meta property="og:video:type" content="application/x-shockwave-flash" />
    <meta property="og:video" content="http://www.youtube.com/v/<?php echo $youtube;?>" />
    <meta property="og:video:secure_url" content="https://www.youtube.com/v/<?php echo $youtube;?>" />
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <div class="sufrati-white-box" id="n">
        <div class="spacing-container">
        </div>
        <div class="container">
            <div>
                <div class="pull-left">
                    <ol class="breadcrumb" itemprop="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> 
                            <a href="<?php echo Azooma::URL();?>" title="<?php echo Lang::get('messages.azooma');?>">
                            <?php echo Lang::get('messages.azooma'); ?></a>
                        </a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL('videos');?>" title="<?php echo Lang::choice('messages.restaurants',1).' '.Lang::get('messages.videos');?>">
                                <?php echo Lang::get('messages.videos');?>    
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $videoname;?>
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
                    <?php echo $videoname;?>
                </h1>
            </div>
        </div>
    </div>
    <div>
        <div class="spacing-container">
        </div>
        
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 full-page no-border">
                        <div class="sufrati-white-box put-border" id="youtube-player">
                            <?php
                            if(count($video)>0){
                                if($lang=="en"||($lang=="ar"&&$video[0]->youtube_ar=="")){
                                    parse_str( parse_url( $video[0]->youtube_en, PHP_URL_QUERY ), $var );
                                }else{
                                    parse_str( parse_url( $video[0]->youtube_ar, PHP_URL_QUERY ), $var );
                                }
                                
                                $youtube="";
                                if(isset($var['v'])){
                                    $youtube=$var['v'];
                                }
                                ?>
                                <iframe width="682" height="350" src="http://www.youtube.com/embed/<?php echo $youtube;?>" frameborder="0" allowfullscreen=""></iframe>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <div id="social-share-list">
                            <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <h2 class="rest-page-second-heading">
                            <?php echo Lang::get('messages.other').' '.Lang::get('messages.videos');?>
                        </h2>
                        <div class="spacing-container">
                        </div>
                        <div class="overflow">
                        <?php
                        if(count($videos)>0){
                            $i=0;
                            ?>
                            <ul id="sufrati-other-videos-list" class="sufrati-gallery-list sufrati-video-gallery">
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
                                $videoname=($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar);
                                $videoname=ucfirst($videoname);
                                ?>
                                <li class="<?php if($i%4==0){ echo "last-image "; } ?>video-thumb ">
                                    <a class="image rest-logo gallery-image" href="<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>" >
                                        <img src="http://img.youtube.com/vi/<?php echo $youtube;?>/mqdefault.jpg" alt="<?php echo$videoname; ?>">
                                    </a>
                                    <div class="inner-padding sufrati-white-box overflow put-border">
                                        <div class="video-title">
                                            <a href="<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>" title="<?php echo $videoname; ?>">
                                                <?php echo (strlen($videoname)>40)?mb_substr($videoname, 0,40,'UTF-8').'..':$videoname; ?>
                                            </a>
                                        </div>
                                        <div class="video-date">
                                            <time>
                                                <?php echo Azooma::ago($video->add_date);?>
                                            </time>
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
                    <div class="sufrati-main-col-3 sufrati-white-box">
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Sufrati'};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
</body>
</html>