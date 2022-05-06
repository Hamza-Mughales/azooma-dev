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
                                <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                <?php echo Lang::get('messages.azooma'); ?></a>
                            </li>
                            <li class="active">
                                <?php echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);?>
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
    {{-- SiteMap Section Start --}}
    <section class="site-map">
        <div class="container">
            <div class="row">
                <div class="col-md-12 country-block">
                    <?php
                    if(count($city)>0){
                        ?>
                        <div id="sitemap-main-block">
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::get('messages.azooma').' ';echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);?>">
                                <h1 class="inline-block section-title mb-4">
                                    <?php echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);?>
                                </h1>
                            </a>
                        </div>
                        <ul class="serv-list">
                            <?php
                            if(count($restaurants)>0){
                                foreach ($restaurants as $rest) {
                                    $checklocations=MSiteMap::getLocationsStartingWith($rest->letter,$city->city_ID);
                                    ?>
                                    <li>
                                    <dl>
                                        <dt>
                                            <h3><?php echo $rest->letter;?></h3>    
                                        </dt>
                                        <dd>
                                            <a href="<?php echo Azooma::URL($city->seo_url.'/sitemap/restaurants/'.$rest->letter);?>" title="<?php echo Lang::choice('messages.restaurants',2);?>">
                                                <?php echo '<span class="normal-text">'.Lang::choice('messages.restaurants',2).' - </span>'.$rest->total;?>
                                            </a>   
                                        </dd>
                                    </dl>
                                </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <ul class="city-list">
                            <?php
                            $categories=array(
                                array('name'=>Lang::get('messages.latest').' '.Lang::choice('messages.restaurants',2),'url'=>'latest'),
                                array('name'=>Lang::get('messages.home-delivery'),'url'=>'home-delivery'),
                                array('name'=>Lang::get('messages.fine-dining'),'url'=>'fine-dining'),
                                array('name'=>Lang::get('messages.special_offers'),'url'=>'offers'),
                                array('name'=>Lang::get('messages.catering'),'url'=>'catering'),
                                array('name'=>Lang::choice('messages.hotels',2),'url'=>'hotels'),
                                array('name'=>Lang::get('messages.sheesha'),'url'=>'sheesha'),
                                array('name'=>Lang::get('messages.popular').' '.Lang::choice('messages.restaurants',2),'url'=>'popular'),
                            );
                            foreach ($categories as $category) {
                                ?>
                                <li> 
                                <a class="normal-text" href="<?php echo Azooma::URL($city->seo_url.'/'.$category['url']);?>" title="<?php echo $category['name'].' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                    <h2> <?php echo $category['name'];?></h2>
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
                </div>
            </div>
        </div>
    </section>
    {{-- SiteMap Section End --}}
    
    @include('inc.footer')
</body>
</html>