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
                            <?php echo Lang::get('messages.press');?>
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
    <section class="page-daynamic">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="section-title">
                        <?php echo Lang::get('messages.press');?>
                    </h1>
                </div>
                <div class="col-md-8 col-sm-12">
                    <?php
                    if(count($posts)>0){ $i=0;
                        foreach ($posts as $post) { $i++;?>
                            <div class="articles-list overflow">
                                <div class="article-image-place pull-left">
                                    <a href="<?php echo Azooma::URL('press/'.$post->id);?>" title="<?php echo ($lang=="en")?stripcslashes($post->short):stripcslashes($post->short_ar); ?>">
                                        <img src="<?php echo Azooma::CDN('images/news/thumb/'.$post->image);?>" alt="<?php echo ($lang=="en")?stripcslashes($post->short):stripcslashes($post->short_ar); ?>">
                                    </a>
                                </div>
                                <div class="article-desc-place pull-right">
                                    <div class="caption">
                                        <a class="normal-text" href="<?php echo Azooma::URL('press/'.$post->id);?>" title="<?php echo ($lang=="en")?stripcslashes($post->short):stripcslashes($post->short_ar); ?>">
                                            <h5><?php echo ($lang=="en")?stripcslashes($post->short):stripcslashes($post->short_ar); ?></h5>
                                        </a>
                                        <div class="small-text overflow" >
                                            <span class="">
                                                <?php echo ($lang=="en")?stripcslashes($post->author):stripcslashes($post->author_ar);?>
                                            </span>
                                            <span class="pull-right">
                                                <?php echo date('jS M Y',strtotime($post->newsDate));?>
                                            </span>
                                        </div>
                                        <p>
                                            <?php echo ($lang=="en")?mb_substr(strip_tags(htmlspecialchars_decode(stripslashes($post->description))),0,200,'UTF-8'):mb_substr(strip_tags(htmlspecialchars_decode(stripslashes($post->descriptionAr))),0,200,'UTF-8');?>
                                        </p>
                                    </div>
                                    <div>
                                        <a class="btn btn-primary pull-right big-main-btn" style=" width: 150px;    padding: 12px 0;" href="<?php echo Azooma::URL('press/'.$post->id);?>" title="<?php echo ($lang=="en")?stripcslashes($post->short):stripcslashes($post->short_ar); ?>"><?php echo Lang::get('messages.read_more');?></a>
                                    </div>
                                </div>
                            </div>
                            <?php }
                    }
                    echo $paginator->links();
                    ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    @include('inc.rightcol')
                </div>
            </div>
        </div>
    </section>
 
    @include('inc.footer')
</body>
</html>