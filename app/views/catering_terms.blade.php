<!doctype html>
<html lang="<?php echo $lang;?>">
    <head>
        @include('inc.metaheader',$meta)
        <?php
        if(isset($metastring)){
        echo $metastring;
        }
        echo HTML::style('css/privacy.css');
        ?>
    </head>
    <body <?php if($lang=="ar"){?>class="arabic" <?php } ?>itemscope itemtype="http://schema.org/WebPage">
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
                            <li class="active">
                                <?php echo Lang::get('messages.catering_terms');?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="Azooma-head">
                <div class="container">
                    <h1>
                    <?php echo Lang::get('messages.catering_terms');?>
                    </h1>
                </div>
            </div>
            <div class="spacing-container">
            </div>
            
            <div class="container Azooma-white-box put-border inner-padding">
                <div class="spacing-container">
                </div>
                <div>
                    <p>
                        <?php echo Lang::get('catering.catering_para1');?>        
                    </p>
                    <p>
                        <?php echo Lang::get('catering.catering_para2');?>
                    </p>
                    <p>
                        <?php echo Lang::get('catering.catering_note1');?>
                    </p>
                    <h3>
                        <?php echo Lang::get('catering.title1');?>
                    </h3>
                    <ul>
                        <li>
                            <?php echo Lang::get('catering.pay_list1');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.pay_list2');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.pay_list3');?>
                        </li>
                    </ul>
                    <p>
                        <?php echo Lang::get('catering.valued_customer');?>
                    </p>
                    <p>
                        <?php echo Lang::get('catering.catering_para3');?>
                    </p>
                    <h3>
                        <?php echo Lang::get('catering.terms_conditions_of_service');?>
                    </h3>
                    <p>
                        <b>
                            <?php echo Lang::get('catering.payments_by_bank_transfer');?>   
                        </b>
                    </p>
                    <p>
                        <b>
                            <?php echo Lang::get('catering.for_event_budget_below');?>   
                        </b>
                    </p>
                    <ul>
                        <li>
                            <?php echo Lang::get('catering.below_list1');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.below_list2');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.below_list3');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.below_list4');?>
                        </li>
                    </ul>
                    <p>
                        <b>
                            <?php echo Lang::get('catering.for_event_budget_above');?>   
                        </b>
                    </p>
                    <ul>
                        <li>
                            <?php echo Lang::get('catering.above_list1');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.above_list2');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.above_list3');?>
                        </li>
                        <li>
                            <?php echo Lang::get('catering.above_list4');?>
                        </li>
                    </ul>
                    <h3>
                        <?php echo Lang::get('catering.title2');?>
                    </h3>
                    <p>
                        <?php echo Lang::get('catering.force_para');?>
                    </p>
                    <h3>
                        <?php echo Lang::get('catering.title3');?>
                    </h3>
                    <p>
                        <?php echo Lang::get('catering.liability_para');?>
                    </p>
                </div> 
            </div>
            <div class="spacing-container">
            </div>
            <div class="spacing-container">
            </div>
        </div>
        @include('inc.footer')
    </body>
</html>