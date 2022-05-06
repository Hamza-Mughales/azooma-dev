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
    <div class=" sufrati-white-box" id="n">
        <div class="spacing-container">
        </div>
        <div class="container">
            <div>
                <div class="pull-left">
                    <ol class="breadcrumb" itemprop="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                            <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li >
                            <a href="<?php echo Azooma::URL('press');?>" title="<?php echo Lang::get('messages.azooma').' '.Lang::get('messages.press');?>">
                                <?php echo Lang::get('messages.press');?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo $articletitle;?>
                        </li>
                    </ol>
                </div>
                <div class="pull-right">
                    <div class="bread-social">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
                    </div>
                    <div class="bread-social">
                        <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo $articletitle;?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div>
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 no-padding no-border">
                        <div class="sufrati-white-box inner-padding put-border">
                        <div id="social-share-list">
                            <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <?php
                        if($article->image!=""){ ?>
                        <div class="overflow article-image"> 
                            <img src="<?php echo Azooma::CDN('images/news/'.$article->image);?>" alt="<?php echo $articletitle;?>"/>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <?php } ?>
                        <div class="overflow article-text"> 
                            <?php echo ($lang=="en")?html_entity_decode(stripcslashes($article->full), 6, "UTF-8"):html_entity_decode(htmlspecialchars(stripcslashes($article->full_ar))); ?>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <div class="overflow">
                            <?php echo Lang::choice('messages.by',2);?> <?php echo ($lang=="en")?stripcslashes($article->author):stripcslashes($article->author_ar); ?> <?php echo Lang::choice('messages.on',1).' '.date('jS M Y',strtotime($article->newsDate));?>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <div id="social-share-list">
                            <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                        </div>
                        <div class="spacing-container"></div>
                        
                    </div>
                    <div class="spacing-container">
                    </div>
                    <div class="spacing-container">
                    </div>
                    </div>
                    <div class="sufrati-main-col-2">
                    </div>
                    <div class="sufrati-main-col-3 sufrati-white-box">
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Sufrati'};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
    <script type="text/javascript" >
    require(['article'],function(){});
    </script>
</body>
</html>