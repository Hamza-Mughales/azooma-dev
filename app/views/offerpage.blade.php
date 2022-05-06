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
    <?php 
    ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar);
    ?>
    <div class="sufrati-white-box" id="n">
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
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/offers');?>" title="<?php echo $cityname.' '.Lang::get('messages.special_offers');?>">
                                <?php echo Lang::get('messages.special_offers');?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $offername;?>
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
                    <?php echo $meta['title'];?>
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
                            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <h2 class="rest-page-second-heading">
                            <?php echo $offername;?>
                        </h2>
                        <div>
                            <?php echo ($lang=="en")?stripcslashes(html_entity_decode($offer->longDesc)):stripcslashes($offer->longDescAr); ?>
                        </div>
                        <div >
                            <?php
                            if($offer->contactPhone!=""){
                                ?>
                                <p><button class="btn btn-light btn-lg">
                                <?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i> 
							<?php } ?>
                             <?php echo $offer->contactPhone;?></button>
                        </p>
                                <?php
                            }else{
                                if($restaurant->telephone!=""){ ?>
                                <p><button class="btn btn-light btn-lg"><?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i>
							<?php } ?></i> <?php echo $restaurant->telephone;?></button></p>
                                <?php } 
                                }
                            ?>
                        </div>
                        <div>
                            <?php if($branchcount==count($branches)){
                                ?>
                                <a href="<?php echo Azooma::URL($city->seo_url.'/'.$restaurant->seo_url.'#n');?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                    <?php echo Lang::get('messages.available_all_branches',array('name'=>$cityname));?>
                                </a>
                                <?php
                            }else{
                                ?>
                                <b>
                                    <?php echo Lang::get('messages.available_at_these_branches');?>
                                </b>
                                <ul>
                                <?php
                                foreach ($branches as $branch) {
                                    ?>
                                    <li>
                                        <a href="">
                                            <?php echo ($lang=="en")?stripcslashes($branch->br_loc):stripcslashes($branch->br_loc_ar); ?>
                                            <?php echo ' - '.($lang=="en")?stripcslashes($branch->district_Name):stripcslashes($branch->district_Name_Ar); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="spacing-container"></div>
                        <div id="offer-image">
                            <?php $offerimage=$offer->image;
                            if(($lang!="en")&&($offer->imageAr!="")){
                                $offerimage=$offer->imageAr;
                            }
                            if($offerimage!=""){
                                ?>
                                <img src="<?php echo Azooma::CDN('images/offers/'.$offerimage);?>" alt="<?php echo $offername;?>" />
                                <?php
                            }
                            ?>
                        </div>
                        <div class="spacing-container"></div>
                        <?php 
                        $terms=$offer->terms;
                        if($lang!="en"&&$offer->termsAr!=""){
                            $terms=$offer->termsAr;
                        }
                        if($terms!=""){ 
                        ?>
                        <div>
                            <h6>
                                <?php echo Lang::get('messages.terms_conditions');?>
                            </h6>
                            <div>
                                <?php echo $terms;?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="sufrati-main-col-2">
                    </div>
                    <div class="sufrati-main-col-3 sufrati-white-box">
                        <div class="right-col-block">
                            <div class="right-col-head">
                                <?php  echo Lang::get('messages.other').' '.Lang::get('messages.special_offers');?>
                            </div>
                            <div class="right-col-desc">
                              <ul>
                                <?php
                                if(count($relatedoffers)>0){
                                    foreach ($relatedoffers as $offer) {
                                ?>
                                <li>
                                    <a href="<?php echo Azooma::URL($city->seo_url.'/offer/'.$offer->id);?>" title="<?php echo ($lang=="en")?stripcslashes($offer->offerName):stripcslashes($offer->offerNameAr); ?>">
                                        <?php echo ($lang=="en")?stripcslashes($offer->offerName):stripcslashes($offer->offerNameAr); ?>
                                    </a>
                                </li>
                                <?php        
                                    }
                                }
                                ?>
                              </ul>  
                            </div>
                        </div>
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
    <script type="text/javascript" >
    require(['popular'],function(){});
    </script>
</body>
</html>