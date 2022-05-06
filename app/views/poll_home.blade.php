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
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                            <li class="active">
                                <?php echo Lang::get('messages.poll');?>
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
        <div class="sufrati-head">
            <div class="container">
                <h1>
                <?php echo ($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar);?>
                </h1>
            </div>
        </div>
        <div class="spacing-container">
        </div>
        
        <div class="container">
            <div class="sufrati-main-col">
                <div class="col-mask-left">
                    <div class="sufrati-main-col-1 no-padding no-border">
                        <div class="sufrati-white-box inner-padding put-border">
                            <h2 class="rest-page-second-heading">
                                <?php echo ($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar);?>
                            </h2>
                            <div>
                                <?php if($latestpoll->image!=""){ ?>
                                <p>
                                    <img src="http://azooma.co/sa/images/poll/<?php echo $latestpoll->image;?>" alt="<?php echo ($lang=="en")?stripcslashes($latestpoll->question):stripcslashes($latestpoll->question_ar);?>"/>
                                </p>
                                <div class="spacing-container">
                                </div>
                                <?php }
                                if(!$showresults||($showresults&&$totalvotes<=0)){
                                ?>
                                <form action="<?php echo Azooma::URL('poll/'.$latestpoll->id);?>" class="poll-vote-form" method="post" >
                                <?php
                                }
                                if(count($latestoptions)>0){
                                    foreach ($latestoptions as $option) {
                                        if(!$showresults||($showresults&&$totalvotes<=0)){
                                        ?>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="polloption" id="polloption-<?php echo $option->id;?>" value="<?php echo $option->id;?>" <?php if(count($checkuservoted)>0&&$checkuservoted->option_id==$option->id){ echo 'checked';};?>/> <?php echo ($lang=="en")?stripcslashes($option->field):stripcslashes($option->field_ar);?>
                                            </label>
                                        </div>
                                        <?php
                                        }else{
                                            $results=($option->count/$totalvotes)*100
                                            ?>
                                            <div class="progress">
                                              <div class="progress-bar <?php if(count($checkuservoted)>0&&($checkuservoted->option_id==$option->id)){ ?>progress-bar-success<?php }else{ ?>progress-bar-primary <?php } ?>" role="progressbar" aria-valuenow="<?php echo $results;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $results;?>%">
                                              </div>
                                            </div>
                                            <div>
                                                <?php echo ($lang=="en")?stripcslashes($option->field):stripcslashes($option->field_ar);?> <?php echo $results;?>% ( <?php echo ucfirst(Lang::get('messages.total')).' '.$option->count.' '.ucfirst(Lang::choice('messages.vote',$option->count));?> )
                                            </div>
                                            <div class="right-col-spacing-container"></div>
                                            <?php
                                        }
                                    }
                                    if(!$showresults||($showresults&&$totalvotes<=0)){
                                    ?>
                                    <div class="form-group row">
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-lg"><?php echo Lang::choice('messages.vote',1);?></button>
                                            <a href="<?php echo Azooma::URL('poll/'.$latestpoll->id.'?results=1#n');?>" class="btn btn-light btn-lg"><?php echo Lang::get('messages.view_results') ?></a>
                                        </div>
                                    </div>
                                    <?php
                                    }else{
                                        ?>
                                        <a href="<?php echo Azooma::URL('poll/'.$latestpoll->id.'?poll=1');?>" class="btn btn-light "><?php echo Lang::get('messages.view_poll');?></a>
                                        <?php
                                    }
                                }
                                if(!$showresults||($showresults&&$totalvotes<=0)){
                                ?>
                                </form>
                                <?php }
                                if(count($polls)>0){
                                 ?>
                                <h2>
                                    <?php echo Lang::get('messages.other_polls');?>
                                </h2>
                                <?php foreach ($polls as $poll) {
                                    ?>
                                <div>
                                    <a href="<?php echo Azooma::URL('poll/'.$poll->id.'#n');?>" title="<?php echo ($lang=="en")?stripcslashes($poll->question):stripcslashes($poll->question_ar);?>">
                                        <h4><?php echo ($lang=="en")?stripcslashes($poll->question):stripcslashes($poll->question_ar);?></h4>
                                    </a>
                                </div>
                                    <?php  
                                }
                                 } ?>
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
        <div class="spacing-container">
        </div>
        @include('inc.footer')
    </body>
</html>