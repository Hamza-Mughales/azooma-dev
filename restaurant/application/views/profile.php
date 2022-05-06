<div class="pt-2 text-start">
    <ul class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?php echo base_url('home'); ?>"><?=lang('Dashboard')?></a> <span class="divider">/</span>
    </li>
    <li class="active"><?=lang('profile_page')?> </li>
</ul>
</div>

<section class="card" id="top-banner">

    <div class="card-body mt-3">
        <article class="span12 accordion-group">


            <div id="restinfo" class=" accordion-inner">
                <?php
              echo message_box('error');
              echo message_box('success');
                ?>
                <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('profile/save/'); ?>" enctype="multipart/form-data">

                    <h4><?= lang('general_info') ?></h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="cuisine"><?= lang('select_cuisines') ?></label>
                                <div class="col-md-12">
                                    <?php
                                    if (isset($rest)) {
                                        $cuisineList = array();
                                        $bestList = array();
                                        if (is_array($restcuisines)) {
                                            foreach ($restcuisines as $val) {
                                                $cuisineList[] = $val['cuisine_ID'];
                                            }
                                        }
                                        if (is_array($restbestfors)) {
                                            foreach ($restbestfors as $val) {
                                                $bestList[] = $val['bestfor_ID'];
                                            }
                                        }
                                    }
                                    $maxcuisine = 2;
                                    $maxbest = 1;
                                    $msgcuisine = "Maximum <strong>2 Cuisines</strong> can be selected";
                                    $msgbest = "Maximum <strong>1 Best</strong> for can be selected";
                                    if (isset($rest)) {
                                        switch ($rest['rest_Subscription']) {
                                            case 1:
                                                $maxcuisine = 3;
                                                $maxbest = 1;
                                                $msgcuisine = "Maximum <strong>3 Cuisines</strong> can be selected";
                                                $msgbest = "Maximum <strong>1 Best</strong> for can be selected";
                                                break;
                                            case 2:
                                                $maxcuisine = 3;
                                                $maxbest = 2;
                                                $msgcuisine = "Maximum <strong>3 Cuisines</strong> can be selected";
                                                $msgbest = "Maximum <strong>2 Best</strong> for can be selected";
                                                break;
                                            case 3:
                                                $maxcuisine = 4;
                                                $maxbest = 4;
                                                $msgcuisine = "Maximum <strong>4 Cuisines</strong> can be selected";
                                                $msgbest = "Maximum <strong>4 Best</strong> for can be selected";
                                                break;
                                        }
                                    }
                                    ?>

                                    <select multiple class="chzn-select form-control select2 required" data-maxpersons="<?php echo $maxcuisine; ?>" tabindex="7" style="width: 350px;" data-placeholder="Select Cuisines" name="cuisine[]" id="cuisine">
                                        <?php
                                        if (isset($rest)) {
                                            if (is_array($cuisines)) {
                                                foreach ($cuisines as $cuisine) {
                                        ?>
                                                    <option <?php if (in_array($cuisine['cuisine_ID'], $cuisineList)) echo 'selected="selected"'; ?> value="<?php echo $cuisine['cuisine_ID']; ?>">
                                                        <?php echo stripslashes($cuisine['cuisine_Name']); ?>
                                                    </option>
                                                <?php
                                                }
                                            }
                                        } else {
                                            if (is_array($cuisines)) {
                                                foreach ($cuisines as $cuisine) {
                                                ?>
                                                    <option value="<?php echo $cuisine['cuisine_ID']; ?>">
                                                        <?php echo stripslashes($cuisine['cuisine_Name']); ?>
                                                    </option>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <p style="font-size:12px;">(<?php echo $msgcuisine; ?>)</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="rest_Name"><?= lang('rest_name') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_Name" id="rest_Name" <?php echo isset($rest) ? 'value="' . (($rest['rest_Name'])) . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>




                        <div class="col-md-6 mt-3">
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="rest_Name_Ar"><?= lang('rest_name_arabic') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_Name_Ar" id="rest_Name_Ar" <?php echo isset($rest) ? 'value="' . (($rest['rest_Name_Ar'])) . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="opening"><?= lang('year_of_opening') ?></label>
                                <div class="col-md-12">
                                    <select name="opening" class="form-control required">
                                        <?php
                                        for ($i = date('Y'); $i > 1950; $i--)
                                            echo "<option value='$i'>$i</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <h4 class="my-3 mt-4">
                        <?= lang('buss_rest_title') ?>
                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="rest_Email"><?= lang('buss_email') ?></label>
                                <div class="col-md-12 sufrati-backend-input-seperator" id="memberemails">
                                    <?php if (isset($rest)) {
                                        $rest_Emails = explode(',', $rest['rest_Email']);
                                        $count_members_details = count($rest_Emails);
                                        echo "<script type='text/javascript'> var counter='" . $count_members_details . "' </script> ";
                                        for ($i = 0; $i < count($rest_Emails); $i++) {
                                    ?>

                                            <div id="input-<?php echo $i; ?>" class="mb-3 row input-<?php echo $i; ?>">
                                                <div class="col-sm-11">
                                                    <input type="email" class="form-control " name="rest_Email[]" placeholder="Contact Email" <?php echo isset($rest_Emails) ? 'value="' . $rest_Emails[$i] . '"' : ""; ?> required />
                                                </div>
                                                <div class="col-sm-1 my-1 text-start">
                                                    <a class=" btn-sm btn-danger close email-remove" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div id="input-0">
                                            <input type="email" class="form-control" name="rest_Email[]" placeholder="Restaurant Email, Managers Email, Owner`s Email" required />
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group my-2 row mb-3">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="addMoreEmail();"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="rest_WebSite"><?= lang('website') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_WebSite" id="rest_WebSite" placeholder="Website" <?php echo isset($rest) ? 'value="' . $rest['rest_WebSite'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="facebook_fan"><?= lang('fb_page') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="facebook_fan" id="facebook_fan" placeholder="Facebook Page" <?php echo isset($rest) ? 'value="' . $rest['facebook_fan'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="control-label" for="head_office"><?= lang('head_of_num') ?></label>
                                <div class="controls">
                                    <input type="text" class="form-control" name="head_office" id="head_office" placeholder="Head office Number" <?php echo isset($rest) ? 'value="' . $rest['head_office'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="rest_TollFree"><?= lang('toll_num') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_TollFree" id="rest_TollFree" placeholder="Toll Free Number" <?php echo isset($rest) ? 'value="' . $rest['rest_TollFree'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="rest_Telephone"><?= lang('rest_tel') ?> </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_Telephone" id="rest_Telephone" placeholder="Restaurant Telephone" <?php echo isset($rest) ? 'value="' . $rest['rest_Telephone'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="rest_Mobile"><?= lang('devl_num') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_Mobile" id="rest_Mobile" placeholder="Delivery Number" <?php echo isset($rest) ? 'value="' . $rest['rest_Mobile'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row  my-2">
                                <label class="col-md-12 control-label" for="rest_pbox"><?= lang('po_box') ?></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="rest_pbox" id="rest_pbox" placeholder="P.O.Box" <?php echo isset($rest) ? 'value="' . $rest['rest_pbox'] . '"' : ""; ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="my-3">
                        <h4><?=lang('about_rest')?></h5>
                            <div class="form-group row">
                                <label class="col-md-12 control-label" for="rest_Logo"><?= lang('logo') ?></label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="rest_Logo" id="rest_Logo" />

                                </div>
                                <div class="col-md-6">
                                    <?php
                                    if (isset($rest) && ($rest['rest_Logo'] != "")) {
                                    ?>
                                        <img height="80" src="http://uploads.azooma.co/logos/<?php echo $rest['rest_Logo']; ?>" />
                                        <input type="hidden" name="rest_Logo_old" value="<?php echo $rest['rest_Logo']; ?>" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label" for="rest_Description"><?= lang('rest_desc') ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" onkeyup="countChar(this);" name="rest_Description" id="restDescription" rows="5" placeholder="Restaurant Description"><?php if (isset($rest) && ($rest['rest_Description'] != "")) echo stripcslashes($rest['rest_Description']); ?></textarea>
                                            <span class="badge badge-info" id="charNum"><?php echo $allowed_chars; ?></span>
                                            <div id="count-message" class="hidden"><?=lang('maximum')?> <?php echo $allowed_chars; ?> <?=lang('characters')?> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label" for="rest_Description_Ar"><?= lang('rest_desc_ar') ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" onkeyup="countCharAr(this);" name="rest_Description_Ar" id="rest_Description_Ar" rows="5" dir="rtl" placeholder="Restaurant Description Arabic"><?php if (isset($rest) && ($rest['rest_Description'] != "")) echo stripcslashes($rest['rest_Description_Ar']); ?></textarea>
                                            <span class="badge badge-info" id="charNumAr"><?php echo $allowed_chars; ?></span>
                                            <div id="count-message-ar" class="hidden"><?=lang('maximum')?> <?php echo $allowed_chars; ?> <?=lang('characters')?> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label" for="rest_tags"><?= lang('rest_tags') ?></label>
                                        <div class="col-md-12">

                                            <input type="text" class="form-control select2-tag" name="rest_tags" id="rest_tags" placeholder="Restaruant Tags" <?php echo isset($rest) ? 'value="' . ($rest['rest_tags']) . '"' : ""; ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label" for="rest_tags_ar"><?= lang('rest_tags_ar') ?></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control select2-tag" name="rest_tags_ar" id="rest_tags_ar" placeholder="Restaruant Tags Arabic" <?php echo isset($rest) ? 'value="' . ($rest['rest_tags_ar']) . '"' : ""; ?> />
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                    <section>
                        <h4 class="my-3">
                            
                            <?=lang('open_hours_day')?>
                        </h4>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group row">
                                    <label class="col-md-12 control-label" for="week_days_start"><?=lang('week_days')?></label>
                                    <div class="col-md-3">
                                        <select class="form-control select2 auto-width" name="week_days_start">
                                            <option value=""><?=lang('open_time')?></option>
                                            <?php
                                            for ($i = 0; $i <= 24; $i++) {
                                                if ($i <= 9) $i = "0" . $i;
                                                for ($j = 0; $j <= 1; $j++) {
                                                    if ($j == 0) $min = '00';
                                                    else $min = 30;
                                                    $tim = $i . ":" . $min;
                                                    if ($tim == "00:00") continue;
                                                    if ($tim != "24:30") {
                                                        if ($i >= 12 and $i != 24) $mer = " pm";
                                                        else $mer = " am";
                                                        $act_time = $tim;
                                                        if (isset($openHours['week_days_start']) and $openHours['week_days_start'] == $act_time) {
                                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                        } else {
                                                            echo "<option value='$act_time'>$act_time</option>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">

                                        <select class="form-control select2 auto-width" name="week_days_close">
                                            <option value=""><?=lang('close_time')?></option>
                                            <?php
                                            for ($i = 0; $i <= 24; $i++) {
                                                if ($i <= 9) $i = "0" . $i;
                                                for ($j = 0; $j <= 1; $j++) {
                                                    if ($j == 0) $min = '00';
                                                    else $min = 30;
                                                    $tim = $i . ":" . $min;
                                                    if ($tim == "00:00") continue;
                                                    if ($tim != "24:30") {
                                                        if ($i >= 12 and $i != 24) $mer = " pm";
                                                        else $mer = " am";
                                                        $act_time = $tim;
                                                        if (isset($openHours['week_days_close']) and $openHours['week_days_close'] == $act_time) {
                                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                        } else {
                                                            echo "<option value='$act_time'>$act_time</option>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    if (isset($rest)) {
                                        $weekdays = $weekends = $brunch = $breakfast = "";
                                        if (!empty($restdays['weekdays'])) {
                                            $weekdays = explode(',', $restdays['weekdays']);
                                        }
                                        if (!empty($restdays['weekends'])) {
                                            $weekends = explode(',', $restdays['weekends']);
                                        }
                                        if (!empty($restdays['breakfast'])) {
                                            $breakfast = explode(',', $restdays['breakfast']);
                                        }
                                        if (!empty($restdays['brunch'])) {
                                            $brunch = explode(',', $restdays['brunch']);
                                        }
                                        if (!empty($restdays['lunch'])) {
                                            $lunch = explode(',', $restdays['lunch']);
                                        }
                                        if (!empty($restdays['dinner'])) {
                                            $dinner = explode(',', $restdays['dinner']);
                                        }
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <select name="weekdays[]" class="chzn-select form-control select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                            <option value="">
                                               
                                                <?=lang('select_days')?>
                                            </option>
                                            <option value="1" <?php if (isset($weekdays) and !empty($weekdays) and in_array(1, $weekdays)) echo 'selected="selected"'; ?>>Sunday</option>
                                            <option value="2" <?php if (isset($weekdays) and !empty($weekdays) and in_array(2, $weekdays)) echo 'selected="selected"'; ?>>Monday</option>
                                            <option value="3" <?php if (isset($weekdays) and !empty($weekdays) and in_array(3, $weekdays)) echo 'selected="selected"'; ?>>Tuesday</option>
                                            <option value="4" <?php if (isset($weekdays) and !empty($weekdays) and in_array(4, $weekdays)) echo 'selected="selected"'; ?>>Wednesday</option>
                                            <option value="5" <?php if (isset($weekdays) and !empty($weekdays) and in_array(5, $weekdays)) echo 'selected="selected"'; ?>>Thursday</option>
                                            <option value="6" <?php if (isset($weekdays) and !empty($weekdays) and in_array(6, $weekdays)) echo 'selected="selected"'; ?>>Friday</option>
                                            <option value="7" <?php if (isset($weekdays) and !empty($weekdays) and in_array(7, $weekdays)) echo 'selected="selected"'; ?>>Saturday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-12 control-label" for="week_ends_start"><?=lang('week_ends')?></label>
                                    <div class="col-md-3">
                                        <select class="auto-width form-control select2" name="week_ends_start">
                                            <option value=""><?=lang('open_time')?></option>
                                            <?php
                                            for ($i = 0; $i <= 24; $i++) {
                                                if ($i <= 9) $i = "0" . $i;
                                                for ($j = 0; $j <= 1; $j++) {
                                                    if ($j == 0) $min = '00';
                                                    else $min = 30;
                                                    $tim = $i . ":" . $min;
                                                    if ($tim == "00:00") continue;
                                                    if ($tim != "24:30") {
                                                        if ($i >= 12 and $i != 24) $mer = " pm";
                                                        else $mer = " am";
                                                        $act_time = $tim;
                                                        if (isset($openHours['week_ends_start']) and $openHours['week_ends_start'] == $act_time) {
                                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                        } else {
                                                            echo "<option value='$act_time'>$act_time</option>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">

                                        <select class="auto-width form-control select2" name="week_ends_close">
                                            <option value=""><?=lang('colse_time')?></option>
                                            <?php
                                            for ($i = 0; $i <= 24; $i++) {
                                                if ($i <= 9) $i = "0" . $i;
                                                for ($j = 0; $j <= 1; $j++) {
                                                    if ($j == 0) $min = '00';
                                                    else $min = 30;
                                                    $tim = $i . ":" . $min;
                                                    if ($tim == "00:00") continue;
                                                    if ($tim != "24:30") {
                                                        if ($i >= 12 and $i != 24) $mer = " pm";
                                                        else $mer = " am";
                                                        $act_time = $tim;
                                                        if (isset($openHours['week_ends_close']) and $openHours['week_ends_close'] == $act_time) {
                                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                        } else {
                                                            echo "<option value='$act_time'>$act_time</option>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">

                                        <select name="weekends[]" class="chzn-select form-control select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                            <option value="">
                                                <?=lang('select_days')?>
                                            </option>
                                            <option value="1" <?php if (isset($weekends) and !empty($weekends) and in_array(1, $weekends)) echo 'selected="selected"'; ?>>Sunday</option>
                                            <option value="2" <?php if (isset($weekends) and !empty($weekends) and in_array(2, $weekends)) echo 'selected="selected"'; ?>>Monday</option>
                                            <option value="3" <?php if (isset($weekends) and !empty($weekends) and in_array(3, $weekends)) echo 'selected="selected"'; ?>>Tuesday</option>
                                            <option value="4" <?php if (isset($weekends) and !empty($weekends) and in_array(4, $weekends)) echo 'selected="selected"'; ?>>Wednesday</option>
                                            <option value="5" <?php if (isset($weekends) and !empty($weekends) and in_array(5, $weekends)) echo 'selected="selected"'; ?>>Thursday</option>
                                            <option value="6" <?php if (isset($weekends) and !empty($weekends) and in_array(6, $weekends)) echo 'selected="selected"'; ?>>Friday</option>
                                            <option value="7" <?php if (isset($weekends) and !empty($weekends) and in_array(7, $weekends)) echo 'selected="selected"'; ?>>Saturday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-12 control-label" for="breakfast"><?=lang('breakfast')?></label>
                            <div class="col-md-3">
                                <select class="auto-width form-control select2" name="breakfast_start">
                                    <option value=""><?=lang('open_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['breakfast_start']) and $openHours['breakfast_start'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time </option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <select class="auto-width form-control select2" name="breakfast_close">
                                    <option value=""><?=lang('colse_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['breakfast_close']) and $openHours['breakfast_close'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="col-md-6">
                                <select name="breakfast[]" class="chzn-select form-control select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                    <option value="">
                                        <?=lang('select_days')?>
                                    </option>
                                    <option value="0" <?php if (isset($breakfast) and !empty($breakfast) and in_array(0, $breakfast)) echo 'selected="selected"'; ?>>Every Day</option>
                                    <option value="1" <?php if (isset($breakfast) and !empty($breakfast) and in_array(1, $breakfast)) echo 'selected="selected"'; ?>>Sunday</option>
                                    <option value="2" <?php if (isset($breakfast) and !empty($breakfast) and in_array(2, $breakfast)) echo 'selected="selected"'; ?>>Monday</option>
                                    <option value="3" <?php if (isset($breakfast) and !empty($breakfast) and in_array(3, $breakfast)) echo 'selected="selected"'; ?>>Tuesday</option>
                                    <option value="4" <?php if (isset($breakfast) and !empty($breakfast) and in_array(4, $breakfast)) echo 'selected="selected"'; ?>>Wednesday</option>
                                    <option value="5" <?php if (isset($breakfast) and !empty($breakfast) and in_array(5, $breakfast)) echo 'selected="selected"'; ?>>Thursday</option>
                                    <option value="6" <?php if (isset($breakfast) and !empty($breakfast) and in_array(6, $breakfast)) echo 'selected="selected"'; ?>>Friday</option>
                                    <option value="7" <?php if (isset($breakfast) and !empty($breakfast) and in_array(7, $breakfast)) echo 'selected="selected"'; ?>>Saturday</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-12 control-label" for="brunch"><?=lang('brunch')?></label>
                            <div class="col-md-3">
                                <select class="auto-width form-control select2" name="brunch_start">
                                    <option value=""><?=lang('open_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['brunch_start']) and $openHours['brunch_start'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="auto-width form-control select2" name="brunch_close">
                                    <option value=""><?=lang('colse_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['brunch_close']) and $openHours['brunch_close'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="brunch[]" class="chzn-select form-control  select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                    <option value="">
                                        <?=lang('select_days')?>
                                    </option>
                                    <option value="0" <?php if (isset($breakfast) and !empty($brunch)  and in_array(0, $brunch)) echo 'selected="selected"'; ?>>Every Day</option>
                                    <option value="1" <?php if (isset($breakfast) and !empty($brunch)  and in_array(1, $brunch)) echo 'selected="selected"'; ?>>Sunday</option>
                                    <option value="2" <?php if (isset($breakfast) and !empty($brunch)  and in_array(2, $brunch)) echo 'selected="selected"'; ?>>Monday</option>
                                    <option value="3" <?php if (isset($breakfast) and !empty($brunch)  and in_array(3, $brunch)) echo 'selected="selected"'; ?>>Tuesday</option>
                                    <option value="4" <?php if (isset($breakfast) and !empty($brunch)  and in_array(4, $brunch)) echo 'selected="selected"'; ?>>Wednesday</option>
                                    <option value="5" <?php if (isset($breakfast) and !empty($brunch)  and in_array(5, $brunch)) echo 'selected="selected"'; ?>>Thursday</option>
                                    <option value="6" <?php if (isset($breakfast) and !empty($brunch)  and in_array(6, $brunch)) echo 'selected="selected"'; ?>>Friday</option>
                                    <option value="7" <?php if (isset($breakfast) and !empty($brunch)  and in_array(7, $brunch)) echo 'selected="selected"'; ?>>Saturday</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-md-12 control-label" for="lunch"><?=lang('lunch')?></label>
                            <div class="col-md-3">
                                <select class="auto-width form-control  select2" name="lunch_start">
                                    <option value=""><?=lang('open_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['lunch_start']) and $openHours['lunch_start'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="auto-width form-control  select2" name="lunch_close">
                                    <option value=""><?=lang('colse_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['lunch_close']) and $openHours['lunch_close'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="lunch[]" class="chzn-select form-control   select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                    <option value="">
                                        <?=lang('select_days')?>
                                    </option>
                                    <option value="0" <?php if (isset($lunch) and !empty($lunch) and in_array(0, $lunch)) echo 'selected="selected"'; ?>>Every Day</option>
                                    <option value="1" <?php if (isset($lunch) and !empty($lunch) and in_array(1, $lunch)) echo 'selected="selected"'; ?>>Sunday</option>
                                    <option value="2" <?php if (isset($lunch) and !empty($lunch) and in_array(2, $lunch)) echo 'selected="selected"'; ?>>Monday</option>
                                    <option value="3" <?php if (isset($lunch) and !empty($lunch) and in_array(3, $lunch)) echo 'selected="selected"'; ?>>Tuesday</option>
                                    <option value="4" <?php if (isset($lunch) and !empty($lunch) and in_array(4, $lunch)) echo 'selected="selected"'; ?>>Wednesday</option>
                                    <option value="5" <?php if (isset($lunch) and !empty($lunch) and in_array(5, $lunch)) echo 'selected="selected"'; ?>>Thursday</option>
                                    <option value="6" <?php if (isset($lunch) and !empty($lunch) and in_array(6, $lunch)) echo 'selected="selected"'; ?>>Friday</option>
                                    <option value="7" <?php if (isset($lunch) and !empty($lunch) and in_array(7, $lunch)) echo 'selected="selected"'; ?>>Saturday</option>
                                </select>

                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                        <div class="form-group row">
                            <label class="col-md-12 control-label" for="dinner"><?=lang('dinner')?></label>
                            <div class="col-md-3">
                                <select class="auto-width form-control  select2" name="dinner_start">
                                    <option value=""><?=lang('open_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['dinner_start']) and $openHours['dinner_start'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <div class="col-md-3">
                                <select class="auto-width form-control  select2" name="dinner_close">
                                    <option value=""><?=lang('colse_time')?></option>
                                    <?php
                                    for ($i = 0; $i <= 24; $i++) {
                                        if ($i <= 9) $i = "0" . $i;
                                        for ($j = 0; $j <= 1; $j++) {
                                            if ($j == 0) $min = '00';
                                            else $min = 30;
                                            $tim = $i . ":" . $min;
                                            if ($tim == "00:00") continue;
                                            if ($tim != "24:30") {
                                                if ($i >= 12 and $i != 24) $mer = " pm";
                                                else $mer = " am";
                                                $act_time = $tim;
                                                if (isset($openHours['dinner_close']) and $openHours['dinner_close'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="col-md-6">
                                <select name="dinner[]" class="chzn-select form-control  select2 sufrati-select" data-placeholder="<?=lang('select_days')?>" multiple style="width:350px;" tabindex="4">
                                    <option value="">
                                        <?=lang('select_days')?>
                                    </option>
                                    <option value="0" <?php if (isset($dinner) and !empty($dinner) and in_array(0, $dinner)) echo 'selected="selected"'; ?>>Every Day</option>
                                    <option value="1" <?php if (isset($dinner) and !empty($dinner) and in_array(1, $dinner)) echo 'selected="selected"'; ?>>Sunday</option>
                                    <option value="2" <?php if (isset($dinner) and !empty($dinner) and in_array(2, $dinner)) echo 'selected="selected"'; ?>>Monday</option>
                                    <option value="3" <?php if (isset($dinner) and !empty($dinner) and in_array(3, $dinner)) echo 'selected="selected"'; ?>>Tuesday</option>
                                    <option value="4" <?php if (isset($dinner) and !empty($dinner) and in_array(4, $dinner)) echo 'selected="selected"'; ?>>Wednesday</option>
                                    <option value="5" <?php if (isset($dinner) and !empty($dinner) and in_array(5, $dinner)) echo 'selected="selected"'; ?>>Thursday</option>
                                    <option value="6" <?php if (isset($dinner) and !empty($dinner) and in_array(6, $dinner)) echo 'selected="selected"'; ?>>Friday</option>
                                    <option value="7" <?php if (isset($dinner) and !empty($dinner) and in_array(7, $dinner)) echo 'selected="selected"'; ?>>Saturday</option>
                                </select>

                            </div>
                        </div>
                        </div>
                        </div>
                    </section>


                    <div class="form-group row my-4">
                        <div class="col-sm-12 text-end">
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                        else echo site_url(); ?>" class="btn btn-light" title="Cancel Changes"><?=lang('cancel')?></a>
                            <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-danger" />
                      
                        </div>
                        <?php
                        if (isset($rest)) {
                        ?>
                            <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </article>
    </div>
</section>

<script type="text/javascripts" src="<?php echo base_url(); ?>js/restform.js"></script>
<script>
    var allowed_chars = '<?php echo $allowed_chars; ?>';

    function countChar(val) {
        var len = val.value.length;
        if (len > allowed_chars) {
            $('#count-message').removeClass('hidden');
            val.value = val.value.substring(0, allowed_chars);
        } else {
            $('#count-message').addClass('hidden');
            $('#charNum').text(allowed_chars - len);
        }
    };

    function countCharAr(val) {
        var len = val.value.length;
        if (len > allowed_chars) {
            $('#count-message-ar').removeClass('hidden');
            val.value = val.value.substring(0, allowed_chars);
        } else {
            $('#count-message-ar').addClass('hidden');
            $('#charNumAr').text(allowed_chars - len);
        }
    };
</script>
<script>
    $(document).ready(function() {
        $(".select2").select2({dir:"rtl"});
        /*  $(".select2-tag").select2({
            tags: "true",
            allowClear: true,
            tokenSeparators: [','],
            multiple: true,
    maximumSelectionSize: 1,
    placeholder: "Start typing",
    data: [
           
          ]
        });*/

    });
    $('body').on('click', '.email-remove', function() {
        $(this).parent().parent().remove();
    });

    function addMoreEmail() {
        var html = '<div  class="mb-3 row">' +
            '<div class="col-sm-11">' +
            '<input type="email" class="form-control " name="rest_Email[]" placeholder="Contact Email" required />' +
            '</div>' +
            '<div class="col-sm-1 my-1 text-start">' +
            '<a class=" btn-sm btn-danger close email-remove" href="#">&times;</a>' +
            '</div>' +
            '</div>';
        $("#memberemails").append(html);

    }
</script>