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
    <div class=" Azooma-white-box" id="n">
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
                        <li>
                            <a href="<?php echo Azooma::URL('blog/'.$category->url);?>" title="<?php echo ($lang=="en")?stripcslashes($category->name):stripcslashes($category->nameAr); ?>">
                                <?php echo ($lang=="en")?stripcslashes($category->name):stripcslashes($category->nameAr); ?>
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
        <div class="Azooma-head">
            <div class="container">
                <h1>
                    <?php echo $articletitle;?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div>
        
        <?php 
        if(isset($errors)){
            if(!$errors->isEmpty()){
                ?>
                <div class="container">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $errors->first();?>
                    </div>
                </div>
                <?php
            }    
        }
        if(Session::has('success')){
            ?>
            <div class="container">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo Session::get('success');?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="Azooma-main-col">
                <div class="col-mask-left">
                    <div class="Azooma-main-col-1 no-padding no-border">
                        <div class="Azooma-white-box inner-padding put-border">
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
                            <img src="<?php echo Azooma::CDN('images/blog/'.$article->image);?>" alt="<?php echo $articletitle;?>"/>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <?php } ?>
                        <div class="overflow article-text"> 
                            <?php echo ($lang=="en")?html_entity_decode(stripcslashes($article->description), 6, "UTF-8"):html_entity_decode(htmlspecialchars(stripcslashes($article->descriptionAr))); ?>
                        </div>
                        <div class="spacing-container">
                        </div>
                        <div class="overflow">
                            <?php echo Lang::choice('messages.by',2);?> <?php echo ($lang=="en")?stripcslashes($article->author):stripcslashes($article->authorAr); ?> <?php echo Lang::choice('messages.on',1).' '.date('jS M Y',strtotime($article->createdAt));?>
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
                        <div class="overflow">
                            <h3>
                                <?php echo Lang::get('messages.you_might_also_like');?>
                            </h3>
                            <ul class="related-list">
                                <?php foreach ($related as $rlt) { ?>
                                    <li>
                                        <a class="block" href="<?php echo Azooma::URL('article/'.$rlt->url);?>" title="<?php echo ($lang=="en")?stripcslashes($rlt->name):stripcslashes($rlt->nameAr); ?>">
                                            <img src="<?php echo Azooma::CDN('images/blog/thumb/'.$rlt->image);?>" alt="<?php echo ($lang=="en")?stripcslashes($rlt->name):stripcslashes($rlt->nameAr); ?>">
                                        </a>
                                        <div>
                                            <a class="title" href="<?php echo Azooma::URL('article/'.$rlt->url);?>" title="<?php echo ($lang=="en")?stripcslashes($rlt->name):stripcslashes($rlt->nameAr); ?>">
                                                <?php echo ($lang=="en")?stripcslashes($rlt->name):stripcslashes($rlt->nameAr); ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="spacing-container">
                        </div>
                    </div>
                    <div class="spacing-container">
                    </div>
                    <?php if(count($comments)>0){
                    ?>
                    <div class="Azooma-white-box put-border">
                        <h4 class="third-heading with-margin">
                            <?php echo Lang::get('messages.comments');?>
                        </h4>
                        <div class="spacing-container"></div>
                        <div class="overflow inner-padding">
                            <?php 
                            $t=0;
                            foreach ($comments as $comment) { $t++;
                                if($comment->comment!=""){
                                $user=array();
                                if($comment->userID!=0){
                                    $user=User::checkUser($comment->userID);
                                    if(count($user)>0){
                                        $user=$user[0];
                                        $username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
                                        $userimage=$user->image;
                                        if($userimage==""){
                                            $userimage="user-default.svg";
                                        }
                                    }else{
                                        $username=stripcslashes($comment->name);
                                        $userimage="user-default.svg";
                                    }
                                }else{
                                    $username=stripcslashes($comment->name);
                                    $userimage="user-default.svg";
                                }
                                ?>
                                <div class="overflow Azooma-user-review <?php if($t==count($comments)){ echo 'last'; } ?>">
                                    <div class="pull-left Azooma-user-info">
                                        <?php if(count($user)>0){
                                            ?>
                                            <a class="rest-logo" href="<?php echo Azooma::URL('user/'.$comment->userID);?>" alt="<?php echo $username;?>">
                                            <?php }else{
                                                ?>
                                            <span class="rest-logo">
                                                <?php
                                            }   
                                            ?>
                                            <img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>" width="60" height="60">
                                            <?php if(count($user)>0){ ?>
                                            </a>
                                            <?php }else{    ?>
                                            </span>
                                            <?php } ?>
                                    </div>
                                    <div class="pull-left Azooma-review-info">
                                        <div class="review-author-date">
                                            <div class="overflow ">
                                                <?php if(count($user)>0){
                                                ?>
                                                <a class="pull-left author" href="<?php echo Azooma::URL('user/'.$comment->userID);?>" alt="<?php echo $username;?>">
                                                <?php }else{
                                                    ?>
                                                <span class="pull-left author">
                                                    <?php
                                                }   
                                                echo $username;
                                                if(count($user)>0){ ?>
                                                </a>
                                                <?php }else{    ?>
                                                </span>
                                                <?php } ?>
                                                <span class="small pull-right"><?php echo Azooma::Ago($comment->createdAt);?></span>
                                            </div>
                                        </div>
                                        <div class="review">
                                            <?php
                                            if(Azooma::isArabic($comment->comment)){
                                                echo stripcslashes($comment->comment);
                                            }else{
                                                echo htmlspecialchars(html_entity_decode(htmlentities(ucfirst(stripcslashes($comment->comment)),6,'UTF-8'),6,"UTF-8"),ENT_QUOTES,'utf-8');
                                            }
                                            ?>
                                        </div>
                                        <div class="spacing-container">
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } }
                            ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="spacing-container">
                        </div>
                        <div class="Azooma-white-box put-border">
                            <div class="overflow">
                                <h4 class="third-heading with-margin">
                                    <?php echo Lang::get('messages.add_your_comment');?>
                                </h4>
                                <div class="spacing-container">
                                </div>
                                <form id="add-articlecomment-form" class="form-horizontal" role="form" method="post" action="<?php echo Azooma::URL('add/articlecomment');?>">
                                    <div class="col-sm-12" id="articlecomment-error-box">
                                       <div class="alert alert-danger">
                                        <?php echo Lang::get('messages.please_add_comment');?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo Lang::get('messages.comment');?></label>
                                        <div class="col-sm-9">
                                            <textarea rows="5" class="form-control" id="articlecomment" name="articlecomment"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <?php if(Session::has('userid')){ ?>
                                        <input type="hidden" name="userid" value="<?php echo Session::get('userid');?>"/> 
                                        <?php } ?>
                                        <input type="hidden" name="articleid" value="<?php echo $article->id;?>"/> 
                                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-9">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit" id="add-comment-article-btn"><?php echo Lang::get('messages.submit');?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="Azooma-main-col-2">
                    </div>
                    <div class="Azooma-main-col-3 Azooma-white-box">
                        <div class="right-col-block">
                            <div class="right-col-head">
                                <?php  echo Lang::get('messages.archive');?>
                            </div>
                            <div class="right-col-desc">
                              <ul>
                                <?php
                                if(count($archives)>0){
                                    foreach ($archives as $archive) {
                                ?>
                                <li>
                                    <a href="<?php echo Azooma::URL('blog');?>" title="<?php echo $archive->month.' '.$archive->year.' '.Lang::get('messages.articles');?>">
                                        <?php echo $archive->month.' '.$archive->year.' ('.$archive->articles.')'; ?>
                                    </a>
                                </li>
                                <?php        
                                    }
                                }
                                ?>
                              </ul>  
                            </div>
                        </div>
                        @include('inc.rightcol')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,'services_expanded':'facebook,twitter,print,email','services_compact':'facebook,twitter,print,email','ui_cobrand':'Azooma'};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5289d82629d64c3d"></script>
    <script type="text/javascript" >
    require(['article'],function(){});
    </script>
</body>
</html>