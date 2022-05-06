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
                            <?php echo Lang::get('messages.browse_by_cuisines');?>
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

    {{-- Categories List Start --}}
    <section class="categories-list">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2><?php echo $mycuisine .' '. Lang::get('messages.cuisines').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php 
                    foreach ($cuisines as $cuisine) {
                    $cuisinename=(Config::get('app.locale')=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);
                    ?>
                    <div class="list-cuisine">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cus<?php echo $cuisine->cuisine_ID ?>" aria-expanded="true" aria-controls="collapseOne">
                                <h2>    <?php echo $cuisinename; ?> - <?php echo $cuisine->total; ?></h2>    
                                </button>
                             
                              </h2>
                              <div id="cus<?php echo $cuisine->cuisine_ID ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="list-content">
                                        <div class="row restaurants-boxes">
                                            <?php 
                                                $this->MPopular = new MPopular();
                                                $cuid= $cuisine->cuisine_ID;
                                                $restaurants = $this->MPopular->getPopularResults('popular',$city->city_ID,$cuid, '','', '', "popular", 4,0,'', '', false,false);
                                                foreach ($restaurants as $rest ) { 
                                                    $nameID = str_replace(' ', '', $rest->name);
                                                    $resbanner = $rest->thephoto;
                                                    ($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
                                                    $restlogo=$rest->logo;
                                                    if($restlogo==""){
                                                        $restlogo="default_logo.gif";
                                                    }
                                                    $ratinginfo= MRestaurant::getRatingInfo($rest->id);
                                                    $likes= MRestaurant::getRestaurantLikeInfostatic($rest->id);
                                                    if(count($ratinginfo)>0){
                                                        $ratinginfo=$ratinginfo[0];
                                                        if($ratinginfo->total>0){
                                                            $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
                                                        }else{
                                                            $totalrating=0;
                                                        }
                                                    }
                                                    ?>
                                                    {{-- Resturant Box Start --}}
                                               
                                                    <div class="col-md-2 col-md-4 col-sm-6 col-xs-6 gold-box"  id="<?php echo $nameID?>" onClick="location.href='<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>'"  >
                                                        <div class="resturant-box">
                                                            <div class="box-img">
                                                                <?php if($resbanner!=""){ ?>
                                                                    <img  onClick="location.href='<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>'" class="rest-banner" src="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" alt="<?php echo $restname;?>"/>
                                                                    <?php } else { ?>
                                                                        <div class="rest-default-img"></div>
                                                                    <?php } ?>
                                                                <div class="logo">
                                                                    <img itemprop="logo" src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" />
                                                                </div>
                                                                <?php  if (property_exists($rest, 'latitude') && property_exists($rest, 'longitude')) { ?>
                                                                <input type="number" value="<?php echo $rest->latitude ?>" class="laten" style="display: none">
                                                                <input type="number" value="<?php echo $rest->longitude ?>" class="langen" style="display: none">
                                                                <?php } ?>
                                                                <input type="text" value="<?php echo $restname ?>" class="restname" style="display: none">
                                                            </div>
                                                            <div  onClick="location.href='<?php echo Azooma::URL($city->seo_url.'/'.$rest->url.'#n');?>'" class="box-details">
                                                                <div class="box-info">
                                                                    <div class="info-title">
                                                                        <h3><?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?></h3>
                                                                        
                                                                    </div>
                                                                    <div class="info-rate">
                                                                        <?php 
                                                                        if(count($ratinginfo)>0){
                                                                            ?>
                                                                        <div class="rating-stars">
                                                                            <i class="fa fa-star pink"></i>
                                                                        </div>
                                            
                                                                        <?php
                                                                            }?>  <?php echo '<span class="total-rating" itemprop="ratingValue">'.($totalrating/2).' </span> ('.$ratinginfo->total.')' ; ?>
                                                                    </div>
                                                                    <div class="info-type">
                                                                        <?php echo Azooma::LangSupport($rest->class_category);?></b>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->cuisine):stripcslashes($rest->cuisineAr); ?>&nbsp;<?php echo ($lang=="en")?stripcslashes($rest->type):stripcslashes($rest->typeAr);?>
                                                                    </div>
                                                                
                                                                </div>
                                                                <div class="box-icon">
                                                                    <div class="likes-number">
                                                                        <i class="fa fa-heart"></i> <?php echo $likes[0]->total;?>
                                                                    </div>
                                                                    <img src="<?php echo asset('img/icons/resturant-box-icon.svg') ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Resturant Box End --}}
                                                <?php }
                                            ?>
                                        
                                        </div>
                                    </div>
                                    <a class="big-main-btn" href="<?php echo Azooma::URL($cityurl.'/'.$cuisine->seo_url.'/restaurants');?>" title="<?php echo $cuisinename.' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                                        <?php echo Lang::get('messages.view_all');?>
                                        </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    {{-- Categories List End --}}
    
    @include('inc.footer')
    <script type="text/javascript">
        require(['popular'],function(){});
    </script>
</body>
</html>