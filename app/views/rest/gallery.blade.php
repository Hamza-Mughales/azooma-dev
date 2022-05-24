     {{-- Start videos --}}
     <?php if(count($videos)>0){ ?>
        <h2><?php echo $restname.' '.Lang::get('messages.videos');?></h2>
        <ul class="restaruant-images-gallary mb-4">
            {{-- Start Image --}}
            <?php
            $i=0;
            foreach ($videos as $video) {
            if($lang=="en"||($lang=="ar"&&$video->youtube_ar=="")){
    	                    parse_str( parse_url( $video->youtube_en, PHP_URL_QUERY ), $var );
    	                }else{
    	                    parse_str( parse_url( $video->youtube_ar, PHP_URL_QUERY ), $var );
    	                }
    	                
    	                $youtube="";
    	                if(isset($var['v'])){
    	                    $youtube=$var['v'];
    	                }?>
            <li>
                <div class="image-block">
                    <a class="image put-border ajax-link" href="<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>" title="<?php echo ($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar); ?>" >
                        <img class="Azooma-super-lazy" src="http://img.youtube.com/vi/<?php echo $youtube;?>/mqdefault.jpg" alt="<?php echo ($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar); ?>">
                    </a>
                    <div class="image-info" data-bs-toggle="modal" data-bs-target="#img<?php echo $photo->image_ID;?>">
                        <h3 class="title"> <?php echo ($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar); ?>></h3>
                    </div>
                   <?php 
                    if(Session::has('userid')){
                        $checkuserliked=User::checkPhotoLiked($photo->image_ID,Session::get('userid'));
                    }
                    if(Session::has('userid')&&$checkuserliked>0){
                        ?>
                        <button class="liked" data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                            <i class="fas fa-heart"></i>
                        </button>
                        <?php
                    }else{
                    ?>
                        <button data-id="<?php echo $photo->image_ID;?>" data-total-likes="<?php echo $photo->likes;?>" data-city="<?php echo $city->seo_url;?>">
                            <i class="far fa-heart"></i>
                        </button>
                    <?php } ?>
                    </div>
             
            </li>
    
             <?php } ?>
            {{-- End Image --}}
        </ul>
        <?PHP } ?>
        {{-- End Azooma Photos --}}

   {{-- Start Azooma Photos --}}
   <?php if(count($sufratiphotos)>0){ ?>
    <h2><?php echo Lang::get('messages.azooma').' '.Lang::get('messages.photos');?></h2>
    <ul class="restaruant-images-gallary mb-4">
        {{-- Start Image --}}
        <?php
        $i=0;
        foreach ($sufratiphotos as $photo) {
            $i++;
            if($lang=="en"){
                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($rest->rest_Name);
            }else{
                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_Ar);
            } ?>
        <li>
            <a class="image-block ajax-link" href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>">
                <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>" alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
                <div class="image-info">
                    <h3 class="title"><?php echo $photoname; ?></h3>
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
                
         
        </li>

         <?php } ?>
        {{-- End Image --}}
    </ul>

    <?PHP } ?>
    {{-- End Azooma Photos --}}

     {{-- Start User Photos --}}
   <?php if(count($userphotos)>0){ ?>
    <h2><?php echo Lang::get('messages.user').' '.Lang::get('messages.photos');?></h2>
    <ul class="restaruant-images-gallary mb-4">
        {{-- Start Image --}}
        <?php
        $i=0;
        foreach ($userphotos as $photo) {
            $i++;
            if($lang=="en"){
                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($rest->rest_Name);
            }else{
                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_Ar);
            } ?>
        <li>
            <a class="image-block ajax-link" href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>">
                <img src="<?php echo Azooma::CDN('Gallery/'.$photo->image_full);?>" alt="<?php echo ($lang=='en')?stripcslashes($photo->title):stripcslashes($photo->title_ar); ?>">
                <div class="image-info">
                    <h3 class="title"><?php echo $photoname; ?></h3>
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
                
           
        </li>

         <?php } ?>
        {{-- End Image --}}
    </ul>

    <?PHP } ?>
    {{-- End User Photos --}}

