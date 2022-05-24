<div class="Azooma-popup-box" id="video-pop-box">
    <h3 class="popup-heading Azooma-head">
       <?php echo $videoname;?>
    </h3>
    <div class="popup-content">
    <?php if(count($video)>0){
        if($lang=="en"||($lang=="ar"&&$video[0]->youtube_ar=="")){
            parse_str( parse_url( $video[0]->youtube_en, PHP_URL_QUERY ), $var );
        }else{
            parse_str( parse_url( $video[0]->youtube_ar, PHP_URL_QUERY ), $var );
        }
        
        $youtube="";
        if(isset($var['v'])){
            $youtube=$var['v'];
        }
    ?>
    	<iframe width="700" height="450" src="http://www.youtube.com/embed/<?php echo $youtube;?>?autoplay=1" frameborder="0" allowfullscreen=""></iframe>
    	<?php } ?>
    </div>
 </div>