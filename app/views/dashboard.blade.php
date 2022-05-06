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
    <?php $nonav=array('nonav'=>false); ?>
    @include('inc.header',$nonav)
    <div class="register-nav-box" id="dashboard-box">
       <div class="container">
           <div class="row">
               <div class="col-md-12">
                <ul>
                    <li <?php if($step==1){ echo 'class="active"'; }?>>
                       <i class="far fa-user-circle"></i> <?php echo Lang::get('title.tell_us_about_you');?>
                    </li>
                    <li <?php if($step==2){ echo 'class="active"'; }?>>
                        <i class="far fa-heart"></i> <?php echo Lang::get('title.choose_favorite');?>
                    </li>
                    <li <?php if($step==3){ echo 'class="active"'; }?>>
                        <i class="far fa-thumbs-up"></i> <?php echo Lang::get('title.lets_like');?>
                    </li>
                    <li <?php if($step==4){ echo 'class="active"'; }?>>
                        <i class="far fa-check-circle"></i> <?php echo Lang::get('title.lets_follow');?>
                    </li>
                </ul>
               </div>
           </div>
       </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 cl-sm-12">
                @include('user.step.'.$view,$subdata)
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="register-banner">
                    <img src="<?php echo asset('img/register-banner.svg') ?>" alt="register banner">
                    <div class="content">
                        <h2> <?php echo Lang::get('messages.WelcometoAzooma');?></h2>
                        <p> <?php echo Lang::get('messages.registerwelcome');?> </p>
                        <a class="big-white-btn" href="#"><?php echo Lang::get('messages.learnmore');?> </a>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
    @include('inc.footer')
    <script type="text/javascript">
    require(['user-step'],function(){});
    </script>
    <script src="<?php echo URL::asset('js/user-step.js');?>"></script>
</body>
</html>