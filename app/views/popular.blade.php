<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
<link rel="canonical" href="<?php echo $originallink;?>"/>
<?php if(isset($prev)){ ?>
<link rel="prev" href="<?php echo $prev;?>"/>
<?php } if(isset($next)){ ?>
<link rel="next" href="<?php echo $next;?>"/>
<?php } ?>
<meta property="og:title" content="<?php echo (isset($meta['title']))?$meta['title']:Lang::get('messages.azooma');?>">
<meta property="og:description" content="<?php if(isset($meta['metadesc'])) echo $meta['metadesc'];?>">
<meta property="og:url" content="<?php echo Request::url();?>">
<?php if(isset($bannerimage)){ ?>
<meta property="og:image" content="<?php echo $bannerimage;?>">
<?php
}else{
?>
<meta property="og:image" content="http://azooma.co/sufratiapp.png">
<?php } ?>
<meta property="og:site_name" content="Sufrati">
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <?php
    ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar);
    ?>
     {{-- <div id="main-search-container" >
        <form class="form-inline relative auto-suggest-form" id="sufSearchAuto" method="get" action="<?php echo Azooma::URL($city->seo_url.'/find');?>">
          <input name="query" type="search" autocomplete="off" class="form-control" id="sufSearchSuggest" placeholder="<?php echo Lang::get('messages.search_helper');?>">
          <span class="search-symbol"><i class="fa fa-search"></i></span>
        </form>
    </div> --}}
    {{-- Breadcrumb Section Start --}}
    <section class="Breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
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
                            <?php if(isset($action)&&$action=="districts"){
                                echo $actiontitle.' '.$cityname;
                            }else{
                                echo $actiontitle.' '.Lang::get('messages.inplace',array('name'=>$cityname));
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-xs-12">
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
    <script src="<?php echo URL::asset('js/jquery-3.5.1.min.js');?>"></script>
    {{-- Breadcrumb Section End --}}
    <div class="side-filter">
        <div class="side-header d-flex">
            <h4><?php echo Lang::get('messages.filter');?></h4>
            <a href="#" id="close_filter"><ion-icon name="close-outline"></ion-icon></a>
        </div>


        <div class="side-list">
            <form>
                <div class="list-block">
                <?php if(isset($action)&&(isset($cuisinelistings))){ ?>
                 
                        <div class="block-header d-md-flex">
                            <h5> <?php echo Lang::get('messages.cuisines');?> </h5>
                            <a data-bs-toggle="collapse" href="#cusiensfilter" role="button" aria-expanded="false" aria-controls="cusiensfilter">
                                <?php echo Lang::get('messages.ViewAll');?>  <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                        <div class="collapse show" id="cusiensfilter">
                            <div class="card card-body">
                                    <ul class="filter-list">
                                        <?php foreach ($cuisinelistings as $cuisine) { ?>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $cuisine->cuisine_ID;?>"  <?php if(count($var['cuisine']) > 1 && in_array($cuisine->cuisine_ID,$var['cuisine'])){ echo 'checked'; } ?> name="cuisine[]" id="<?php echo $cuisine->cuisine_ID;?>">
                                                <label class="form-check-label" for="<?php echo $cuisine->cuisine_ID;?>">
                                                    <?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);
                                                    echo ' ('.$cuisine->count.')';
                                                ?>
                                                </label>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                            </div>
                        </div>
                   
                    <?php  } ?>
                    </div>
                    <div class="list-block">
                        <div class="block-header d-md-flex">
                            <h5><?php echo Lang::get('messages.features');?> </h5>
                            <a data-bs-toggle="collapse" href="#servicesfilter" role="button" aria-expanded="false" aria-controls="servicesfilter">
                                <?php echo Lang::get('messages.ViewAll');?> <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                        <div class="collapse show" id="servicesfilter">
                            <div class="card card-body">
                                    <ul class="filter-list">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"  <?php if($var['menu']=="1"){ echo 'checked'; } ?> name="menu" id="menu">
                                                <label class="form-check-label" for="menu">
                                                    <?php echo Lang::get('messages.menu');?>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"  <?php if($var['wheelchair']=="1"){ echo 'checked'; } ?> name="wheelchair" id="1">
                                                <label class="form-check-label" for="wheelchair">
                                                    <?php echo Lang::get('messages.wheelchair');?>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"  <?php if($var['delivery']=="1"){ echo 'checked'; } ?> name="delivery" id="delivery">
                                                <label class="form-check-label" for="menu">
                                                    <?php echo Lang::get('messages.delivery');?>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"  <?php if($var['finedining']=="1"){ echo 'checked'; } ?> name="finedining" id="finedining">
                                                <label class="form-check-label" for="finedining">
                                                    <?php echo Lang::get('messages.fine-dining');?>
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"  <?php if($var['casualdining']=="1"){ echo 'checked'; } ?> name="casualdining" id="casualdining">
                                                <label class="form-check-label" for="casualdining">
                                                    <?php echo Lang::get('messages.casualdining');?>
                                                </label>
                                            </div>
                                        </li>
                                        
                                    </ul>
                            </div>
                        </div>
                    </div>
                    <?php /*
                    <div class="list-block">
                        <div class="block-header d-md-flex">
                            <h5> Average Rate</h5>
                            <a data-bs-toggle="collapse" href="#Averagerate" role="button" aria-expanded="false" aria-controls="Averagerate">
                                <?php echo Lang::get('messages.ViewAll');?> <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                     
                        <div class="collapse show" id="Averagerate">
                            <div class="card card-body">
                                    <ul class="filter-list">
                                        <li>
                                            <div class="ranges ranges-star mt-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="rande-stars d-flex justify-content-between">
                                                            <ion-icon data-value="1" name="star"></ion-icon>
                                                            <ion-icon data-value="2" name="star-outline"></ion-icon>
                                                            <ion-icon data-value="3" name="star-outline"></ion-icon>
                                                            <ion-icon data-value="4" name="star-outline"></ion-icon>
                                                            <ion-icon data-value="5" name="star-outline"></ion-icon>

                                                        </div>
                                                        <input type="range" value="1" min="1" max="5" name="rate" id="rate" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                       
                                    </ul>
                            </div>
                        </div>
                    </div> */ ?>
             
                    <div class="list-block">
                        <div class="block-header d-md-flex">
                            <h5>   <?php echo Lang::get('messages.Average_Price');?> </h5>
                        </div>
                        <div class="collapse show" id="Averageprice">
                            <div class="card card-body">
                                    <ul class="filter-list">
                                        <li>
                                            <div class="ranges ranges-price">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="rande-stars d-flex justify-content-between">
                                                            <span>$5-10</span>
                                                            <span>$15-30</span>
                                                            <span>$45-75</span>
                                                            <span>$100+</span>
                                                        </div>
                                                        <input type="range" value="<?php  if($var['price'] == ''){echo '1';} if($var['price'] == '5-10') {echo '1';} if($var['price'] == '15-30') {echo '2';} if($var['price'] == '45-75') {echo '3';} if($var['price'] == '100+') {echo '4';} ?>" min="1" max="4" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                                                        <input value="<?php if($var['price']){echo $var['price'];} else{ echo '5-10';} ?>" class="price" name="price" id="price" style="display: none">

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                       
                                    </ul>
                            </div>
                        </div>
                    </div>
                   
                    <div class="list-block">
                        <div class="form-el">
                            <button class="big-main-btn" type="submit"><?php echo Lang::get('messages.filter_results');?></button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
    {{-- restaurants top --}}
    <section class="rest-list-header" style="background-image: url(<?php if(isset($bannerimage)){  echo $bannerimage;  }else{  echo asset('img/featured/london.png'); }?>)"> 
      
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h1> <?php if(isset($action)&&$action=="districts"){
                        echo $actiontitle.' '.$cityname;
                    }else{
                        echo $actiontitle.' '.Lang::get('messages.inplace',array('name'=>$cityname));
                    }
                    ?></h1>
                </div>
    
            </div>
        
        </div>
        <div class="back-rgb"></div>
    </section>

    
        <?php if(isset($newrestaurants)&&isset($popularrestaurants)&&isset($recommendedrestaurants) ){ ?>
    {{-- Cuisine Recommend  Start --}}
        <section class="cusisne-recommend">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="recomend-title">
                            <?php echo Lang::get('messages.recommended');?>
                        </div>
                        <div class="recomend-res">
                            <?php
                            if(count($recommendedrestaurants)>0){
                                $inum = 0;
                                ?>
                                <ul class="results-summary-list" style="padding:0 1rem">
                                    <?php foreach ($recommendedrestaurants as $rest) {
                                    
                                    ($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
                                    $resbanner = $rest->thephoto;
                                    if(isset($rest->thephoto))
                                    $ratinginfo= MRestaurant::getRatingInfo($rest->id);
                                    $ratinginfo = (array)$ratinginfo;
                                    $likes= MRestaurant::getRestaurantLikeInfostatic($rest->id);
                                        if(count($ratinginfo) > 0){
                                            if (isset($ratinginfo[0])) {
                                            $ratinginfo = $ratinginfo[0];
                                            if($ratinginfo->total > 0){
                                                $totalrating=round(($ratinginfo->totalfood+$ratinginfo->totalservice+$ratinginfo->totalatmosphere+$ratinginfo->totalvalue+$ratinginfo->totalvariety+$ratinginfo->totalpresentation)/(6*$ratinginfo->total),1);
                                            }else{
                                                $totalrating=0;
                                            }
                                        }
                                    }
                                    ?>
                                        <?php if($resbanner!=""){ $inum++;?>
                                    <li>
                                        <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url);?>" title="<?php echo $restname;?>">
                                            <div class="res-img">
                                                <img class="sufrati-super-lazy" src="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" alt="<?php echo $restname;?>"/>
                                            </div>
                                        
                                            <div class="info">
                                            <?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?>
                                            <div class="info-rate">
                                                <?php 
                                                if(count($ratinginfo)>0){
                                                    ?>
                                                <div class="rating-stars">
                                                    <?php 
                                                    if(count($ratinginfo) > 0){
                                                    $k=5-round($totalrating/2);
                                                    for($i=0;$i<round($totalrating/2);$i++){
                                                        echo '<i class="fa fa-star pink"></i>&nbsp;&nbsp;';
                                                    }
                                                        for($i=0;$i<$k;$i++){
                                                            echo '<i class="fa fa-star"></i>';
                                                            if($i<($k-1)){
                                                                echo '&nbsp;&nbsp;';
                                                            }
                                                        }
                                                    }
                                                        ?>
                                                </div>
                                                <?php 
                                                if($likes[0]->total!=0){
                                                    $percentage=round(($likes[0]->likers/$likes[0]->total)*100);
                                                }else{
                                                    $percentage=0;
                                                }
                                                ?>
                                                <div class="like-it"> <span class="bold"><?php echo $percentage; ?> %  </span> <strong><?php echo Lang::get('messages.like_it');?></strong> (<?php echo $likes[0]->total;?>) </div>
                    
                                                <?php
                                                    }?> 
                                            </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    } }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="recomend-title">
                            <?php echo Lang::get('messages.latest');?>
                        </div>
                        <div class="recomend-res">
                            <?php
                            if(count($newrestaurants)>0){
                                ?>
                                <ul class="results-summary-list">
                                    <?php foreach ($newrestaurants as $rest) {
                                    ($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
                                    $resbanner = $rest->thephoto;
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
                                        <?php if($resbanner!=""){ ?>
                                    <li>
                                        <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url);?>" title="<?php echo $restname;?>">
            
                                            <div class="res-img">
                                                <img class="sufrati-super-lazy" src="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" alt="<?php echo $restname;?>"/>
                                            </div>                                 
                                            <div class="info">
                                            <?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?>
                                            <div class="info-rate">
                                                <?php 
                                                if(count($ratinginfo)>0){
                                                    ?>
                                                <div class="rating-stars">
                                                    <?php 
                                                    $k=5-round($totalrating/2);
                                                    for($i=0;$i<round($totalrating/2);$i++){
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
                                                if($likes[0]->total!=0){
                                                    $percentage=round(($likes[0]->likers/$likes[0]->total)*100);
                                                }else{
                                                    $percentage=0;
                                                }
                                                ?>
                                                <div class="like-it"> <span class="bold"><?php echo $percentage; ?> %  </span> <strong><?php echo Lang::get('messages.like_it');?></strong> (<?php echo $likes[0]->total;?>) </div>

                                                <?php
                                                    }?>  
                                            </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    } }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="recomend-title">
                            <?php echo Lang::get('messages.popular');?>
                        </div>
                        <div class="recomend-res">
                            <?php
                            if(count($popularrestaurants)>0){
                                ?>
                                <ul class="results-summary-list">
                                    <?php foreach ($popularrestaurants as $rest) {
                                    ($lang=="en")?$restname=stripcslashes($rest->name):$restname=stripcslashes($rest->nameAr);
                                    $resbanner = $rest->thephoto;
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
                                        <?php if($resbanner!=""){ ?>
                                    <li>
                                        <a href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->url);?>" title="<?php echo $restname;?>">
            
                                            <div class="res-img">
                                                <img class="sufrati-super-lazy" src="<?php echo Azooma::CDN('Gallery/'.$resbanner);?>" alt="<?php echo $restname;?>"/>
                                                
                                            </div>  
                                        <div class="info">
                                            <?php echo (strlen($restname)>18)?mb_substr($restname, 0,18,'UTF-8').'..':$restname;?>
                                            <div class="info-rate">
                                                <?php 
                                                if(count($ratinginfo)>0){
                                                    ?>
                                                <div class="rating-stars">
                                                    <?php 
                                                    $k=5-round($totalrating/2);
                                                    for($i=0;$i<round($totalrating/2);$i++){
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
                                                if($likes[0]->total!=0){
                                                    $percentage=round(($likes[0]->likers/$likes[0]->total)*100);
                                                }else{
                                                    $percentage=0;
                                                }
                                                ?>
                                                <div class="like-it"> <span class="bold"><?php echo $percentage; ?> %  </span> <strong><?php echo Lang::get('messages.like_it');?></strong> (<?php echo $likes[0]->total;?>) </div>

                                                <?php
                                                    }?> 
                                            </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    } }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                
                </div>
            </div>
        </section>
        {{-- End Recommend  Start --}}
      <?php  } /* <li class="sort-List">
        <select class="form-select" onchange="if (this.value) window.location.href=this.value">
            <option value=""  <?php if($var['sort']==""){ echo 'selected'; } ?>> <?php echo Lang::get('messages.sort_by');?></option>
            <option  <?php if($var['sort']=="name"){ echo 'selected'; } ?> value="?sort=name"><?php echo Lang::get('messages.name');?></option>
            <option <?php if($var['sort']=="latest"){ echo 'selected'; } ?> value="?sort=latest"> <?php echo Lang::get('messages.latest');?></option>
            <option <?php if($var['sort']=="popular"){ echo 'selected'; } ?> value="?sort=popular"><?php echo Lang::get('messages.popular');?></option>
          </select>
    </li>*/?>
    {{-- Resturant List Start --}}
    <section class="resturants-list">
        <div class="container">
            <div class="row">
                <div class="col-12 top-nav-res">
                    <div class="section-title-main">
                        <h3><?php echo $total.' '.Lang::choice('messages.restaurants',2);?></h3>
                    </div>
                    <ul class="list-types" id="#viewtypechoose">
                    
                        <li class="map_id"  data-bs-toggle="modal" data-bs-target="#map_modal"><i class="fas fa-map-marker-alt"></i> <?php echo Lang::get('messages.ShowMap'); ?></li>
                        
                        <li class="filter-btn" data-bs-target="filter-res"><i class="fas fa-filter"></i> <?php echo Lang::get('messages.filter'); ?></li>
                   
                    </ul>
                  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="res-list"> 
                        <div class="row">
                            <div class="col-md-12 res-view">
                                    <?php echo $resultshtml;?>
                                <div class="spinner-grow spin-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                                    <span class="visually-hidden">Loading...</span>
                                  </div>
                                <button class="big-main-btn b-block load-more-rest" onclick="loadMoreRest2()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Resturant List End --}}
  
    {{-- Map Modal --}}
    <div class="modal fade" id="map_modal" tabindex="-1" aria-labelledby="Map modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="width: 90%;max-width:100% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo Lang::get('messages.Map');?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                </div>
                <div class="modal-body Mapmodal" style="padding: 0">
                    <div style="height: 85vh" id="map"></div>
                    <div class="load_more_map">
                    <div class="spinner-grow spin-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                    <button class="big-main-btn b-block load-more-rest" onclick="loadMoreRest2()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                </div>
                </div>
            </div>
        </div>
    </div>


    @include('inc.footer')
 
  <script async
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrR9_-dCfdIJAtnA4bhMVi3BFfGzR6kJk&callback=initMap">
</script>
  <script>
	  function initMap(){
		  var restaurants = document.getElementsByClassName('resturant-box');
		  var myLatLng = { lat: parseFloat(restaurants[0].getElementsByClassName('laten')[0].value), lng: parseFloat(restaurants[0].getElementsByClassName('langen')[0].value) };
		  var map = new google.maps.Map(document.getElementById("map"), {
				zoom: 13,
				center: myLatLng,
			});
        var infowindow = new google.maps.InfoWindow();
        var icon = {
    url: "https://azooma.co/favicon_en.png", // url
    scaledSize: new google.maps.Size(25, 25), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0) // anchor
};
		  for(i=0; i < restaurants.length; i++){
			var reslat = parseFloat(restaurants[i].getElementsByClassName('laten')[0].value);
			var reslang = parseFloat(restaurants[i].getElementsByClassName('langen')[0].value);
			var restname = restaurants[i].getElementsByClassName('restname')[0].value;
            var resImage = restaurants[i].getElementsByClassName('rest_image')[0].value;
            var info_type = restaurants[i].getElementsByClassName('rest_info_type')[0].value;
            var priceRange = restaurants[i].getElementsByClassName('rest_priceRange')[0].value;
            var resturl = restaurants[i].getElementsByClassName('resturl')[0].value;
        
			if(reslat != null &&  reslang !=null){
				var marker = new google.maps.Marker({
				position: {lat: reslat , lng: reslang},
				map,
                icon:icon,
				title: restname,
                resImage:resImage,
                info_type:info_type,
                priceRange:priceRange,
                resturl:resturl,
                raiseOnDrag: true,
			});

			google.maps.event.addListener(marker, 'click', function() {
                var content = "<a href='"+this.resturl+"'><div class='resturant-box'> <div class='box-img'><img src='"+this.resImage+"'/></div><d class='box-details'> <div class='box-info'><div class='info-title'><h3>"+this.title+"</h3></div><div class='info-type'>"+this.info_type+"</div></div><div class='box-icon'><span class='priceRange'>"+this.priceRange+"</span></div></d</a>";
                infowindow.setContent(content);
                infowindow.open(map, this);
			});
			}
		}
	  }
	  
      </script>
      <script type="text/javascript" >
        require(['popular'],function(){});
        </script>
        <script>
        var page = 1;
        function loadMoreRest2(){
            $('.spin-load').css('display','block');
            $('.load-more-rest').hide();
            $.ajax(
            {
                url: '?page=' + page,
                type: "get",
                datatype: "html"
            }).done(function(data){
                var newdate =$($.parseHTML(data)).find('.res-view .restaurants-boxes')[0].innerHTML;
             //    $('.load-more-rest').remove();
                $(".res-view .restaurants-boxes").append(newdate);
                page += 1;
                
                initMap();
                $('.load-more-rest').show();
                $('.spin-load').hide();
                if(newdate.length == 0){
      $('.load-more-rest').remove();
      $('.spin-load').hide();
    }
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                $('.load-more-rest').remove();
                $('.spin-load').hide();
            });
        }
        </script>


</body>
</html>