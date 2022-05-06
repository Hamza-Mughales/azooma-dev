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
 {{-- Resturant List Start --}}
 <section class="resturants-list">
    <div class="container">
        <div class="row">
            <div class="col-12 top-nav-res">
                <div class="section-title">
                    <h1> <?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.near_you');?></h1>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="res-list">
                    <div class="row">
                        <div class="col-md-12 res-view" >
                            <div class="row restaurants-boxes" id="nearby-col">

                            <?php 
                            if(isset($html)){ ?>
                               <?php echo $html; ?>

                                ?>
                            </div>
                                  <div class="spinner-grow spin-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                                    <span class="visually-hidden">Loading...</span>
                                  </div>
                                <button class="big-main-btn b-block load-more-rest" onclick="loadMoreRest2()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                            
                                <?php
                            }
                            
                            if(isset($paginator)){
                                echo $paginator;
                            }
                            ?>
                          
                        </div>
                        <div class="col-md-6 map-view">
                            <div style="height: 600px" id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Resturant List End --}}


    @include('inc.footer')
    <script type="text/javascript">
    var near=1;
        require(['popular'],function(){});
    </script>
</body>
</html>