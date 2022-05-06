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
                  <h2><?php echo Lang::get('messages.cuisines').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>
                  </h2>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <ul class="cat-list">
                    <?php
                    $i=0;
                    if(count($cuisines)>0){
                        $i=0;
                        foreach ($cuisines as $cuisine) {
                            if($i%21==0){
                                ?>
                                <?php
                            }
                            ?>
                            {{-- Item --}}
                            <li>
                                <a href="<?php echo Azooma::URL($city->seo_url.'/'.$cuisine->seo_url.'/restaurants');?>" title="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar); echo ' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)); ?>">
                                    <img src="<?php echo Azooma::CDN('images/cuisine/'.$cuisine->image);?>"  alt="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar); echo ' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)); ?>">
                                    <span class="title"><?php 
                                        echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);
                                        ?></span>
                                </a> - <span class="total"><?php echo $cuisine->total;?></span>
                            </li>                       
                            <?php
                            $i++;
                            if(($i%21==0)||($i==count($cuisines))){
                                ?>
                                <?php
                            }
                        }
                    }
                    ?>
                  </ul>
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