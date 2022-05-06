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
    <div class="sufrati-white-box" id="n">
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
                        <li class="active">
                            <?php echo Lang::get('messages.you_might_like');?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo Lang::get('messages.you_might_like');?>
                </h1>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="spacing-container">
            </div>
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 sufrati-white-box">
                        <?php 
                        if(count($likesuggestions)>0){
                            $fol=array(
                                'lang'=>$lang,
                                'user'=>$user,
                                'likesuggestions'=>$likesuggestions,
                            );
                            ?>
                            @include('user.helpers.like_suggestions',$fol)
                            <?php
                            if($total>count($likesuggestions)){
                                ?>
                                <div id="suggest-morebtn-cnt">
                                    <div class="spacing-container"></div>
                                    <button id="load-more-restaurant-tolike" data-user="<?php echo $user->user_ID;?>" data-loaded="15" class="btn btn-light btn-block btn-lg no-roundness load-more-button user-load-more-button">
                                        <?php echo Lang::get('messages.load_more');?>
                                    </button>
                                </div>
                                <?php
                            }
                        }
                        ?>
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
    @include('inc.footer',$meta)
    <script type="text/javascript">
    var load_more_txt="<?php echo Lang::get('messages.load_more');?>", loading_txt="<?php echo Lang::get('messages.loading');?>";
    require(['misc'],function(){});
    </script>
</body>
</html>