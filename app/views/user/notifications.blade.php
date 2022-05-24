<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    echo HTML::style('css/jquery.Jcrop.min.css');
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    <?php
    $header=array('nonav'=>TRUE);
    ?>
    @include('inc.header',$header)
    <div class="container ">
        <div class="spacing-container">
        </div>
        <div class="overflow">
            <a class="btn pull-right" title="<?php echo Lang::get('messages.back_to_profile');?>" href="<?php echo Azooma::URL('user/'.$user->user_ID.'#n');?>"><?php echo Lang::get('messages.back_to_profile');?></a>
        </div>
        <div class="spacing-container">
        </div>
        <div class="Azooma-white-box put-border inner-padding">
            <div class="overflow">
                <h4 class="inline-block">
                    <?php echo Lang::get('messages.your').' '.Lang::choice('messages.notification',$totalnotifications);?>
                </h4>
                <?php  if($newnotifications>0){ ?>
                <a class="btn btn-camera pull-right" href="<?php echo Azooma::URL('user/'.$user->user_ID.'/clearnotifications');?>" title="<?php echo Lang::get('messages.mark_all_read');?>">
                    <b><?php echo Lang::get('messages.mark_all_read');?></b>
                </a>
                <?php  } ?>
            </div>
            <div class="overflow">
                <?php
                if(count($usernotifications)>0){
                    $notifdata=array(
                        'notifications'=>$usernotifications,
                        'totalnotifications'=>$totalnotifications,
                        'user'=>$user,
                        'username'=>$username
                    )
                    ?>
                    @include('user.helpers._notification',$notifdata)
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="spacing-container">
    </div>
    @include('inc.footer')
    <script type="text/javascript">
    require(['bootstrap-switch.min','usersettings','jquery.Jcrop.min'],function(){});
    </script>
</body>
</html>