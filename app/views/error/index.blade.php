<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'/>
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
                <ol class="breadcrumb" itemprop="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                        <?php echo Lang::get('messages.azooma'); ?></a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo Lang::get('messages.page_not_found');?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div><div class="spacing-container">
        </div>
        <div class="container sufrati-white-box put-border inner-padding" id="error-page-cont">
            <h2>
                <?php echo Lang::get('messages.error_head');?>
            </h2>
            <p>
                <?php echo Lang::get('messages.error_desc');?>
            </p>
        </div>
    </div>
    <div class="spacing-container">
    </div><div class="spacing-container">
    </div>
    @include('inc.footer')
</body>
</html>