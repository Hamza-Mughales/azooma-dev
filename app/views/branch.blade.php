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
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname.' '.$cityname;?>">
                                <?php echo $restname;?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $branchname;?>
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
                    <?php echo $restname.' - '.$branchname;?>
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
                        <div class="hidden"><?php echo Lang::get('messages.a').' '.Lang::choice('messages.branch_branches',1).' '.Lang::get('messages.of').' ';?><span itemscope itemtype="http://schema.org/Restaurant">
                            <a itemprop="url" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo $restname.' '.Lang::get('messages.inplace',array('name'=>$cityname));?>"><span itemprop="name"><?php echo $restname;?></span></a>
                        </span></div>
                        <?php
                        $tel='';
                        if(strlen($branch->br_number)>7){
                            $tel=$branch->br_number;
                        }else{
                            if($branch->br_mobile!=''){
                                $tel=$branch->br_mobile;
                            }else{
                                if($branch->br_toll_free!=''){
                                    $tel=$branch->br_toll_free;
                                }else{
                                    if($rest->rest_TollFree!=''){
                                        $tel=$rest->rest_TollFree;
                                    }
                                }
                            }
                        }
                        if($branch->latitude!=""&&$branch->longitude!=""){ ?>
                        <div id="branch-page">
                            <div id="branch-map-container" class="ind-page">
                            </div>
                            <?php if($tel!=""){ ?>
                                    <button class="btn btn-light btn-lg" type="button">
                                        <?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i> 
							<?php } ?> <span itemprop="telephone" content="<?php echo $tel;?>"><?php echo $tel;?></span>
                                    </button>
                            <?php } ?>
                        </div>
                        <?php }else{
                        if($tel!=""){ ?>
                                <button class="btn btn-light btn-lg" type="button">
                                    <?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i> 
							<?php } ?> <span itemprop="telephone" content="<?php echo $tel;?>"><?php echo $tel;?></span>
                                </button>
                        <?php }  } ?>
                        <div class="spacing-container"></div>
                        <div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dl class="dl-horizontal">
                                        <dt>
                                            <?php echo Lang::get('messages.location');?>
                                        </dt>
                                        <dd>
                                            <address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                                <?php echo ($lang=="en")?stripcslashes($branch->br_loc).' '.stripcslashes($branch->district_Name).' '.stripcslashes($branch->city_Name):stripcslashes($branch->br_loc_ar).' '.stripcslashes($branch->district_Name_ar).' '.stripcslashes($branch->city_Name_ar);?>
                                                <?php if($lang=="en"&&$branch->br_loc!=""){
                                                    ?>
                                                    <span itemprop="streetAddress">
                                                        <?php echo stripcslashes($branch->br_loc);?>
                                                    </span>
                                                    <?php
                                                }
                                                if($lang!="en"&&$branch->br_loc_ar!=""){
                                                    ?>
                                                    <span itemprop="streetAddress">
                                                        <?php echo stripcslashes($branch->br_loc_ar);?>
                                                    </span>
                                                    <?php
                                                }
                                                if($lang=="en"&&$branch->district_Name!=""){
                                                ?>
                                                    <span itemprop="addressLocality">
                                                        <?php echo stripcslashes($branch->district_Name);?>
                                                    </span>
                                                <?php
                                                }
                                                if($lang!="en"&&$branch->district_Name_ar!=""){ ?>
                                                    <span itemprop="addressLocality">
                                                        <?php echo stripcslashes($branch->district_Name_ar);?>
                                                    </span>
                                                <?php }?>
                                                <span itemprop="addressRegion">
                                                    <?php echo $cityname;?>
                                                </span>
                                            </address>
                                        </dd>
                                        <dt>
                                            <?php echo Lang::get('messages.branch_type');?>
                                        </dt>
                                        <dd>
                                            <?php echo Azooma::LangSupport($branch->branch_type);?>
                                        </dd>
                                        <dt>
                                            <?php echo Lang::get('messages.seatings_rooms');?>
                                        </dt>
                                        <dd>
                                            <?php
                                            $seatings=explode(',', $branch->seating_rooms);
                                            if(count($seatings)>0){
                                                $i=0;
                                                foreach ($seatings as $seating) {
                                                    echo Azooma::LangSupport($seating);
                                                    $i++;
                                                    if($i!=count($seatings)){
                                                        echo ', ';
                                                    }
                                                }
                                            }
                                            ?>
                                        </dd>
                                    </dl>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>
                                        <?php echo Lang::get('messages.mood_atmosphere');?>
                                    </dt>
                                    <dd>
                                        <?php
                                        $moods=explode(',', $branch->mood_atmosphere);
                                        $i=0;
                                        if(count($moods)>0){
                                            foreach ($moods as $mood) {
                                                echo Azooma::LangSupport($mood);
                                                $i++;
                                                if($i!=count($moods)){
                                                    echo ', ';
                                                }   
                                            }
                                        }
                                        ?>
                                    </dd>
                                    <dt>
                                        <?php echo Lang::get('messages.features_services');?>
                                    </dt>
                                    <dd>
                                        <?php
                                        $features=explode(',', $branch->features_services);
                                        $i=0;
                                        if(count($features)>0){
                                            foreach ($features as $feature) {
                                                echo Azooma::LangSupport($feature);    
                                                $i++;
                                                if($i!=count($features)){
                                                    echo ', ';
                                                }
                                            }
                                        }
                                        ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-menu');?>" class="btn btn-camera btn-sm"><?php echo $restname.' '.Lang::get('messages.menu');?></a>&nbsp;&nbsp;
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-reviews');?>" class="btn btn-primary btn-sm"><?php echo $restname.' '.Lang::choice('messages.review',2).' '.Lang::get('messages.and').' '.ucfirst(Lang::get('messages.ratings'));?></a>&nbsp;&nbsp;
                            <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'#rest-gallery');?>" class="btn btn-success btn-sm"><?php echo $restname.' '.Lang::get('messages.photos').' '.Lang::get('messages.and').' '.Lang::get('messages.videos');?></a>
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
    <script type="text/javascript">
    <?php if($branch->latitude!=""&&$branch->longitude!=""){
        ?>
        var latitude=<?php echo $branch->latitude;?>, longitude=<?php echo $branch->longitude;?>,title="<?php echo $restname.' - '.$branchname;?>";
        <?php
        if($branch->zoom!=''){
            ?>
            var zoomorig=<?php echo $branch->zoom;?>;
            <?php
        }
    }
    ?>
    require(['branch'],function(){});
    </script>
</body>
</html>