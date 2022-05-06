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
                            <?php echo Lang::get('messages.cuisines_you_like');?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo Lang::get('messages.cuisines_you_like');?>
                </h1>
            </div>
        </div>
    </div>
    <div>
        <div class="container" id="user-preferences-block">
            <div class="spacing-container">
            </div>
            <div class="sufrati-white-box put-border inner-padding">
                <div class="overflow">
                    <button type="button" class="btn btn-camera btn-lg pull-right first user-preference-save-btn"><?php echo Lang::get('messages.save');?></button>
                </div>
                <?php if(count($allcuisines)>0){ ?>
                <ul class="cuisine-like-list overflow">
                <?php foreach ($allcuisines as $cuisine) {
                    $checkuserliked=User::checkUserLikeCuisine($cuisine->cuisine_ID,Session::get('userid'));
                ?>
                    <li>
                        <a <?php if(count($checkuserliked)>0){ ?>data-selected="1"<?php } ?> data-cuisine="<?php echo $cuisine->cuisine_ID;?>" href="javascript:void(0);" title="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>">
                          <img class="sufrati-super-lazy" src="http://uploads.azooma.co/stat/blank.gif" data-original="<?php echo Azooma::CDN('images/cuisine/'.$cuisine->image);?>" alt="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>">
                          <span class="title"><?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?></span>
                          <span class="selected <?php if(count($checkuserliked)<=0){ ?> hidden <?php } ?><i class="fa fa-heart"></i></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                <div class="overflow">
                    <button type="button" class="btn btn-camera btn-lg pull-right last user-preference-save-btn"><?php echo Lang::get('messages.save');?></button>
                </div>
            </div>
            <form action="<?php echo Azooma::URL('userpreference/save');?>" method="post">
                <input type="hidden" name="cuisines[]" id="user-liked-cuisines"/>
                <input type="hidden" name="notcuisines[]" id="user-disliked-cuisines"/>
            </form>
        </div>
    </div>
    @include('inc.footer',$meta)
    <script type="text/javascript">
    var load_more_txt="<?php echo Lang::get('messages.load_more');?>", loading_txt="<?php echo Lang::get('messages.loading');?>";
    require(['misc'],function(){});
    </script>
</body>
</html>