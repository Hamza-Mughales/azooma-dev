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
                                <?php echo $actiontitle;?>
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
            <div class="side-filter">
                <div class="side-header d-flex">
                    <h4><?php echo Lang::get('messages.filter');?></h4>
                    <a href="#" id="close_filter"><ion-icon name="close-outline"></ion-icon></a>
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
 {{-- Resturant List Start --}}
 <section class="resturants-list">
    <div class="container">
        <div class="row">
            <div class="col-12 top-nav-res">
                <div class="section-title-main">
                    <h3><?php echo $total.' '.Lang::choice('messages.restaurants',2);?></h3>
                </div>
      
              
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
                              <?php if(isset($resultshtml)){ ?>
                            <button class="big-main-btn b-block load-more-rest" onclick="loadMoreRest2()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                            <?php } ?>
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


</body>
</html>
