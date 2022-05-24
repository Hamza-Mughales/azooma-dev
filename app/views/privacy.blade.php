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
            {{-- Breadcrumb Section Start --}}
            <section class="Breadcrumb">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <ul class="breadcrumb-nav">
                                <li>
                                    <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                                    <?php echo Lang::get('messages.azooma'); ?></a>
                                </li>
                                <li class="active">
                                    <?php echo Lang::get('messages.privacy_policy');?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="breadcrumb-social">
                                <div class="social">
                                    <a href="https://twitter.com/share"><i class="fa fa-twitter"></i> Tweet</a>
                                </div>
                                <div class="social">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Request::url();?>"><i
                                            class="fa fa-facebook"></i> Share</a>
                                    {{-- <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{-- Breadcrumb Section End --}}

        <div>
            <div class="Azooma-head">
                <div class="container">
                    <h1 class="secttion-title mb-6">
                    <?php echo Lang::get('messages.privacy_policy');?>
                    </h1>
                </div>
            </div>
            <div class="spacing-container">
            </div>
            
            <div class="container Azooma-white-box">
                <div class="spacing-container">
                </div>
                <div id="iubenda_policy" class="Azooma-main-col mt-4" style="overflow: hidden">
                    <div class="iub_container iub_base_container">
                        <div id="wbars">
                            <div class="iub_content legal_pp">
                                <div class="simple_pp">
                                    <div class="one_line_col">
                                        <h2 id="policy-summary-head">
                                            <?php echo Lang::get('privacy.policy_summary');?>
                                        </h2>
                                    </div>
                                    <h2>
                                        <?php echo Lang::get('privacy.summary_sub_head');?>
                                    </h2>
                                    <ul class="for_boxes cf">
                                        <li class="one_line_col">
                                            <ul class="for_boxes">
                                                <li>
                                                    <div class="iconed policyicon_purpose_16">
                                                        <?php echo Lang::get('privacy.summary_social');?>
                                                        
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_5">
                                                        <?php echo Lang::get('privacy.summary_analytics');?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_10">
                                                        <?php echo Lang::get('privacy.summary_contact');?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_13">
                                                        <?php echo Lang::get('privacy.summary_content');?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_26">
                                                        <?php echo Lang::get('privacy.summary_interaction');?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_17">
                                                        <?php echo Lang::get('privacy.summary_location');?>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="iconed policyicon_purpose_9">
                                                        <?php echo Lang::get('privacy.summary_registration');?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h2>
                                        <?php echo Lang::get('privacy.further_head');?>
                                    </h2>
                                    <ul class="for_boxes cf">
                                        <li class="one_line_col wide">
                                            <ul class="for_boxes">
                                                <li>
                                                    <div class="iconed icon_general">
                                                        <?php echo Lang::get('privacy.further_desc');?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <h2><?php echo Lang::get('messages.contact_info');?></h2>
                                    <ul class="for_boxes cf">
                                        <li class="one_line_col">
                                            <ul class="for_boxes">
                                                <li>
                                                    <div class="iconed icon_owner">
                                                        <?php echo Lang::get('privacy.contact_desc');?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="one_line_col">
                                    <h2 style="text-align: center; font-variant:small-caps;"><?php echo Lang::get('privacy.full_policy');?></h2>
                                </div>
                                <div class="one_line_col">
                                    <?php echo Lang::get('privacy.full_owner');?>
                                </div>
                                <div class="one_line_col">
                                    <?php echo Lang::get('privacy.data_types');?>
                                </div>
                                <div class="one_line_col">
                                    <?php echo Lang::get('privacy.mode_processing');?>
                                </div>
                                <div class="one_line_col">
                                    <?php echo Lang::get('privacy.collected_data_use');?>
                                </div>
                                <div class="one_line_col">
                                    <?php echo Lang::get('privacy.facebook_permissions');?>
                                </div>
                                <div class="one_line_col">
                                    <h2><?php echo Lang::get('privacy.detailed_head');?></h2>
                                    <p><?php echo Lang::get('privacy.detailed_desc');?></p>
                                    <ul class="for_boxes">
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_128100" data-bs-toggle="collapse" data-bs-target="#access-social-tab">
                                                    <?php echo Lang::get('privacy.detailed_social_head');?>
                                                </h3>
                                                <div id="access-social-tab" class="expand-content collapse">
                                                    <?php echo Lang::get('privacy.detailed_social_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_128099" data-bs-toggle="collapse" data-bs-target="#analytics-tab">
                                                    <?php echo Lang::get('privacy.detailed_analytics_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="analytics-tab">
                                                    <?php echo Lang::get('privacy.detailed_analytics_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_128101" data-bs-toggle="collapse" data-bs-target="#contact-tab">
                                                    <?php echo Lang::get('privacy.detailed_contact_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="contact-tab">
                                                    <?php echo Lang::get('privacy.detailed_contact_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_130101" data-bs-toggle="collapse" data-bs-target="#content-tab">
                                                    <?php echo Lang::get('privacy.detailed_content_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="content-tab">
                                                    <?php echo Lang::get('privacy.detailed_content_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_128102" data-bs-toggle="collapse" data-bs-target="#interaction-tab">
                                                    <?php echo Lang::get('privacy.detailed_interaction_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="interaction-tab">
                                                    <?php echo Lang::get('privacy.detailed_interaction_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_130103" data-bs-toggle="collapse" data-bs-target="#location-tab">
                                                    <?php echo Lang::get('privacy.detailed_location_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="location-tab">
                                                    <?php echo Lang::get('privacy.detailed_location_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 policyicon_purpose_130104" data-bs-toggle="collapse" data-bs-target="#registration-tab">
                                                    <?php echo Lang::get('privacy.detailed_registration_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="registration-tab">
                                                    <?php echo Lang::get('privacy.detailed_registration_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="one_line_col">
                                    <h2>
                                        <?php echo Lang::get('privacy.further_info_head');?>
                                    </h2>
                                    <ul class="for_boxes">
                                        <li>
                                            <div class="box_primary box_10 expand collapsed">
                                                <h3 class="expand-click w_icon_24 icon_general" data-bs-toggle="collapse" data-bs-target="#push-tab">
                                                    <?php echo Lang::get('privacy.further_push_head');?>
                                                </h3>
                                                <div class="expand-content collapse" id="push-tab">
                                                    <?php echo Lang::get('privacy.further_push_desc');?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="one_line_col">
                                    <h2>
                                        <?php echo Lang::get('privacy.add_info_head');?>
                                    </h2>
                                    <?php echo Lang::get('privacy.add_info_desc');?>
                                </div>
                                <div class="one_line_col">
                                    <div class="box_primary box_10 definitions expand collapsed">
                                        <h3 class="expand-click w_icon_24 icon_ribbon" data-bs-target="#legal-tab" data-bs-toggle="collapse">
                                        <?php echo Lang::get('privacy.definintion_head');?>
                                        </h3>
                                        <div class="expand-content collapse" id="legal-tab">
                                            <?php echo Lang::get('privacy.definintion_desc');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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