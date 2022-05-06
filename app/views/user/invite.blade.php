<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
    <script src="https://apis.google.com/js/client:platform.js" async defer></script>
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
                            <?php echo Lang::get('messages.invite_friends');?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="sufrati-head">
            <div class="container">
                <h1>
                    <?php echo Lang::get('messages.invite_friends');?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div>
        <div class="container">
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 sufrati-white-box ">
                        <div id="invite-friends">
                            <h3 class="rest-page-second-heading">
                                <?php echo Lang::get('messages.its_more_fun_with_friends');?>
                            </h3>
                            <div class="spacing-container">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6" id="facebook-connect-block">
                                    
                                </div>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a href="#connect-google-tab" data-bs-toggle="tab">
                                        <b><?php echo Lang::get('messages.google');?></b>
                                    </a>
                                </li>
                                <li>
                                    <a href="#connect-facebook-tab" data-bs-toggle="tab">
                                        <b><?php echo Lang::get('messages.facebook');?></b>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="connect-google-tab">
                                    <div class="spacing-container"></div>
                                    <button id="connect-google" class="btn btn-lg btn-block btn-danger"><?php echo Lang::get('messages.connect_with_google');?></button>
                                </div>
                                <div class="tab-pane" id="connect-facebook-tab">
                                    <div class="spacing-container"></div>
                                    <button id="connect-facebook-btn" class="btn btn-lg btn-block btn-camera"><?php echo Lang::get('messages.connect_with_facebook');?></button>
                                </div>
                            </div>
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
        <div class="spacing-container">
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">
    <?php if($user->google!=0){ ?>
    var google=<?php echo $user->google;?>;
    <?php } ?>
        require(['invite'],function(){});
    </script>
</body>
</html>