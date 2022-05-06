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
                            <a href="<?php echo Azooma::URL('blog');?>" title="<?php echo Lang::get('messages.azooma').' '.Lang::get('messages.blog');?>">
                                <?php echo Lang::get('messages.blog');?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo ($lang=="en")?stripcslashes($category->name):stripcslashes($category->nameAr);?>
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
                    <?php echo ($lang=="en")?stripcslashes($category->name):stripcslashes($category->nameAr);?>
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
                    <div class="sufrati-main-col-1 sufrati-white-box">
                        <div class="overflow">
                        <?php
                        if(count($articles)>0){ $i=0;
                            foreach ($articles as $article) { $i++;?>
                                <div class="articles-list overflow">
                                    <div class="article-image-place pull-left">
                                        <a href="<?php echo Azooma::URL('article/'.$article->url);?>" title="<?php echo ($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr); ?>">
                                            <img src="<?php echo Azooma::CDN('images/blog/thumb/'.$article->image);?>" alt="<?php echo ($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr); ?>">
                                        </a>
                                    </div>
                                    <div class="article-desc-place pull-right">
                                        <div class="caption">
                                            <a class="normal-text" href="<?php echo Azooma::URL('article/'.$article->url);?>" title="<?php echo ($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr); ?>">
                                                <h5><?php echo ($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr); ?></h5>
                                            </a>
                                            <div class="small-text">
                                                <span class="pull-left">
                                                    <?php echo ($lang=="en")?stripcslashes($article->author):stripcslashes($article->authorAr);?>
                                                </span>
                                                <span class="pull-right">
                                                    <?php echo date('jS M Y',strtotime($article->createdAt));?>
                                                </span>
                                            </div>
                                            <p>
                                                <?php echo ($lang=="en")?mb_substr(strip_tags(htmlspecialchars_decode(stripslashes($article->description))),0,200,'UTF-8'):mb_substr(strip_tags(htmlspecialchars_decode(stripslashes($article->descriptionAr))),0,200,'UTF-8');?>
                                            </p>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary pull-right" href="<?php echo Azooma::URL('article/'.$article->url);?>" title="<?php echo ($lang=="en")?stripcslashes($article->name):stripcslashes($article->nameAr); ?>"><?php echo Lang::get('messages.read_more');?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php }
                        }
                        echo $paginator->appends($var)->links();
                        ?>
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
</body>
</html>