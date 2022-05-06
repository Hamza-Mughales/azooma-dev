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
                   
                        <li class="active">
                            <?php echo Lang::get('messages.videos');?>
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
            <?php echo Lang::get('messages.videos').' - '.$total;?>
        </h1>
    </div>
      {{-- Gallary Photos Start --}}
      <section class="photo-gallary">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <ul class="restaruant-images-gallary mt-4 mb-4">
                 
                        <?php 
                        if(count($videos)>0){
                            $i=0;
                            foreach ($videos as $video) {
                            $i++;
                            if($lang=="en"||($lang=="ar"&&$video->youtube_ar=="")){
                                    parse_str( parse_url( $video->youtube_en, PHP_URL_QUERY ), $var );
                                }else{
                                    parse_str( parse_url( $video->youtube_ar, PHP_URL_QUERY ), $var );
                                }
                                
                                $youtube="";
                                if(isset($var['v'])){
                                    $youtube=$var['v'];
                                }
                                $videoname=($lang=='en')?stripcslashes($video->name_en):stripcslashes($video->name_ar);
                                $videoname=ucfirst($videoname);
                            
                            ?>
                        {{-- Start Image --}}
                        <li>
                        <a class="video-block"  href="<?php echo Azooma::URL('video/'.$video->id.'?autoplay=1');?>" title="<?php echo (strlen($videoname)>40)?mb_substr($videoname, 0,40,'UTF-8').'..':$videoname; ?>">
                            <img src="http://img.youtube.com/vi/<?php echo $youtube;?>/mqdefault.jpg" alt="<?php echo$videoname; ?>">               
                            <div class="image-info">
                                <h3 class="title">
                                    <?php echo (strlen($videoname)>40)?mb_substr($videoname, 0,40,'UTF-8').'..':$videoname; ?>
                                </h3>
                            </div>  
                        </a>      
                    </li>
                        {{-- End Image --}}
                        <?php } } ?>
                </ul>
                 <div class="spinner-grow spin-load" role="status" style="display: none;margin:0 auto; color:#EE5337">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                 <button class="big-main-btn b-block load-more-videos mb-4" onclick="loadmorevideos()" style="width: 250px; margin:0 auto"><?php echo Lang::get('messages.load_more');?></button>
                    <script>
                    var page = 2;
                    function loadmorevideos(){
                        $('.spin-load').css('display','block');
                        $('.load-more-videos').hide();
                        $.ajax(
                        {
                            url: '?page=' + page + '&limit=24',
                            type: "get",
                            datatype: "html"
                        }).done(function(data){
                            var newdate =$($.parseHTML(data)).find('.restaruant-images-gallary')[0].innerHTML;
                            console.log(data)
                         //    $('.load-more-rest').remove();
                            $(".restaruant-images-gallary").append(newdate);
                            page += 1;
                            $('.load-more-videos').show();
                            $('.spin-load').hide();
                        }).fail(function(jqXHR, ajaxOptions, thrownError){
                            $('.load-more-videos').remove();
                            $('.spin-load').hide();
                        });
                    }
                    </script>
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