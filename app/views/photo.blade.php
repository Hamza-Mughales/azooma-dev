<!doctype html>
<html lang="<?php echo $lang;?>" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# Azoomaletseat: http://ogp.me/ns/fb/sufratiletseat#">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
    <meta property="fb:app_id" content="268207349876072"/> 
    <meta property="og:type" content="sufratiletseat:photo"/> 
    <meta property="og:url" content="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>"/> 
    <meta property="og:title" content="<?php echo $photoname;?>"/> 
    <meta property="og:image" content="<?php echo Azooma::CDN('/Gallery/'.$photo->image_full);?>"/> 
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <?php ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
    <div class="Azooma-white-box" id="n">
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
                        <?php if(count($city)>0){ ?>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <?php }
                        if(count($rest)>0){
                            $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_ar);
                            ?>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
                                <?php echo $restname; ?>
                            </a>
                        </li>
                            <?php
                        }
                         ?>
                        <li class="active">
                            <?php echo $photoname;?>
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
    </div>
    <div>
        <div class="Azooma-head">
            <div class="container">
                <h1>
                    <?php echo $photoname;?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div>
        
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="Azooma-main-col">
                <div class="col-mask-left">
                    <div class="Azooma-main-col-1 Azooma-white-box">
                        <div id="social-share-list">
                            <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <div id="photo-holder" class="overflow">
                            <img src="<?php echo Azooma::CDN('/Gallery/'.$photo->image_full);?>" alt="<?php echo $photoname;?>" width="<?php echo $width;?>" height="<?php echo $height;?>"/>
                        </div>
                    </div>
                    <div class="Azooma-main-col-2">
                    </div>
                    <div class="Azooma-main-col-3 Azooma-white-box">
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/html" id="photo-copyright-holder-tpl">
    <div id="photo-copyright-pop">
    <div class="Azooma-popup-box">
        <div class="super-popup-image stand-alone">
            <h3 class="popup-heading Azooma-head">
                <?php echo Lang::get('messages.do_you_want_to_use_this_image');?>
            </h3>
            <div>
                <?php echo Lang::get('messages.please_copy_paste');?>
            </div>
            <div class="textbox">
                <textarea rows="4" readonly="yes"><a href="<?php echo Azooma::URL('rest/'.$photo->seo_url);?>"><img src="<?php echo Azooma::CDN('/Gallery/'.$photo->image_full);?>" alt="<?php echo $photoname;?>" width="<?php echo $width;?>" height="<?php echo $height;?>"/></a><br/><?php echo Lang::get('messages.photo_of_rest_brought_to_you_by_sufrati',array('restname'=>$restname));?></textarea>
            </div>
            <div class="small">
                <?php echo Lang::get('messages.copy_this_code_to_use_the_image').', '.Lang::get('messages.all_images_property_of_sufrati');?>
            </div>
        </div>
    </div>
    </div>
    </script>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Azooma'};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
</body>
</html>