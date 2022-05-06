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
<body <?php if($lang=="ar"){?>class="arabic" <?php } ?>itemscope itemtype="http://schema.org/WebPage">
    <?php $nonav=array('nonav'=>true); ?>
    @include('inc.header',$nonav)


    {{-- Breadcrumb Section Start --}}
    <section class="Breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <ul class="breadcrumb-nav">
                        <li>
                            <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                <?php echo Lang::get('messages.azooma'); ?></a>
                        <li class="active">
                            <?php echo Lang::get('email.reset_password');?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {{-- Breadcrumb Section End --}}
    {{-- Register Page --}}
<section class="register-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 reg-con">
                <h2>    <?php echo Lang::get('email.reset_password');?></h2> 
                {{-- Register Form --}}
                <?php 
                if(Session::has('success')){
                ?>
                <div class="overflow">
                    <div class="alert alert-success ">
                        <?php echo Session::get('success');?>
                    </div>
                </div>
                <?php
            }else{
                ?>
            <form id="reset-form" action="<?php echo Azooma::URL('resetpassword');?>" method="post" class="form-horizontal register-form" role="form">
                <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="password" class="form-control" name="new-password" id="new-password" placeholder="<?php echo Lang::get('messages.new_password');?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="<?php echo Lang::get('messages.confirm_password');?>">
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="id" value="<?php echo $user->user_ID;?>"/> 
                    <div class="col-sm-offset-4 col-sm-12">
                      <button type="submit" class="btn btn-light big-main-btn"><?php echo Lang::get('messages.reset');?></button>
                    </div>
                </div>
            </form>
                <?php
            } 
            ?>
            </div>
       
        </div>
    </div>
</section>


    @include('inc.footer')
</body>
</html>