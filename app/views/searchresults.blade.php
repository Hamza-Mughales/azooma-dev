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
                            <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo '"<span>'.$query.'</span>" '.Lang::get('messages.search_results');?>
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
    @include('main.search')
     {{-- Search Result Section Start --}}
    <div class="search-result-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <?php echo '"<span>'.$query.'</span>" '.Lang::get('messages.search_results');?>
                    </h4>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="nav-list">
                            <?php
                            $i=0;
                            if(count($restaurants)>0||count($cuisines)>0){ ?>
                            <li <?php if($i==0){ echo 'class="active"'; $i++;}?>>
                                <a href="#restaurant-tab">
                                    <?php echo Lang::choice('messages.restaurants',2);?>
                                </a>
                            </li>
                            <?php } 

                            if((count($menu)>0)||(count($dishes)>0)){ 
                            ?>
                            <li <?php if($i==0){ echo 'class="active"'; $i++;}?>>
                                <a href="#menu-tab">
                                    <?php echo Lang::get('messages.menu');?>
                                </a>
                            </li>
                            <?php 
                            }
                            if(count($locations)>0){
                            ?>
                            <li <?php if($i==0){ echo 'class="active"'; $i++;}?>>
                                <a href="#locations-tab">
                                    <?php echo Lang::get('messages.locations');?>
                                </a>
                            </li>
                            <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 search-tabs">
                    <div class="search-tab show" id="restaurant-tab">
                        <?php
                        if(count($cuisines)>0){
                            ?>
                            <ul>
                            <?php
                            if(count($cuisines)>0){
                                foreach ($cuisines as $cuisine) {
                                    ?>
                                    <li>
                                        <a class="normal-text" href="<?php echo Azooma::URL($city->seo_url.'/'.$cuisine->url);?>" title="<?php echo Lang::get('messages.all').' ';echo ($lang=="en")?stripcslashes($cuisine->name):stripcslashes($cuisine->nameAr);echo ' '.Lang::choice('messages.restaurants',2); ?>">
                                            <?php echo Lang::get('messages.all').' <b>';echo ($lang=="en")?stripcslashes($cuisine->name):stripcslashes($cuisine->nameAr);echo '</b> '.Lang::choice('messages.restaurants',2); ?>
                                        </a>
                                    </li>
                                    <?php   
                                }
                            }
                        }
                        ?>
                        <?php 
                         if(count($restaurants)>0){
                                $restdata=array(
                                    'restaurants'=>$restaurants,
                                    'nosplitting'=>true,
                                    'city'=>$city,
                                    'action'=>'',
                                    'lang'=>$lang,
                                    'paginator'=>$restpaginator,
                                    'var'=>array('tab'=>'restaurant')
                                );
                             ?>
                           
                           @include('main.results',$restdata)
                            <?php
                              } 
                            ?>
                            <div class="spinner-grow spin-load mb-4" role="status" style="display: none;margin:0 auto; color:#EE5337">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            <button class="big-main-btn b-block load-more-rest mb-4" onclick="loadMoreRest()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                            
                
                       
                    </div>
             
                    <div class="search-tab d-flex" id="menu-tab">
                        <?php if((count($menu)>0)||(count($dishes)>0)){  ?>
                            <?php if(count($menu)>0){ ?>
                                <div class="spacing-container"></div>
                                <ul class="list-group">
                                    <li class="list-group-item disabled">
                                        <h4 class="list-group-item-heading"><?php echo Lang::get('messages.from_menu');?></h4>
                                    </li>
                                <?php
                                 foreach ($menu as $m) {
                                ?>
                                    <li class="list-group-item">
                                        <a href="">
                                            <?php echo ($lang=="en")?stripcslashes($m->cat_name):stripcslashes($m->cat_name_ar); ?>
                                        </a>
                                    </li>
                                <?php
                                } 
                                ?>
                                </ul>
                                <?php }
                                if(count($dishes)>0){
                                    ?>
                                <div class="spacing-container"></div>
                                <ul class="list-group">
                                    <li class="list-group-item disabled">
                                        <h5 class="list-group-item-heading"><?php echo Lang::get('messages.from_dishes');?></h5>
                                    </li>
                                    <?php 
                                    foreach ($dishes as $dish) {
                                        ?>
                                    <li class="list-group-item">
                                        <a href="">
                                            <?php echo ($lang=="en")?stripcslashes($dish->name):stripcslashes($dish->nameAr); ?> - <?php echo ($lang=="en")?stripcslashes($dish->category):stripcslashes($dish->categoryAr); ?>
                                        </a>
                                        <?php echo Lang::get('messages.from');?>
                                        <a href="<?php echo Azooma::URL($city->seo_url.'/'.$dish->seo_url);?>" title="<?php echo ($lang=="en")?stripcslashes($dish->rest_Name):stripcslashes($dish->rest_Name_Ar);echo ' '.$cityname; ?>">
                                            <?php echo ($lang=="en")?stripcslashes($dish->rest_Name):stripcslashes($dish->rest_Name_Ar); ?>
                                        </a>
                                    </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                    <?php
                                }
                                ?>
                        <?php } ?>
                        
                    </div>
                    <div class="search-tab d-flex" id="locations-tab">
                            <?php 
                            if(count($locations)>0){
                                ?>
                                <div class="spacing-container"></div>
                                <ul class="list-group">
                                    <li class="list-group-item disabled">
                                        <h5 class="list-group-item-heading"><?php echo Lang::get('messages.branches');?></h5>
                                    </li>
                                    <?php 
                                    foreach ($locations as $location) {
                                        ?>
                                    <li class="list-group-item">
                                        <a href="">
                                            <?php echo ($lang=="en")?stripcslashes($location->br_loc):stripcslashes($location->br_loc_ar); ?> - <?php echo ($lang=="en")?stripcslashes($location->rest_Name):stripcslashes($location->rest_Name_Ar); ?>
                                        </a>
                                    </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }?>
                    </div>
                </div>
             
            </div>

        </div>
        {{-- Search Result Section End --}}
  
        
     
    </div>
    @include('inc.footer')
    <script type="text/javascript">
    require(['search'],function(){});
    </script>
</body>
</html>