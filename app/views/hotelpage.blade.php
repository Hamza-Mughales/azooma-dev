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
    <div class=" Azooma-white-box" id="n">
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
                            <a href="<?php echo Azooma::URL($city->seo_url.'/hotels');?>" title="<?php echo $cityname.' '.Lang::choice('messages.hotels',2);?>">
                                <?php echo Lang::choice('messages.hotels',2);?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo ($lang=="en")?stripcslashes($hotel->hotel_name):stripcslashes($hotel->hotel_name_ar);?>
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
                    <?php echo ($lang=="en")?stripcslashes($hotel->hotel_name):stripcslashes($hotel->hotel_name_ar);?>
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
                        <h2 class="rest-page-second-heading">
                            <?php echo ($lang=="en")?stripcslashes($hotel->hotel_name):stripcslashes($hotel->hotel_name_ar);?>
                        </h2>
                        <div class="spacing-container"></div>
                        <div>
                            <?php $i=0; foreach ($restaurants as $rest) {  $i++;
                                $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
                            ?>
                            <div class="overflow <?php if($i==count($restaurants)){ echo 'last-child'; } ?> Azooma-mini-list"> 
                                <div class="pull-left">
                                    <div>
                                        <strong>
                                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname;?>">
                                                <?php echo $restname;?>
                                            </a>
                                        </strong>
                                    </div>
                                    <div class="small">
                                        <b><?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr);?></b>
                                        <?php echo ($lang=="en")?stripcslashes($rest->type):stripcslashes($rest->typeAr);?>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <strong><?php echo $rest->telephone;?></strong>
                                </div>
                            </div>
                            <?php } ?>
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
    @include('inc.footer')
</body>
</html>