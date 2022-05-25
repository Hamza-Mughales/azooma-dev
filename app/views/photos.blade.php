<?php 
dd(1);
?>
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
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url.'/gallery');?>" title="<?php echo $cityname.' '.Lang::get('messages.photos').' '.Lang::get('messages.and').' '.Lang::get('messages.videos');?>">
                                <?php echo Lang::get('messages.gallery');?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo Lang::get('messages.photos');?>
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

    <div class="container">
        <h1>
            <?php echo Lang::get('messages.photos').' - '.$total;?>
        </h1>
    </div>

    {{-- Azooma Tabs Nav Section Start --}}
    <section class="azooma-tabs-nav-static">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li class="<?php echo ($sort=="latest")?'active':'' ;?>"><a href="#photos"> <a href="<?php echo ($sort=="latest")?'javascript:void(0);': Azooma::URL($city->seo_url.'/photos?sort=latest');?>">
                            <?php echo Lang::get('messages.latest');?>
                        </a></li>
                        <li class=" <?php echo ($sort=="popular")?'active':'' ;?>"> <a href="<?php echo ($sort=="popular")?'javascript:void(0);': Azooma::URL($city->seo_url.'/photos?sort=popular');?>">
                            <?php echo Lang::get('messages.popular');?>
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Azooma Tabs Nav Section End --}}
    
    {{-- Gallary Photos Start --}}
    <section class="photo-gallary">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="restaruant-images-gallary mt-4 mb-4">
                        <?php 
                        if(count($photos)>0){
                            $i=0;
                            foreach ($photos as $photo) {
                            $i++;
                            if($lang=="en"){
                                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($photo->rest_Name);
                            }else{
                                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($photo->rest_Name_Ar);
                            }
                            
                            ?>
                        {{-- Start Image --}}
                        <?php 
                        $allcountt = count($photos) / 3;
                        if ($i == 1 || $i == ($allcountt + 1) || $i == ($allcountt *2 + 1)){ ?>
                        <div class="column">
                        <? } ?>
                      
                     <a class="image-block ajax-link"  href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>" title="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
                        <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>" alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
                        <div class="image-info">
                            <h3 class="title">
                                <?php  
                                if($photo->user_ID!=NULL){
                                $user=User::checkUser($photo->user_ID);
                                $user=$user[0];
                                $userimage=($user->image=="")?'user-default.svg':$user->image;
                                $username=($user->user_NickName=="")?ucfirst(stripcslashes($user->user_FullName)):ucfirst(stripcslashes($user->user_NickName));
                                ?>
                                    <?php echo $username;?>
                                <?php } else { 
                                    $restname=($lang=="en")?stripcslashes($photo->rest_Name):stripcslashes($photo->rest_Name_Ar);
                                ?>                                    <?php
                                    if($lang=="en"){   
                                        echo (strlen($restname)>22)?ucfirst(mb_substr($restname, 0,22,'UTF-8')).'..':$restname;
                                    }else{
                                        echo (strlen($restname)>17)?ucfirst(mb_substr($restname, 0,17,'UTF-8')).'..':$restname;
                                    }
                                    ?>
                            <?php } ?>   
                            </h3>
                        </div>
                        <?php 
                        if(Session::has('userid')){
                            $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
                        }
                        if(Session::has('userid')&&$checkuserliked>0){
                            ?>
                            <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                                <i class="fas fa-heart"></i> <?php echo $photo->likes ?>
                            </button>
                            <?php
                        }else{
                        ?>
                            <button class="heart-btn" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                                <i class="far fa-heart"></i> <?php echo $photo->likes ?>
                            </button>
                        <?php } ?>
                        </a>      
                        
                        <?php if ($i == $allcountt || $i == ($allcountt*2) || $i==  ($allcountt * 3)){ ?>
                            </div>
                        <? } ?>
                        {{-- End Image --}}
                        <?php } } ?>
                 </div>
                 <div class="spinner-grow spin-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                 <button class="big-main-btn b-block load-more-photos mb-4" data-sort="<?php echo $sort; ?>" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                   
                </div>
                <div class="col-md-4 col-sm-12">
                  @include('inc.rightcol')
                </div>
            </div>
    
        </div>
    </section>
    {{-- Gallary Photos End --}}

  @include('inc.footer')
   
</body>
</html>