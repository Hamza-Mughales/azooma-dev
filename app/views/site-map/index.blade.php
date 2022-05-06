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
                            <?php echo Lang::get('messages.site_map');?>
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
                <div class="col-md-12">
                    <?php 
                    if(count($countries)>0){
                        foreach ($countries as $country) {
                    ?>
                    <div class="country-block">
                        <h1 class="inline-block section-title mb-4">
                            <?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
                        </h1>
                        <ul class="city-list">
                            <?php if(count($country->cities)>0){ 
                                foreach ($country->cities as $city) {  $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); ?>
                            <li>
                                <a href="<?php echo Azooma::URL($city->seo_url.'/sitemap');?>" title="<?php echo Lang::get('messages.azooma').' '.$cityname;?>">
                                    
                                <h2>
                                    <?php echo $cityname;?>
                                </h2>
                                </a> 
                            </li>
                            <?php } } ?>
                        </ul>
                    </div>
                        <?php } } ?>
                </div>
            </div>
        </div>
    </section>
    {{-- SiteMap Section End --}}
    @include('inc.footer')
</body>
</html>