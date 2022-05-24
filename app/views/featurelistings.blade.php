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
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo Lang::choice('messages.restaurants',1).' '.Lang::get('messages.features_services');?>
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
                    <?php echo Lang::choice('messages.restaurants',1).' '.Lang::get('messages.features_services').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>
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
                    <div class="spacing-container">
                    </div>
                        <?php
                        $i=0;
                        if(count($features)>0){
                            $i=0;
                            foreach ($features as $feature) {
                                if($i%13==0){
                                    ?>
                            <div class="col-md-6">
                                <ul class="listings-list">
                                    <?php
                                }
                                ?>
                                <li>
                                    <a href="<?php echo Azooma::URL($city->seo_url.'/restaurants/'.$feature['category'].'/'.$feature['name']);?>" title="<?php echo Azooma::LangSupport($feature['name']); echo ' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)); ?>">
                                        <?php echo Azooma::LangSupport($feature['name']);?>
                                    </a> - <span><?php $total=MCuisine::getTotalRestaurantsFeature($feature['name'],$city->city_ID,$feature['category']);
                                    echo $total;
                                    ?></span>
                                </li>                       
                                <?php
                                $i++;
                                if(($i%13==0)||($i==count($features))){
                                    ?>
                                    </ul>
                                </div>
                                    <?php
                                }
                            }
                        }
                        ?>
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
    <script type="text/javascript">
        require(['popular'],function(){});
    </script>
</body>
</html>