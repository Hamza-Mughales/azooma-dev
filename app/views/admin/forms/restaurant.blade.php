@extends('admin.index')
@section('content')

<style>
    .help-block {
        font-size: 10px;
    }
</style>
<ol class="breadcrumb">
    <li><a href="<?= URL::route('adminhome'); ?>">Dashboard</a></li>
    <li><a href="<?= URL::route('adminrestaurants'); ?>">All Restaurants</a></li>
    <?php if (isset($cat)) { ?>
        <li><a href="<?= URL::route('adminarticles/articles/', $cat->id); ?>">{{ $cat->name; }}</a></li>
    <?php } ?>
    <li class="active">{{ $title }}</li>
</ol>




<?php
include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <form name="restMainForm" id="jqValidate" class="form-horizontal" role="form" action="{{ URL::route('adminrestaurants/save'); }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <legend>General Info</legend>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="openning_manner">Restaurant Status</label>
                <div class="col-md-8">
                    <select class="form-control" data-placeholder="Select Restaurant Status" name="openning_manner" id="openning_manner">
                        <?php
                        $RestaurantStatus = Config::get('commondata.RestaurantStatus');
                        if (is_array($RestaurantStatus)) {
                            foreach ($RestaurantStatus as $key => $value) {
                                $selected = "";
                                if (isset($rest) && $rest->openning_manner == $key) {
                                    $selected = 'selected';
                                }
                        ?>
                                <option value="{{ $key }}" {{ $selected }}>
                                    {{ $value }}
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="restbusiness_type">Restaurant Type</label>
                <div class="col-md-8">
                    <select name="restbusiness_type" id="restbusiness_type" onchange="selectgroup();" class="form-control required">
                        <?php
                        $RestaurantTypes = Config::get('commondata.RestaurantTypes');
                        if (is_array($RestaurantTypes)) {
                            foreach ($RestaurantTypes as $key => $value) {
                                $selected = "";
                                if (isset($rest) && $rest->restbusiness_type == $key) {
                                    $selected = 'selected';
                                }
                        ?>
                                <option value="{{ $key }}" {{ $selected }}>
                                    {{ $value }}
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <select name="group_value" id="group_value" <?php
                                                                if (!isset($rest) || ($rest->restbusiness_type != "2")) {
                                                                    echo 'class=" form-control hidden"';
                                                                } else {
                                                                    echo 'class=" form-control"';
                                                                }
                                                                ?> style="margin-top:10px;">
                        <?php
                        if (count($grouprests) > 0) {
                            $grouprest_list = "";
                            foreach ($grouprests as $group) {
                                if (isset($rest)) {
                                    $rest_id = $rest->rest_ID;
                                    //$query2 = "SELECT * FROM rest_group WHERE rest_ID=$rest_id AND group_id=" . $group->id;
                                    $rest_q = DB::table('rest_group')->where('rest_ID', '=', $rest_id)->where('group_id', '=', $group->id)->first();
                                    if (count($rest_q) > 0) {
                                        $group_rest = $rest_q;
                                        if ($group_rest->rest_ID == $rest_id) {
                                            $grouprest_list .= "<option value='" . $group->id . "' selected='selected'> " . $group->name . "</option>";
                                        }
                                    } else {
                                        $grouprest_list .= "<option value='" . $group->id . "'>" . $group->name . "</option>";
                                    }
                                } else {
                                    $grouprest_list .= "<option value='" . $group->id . "'>" . $group->name . "</option>";
                                }
                            }
                            echo $grouprest_list;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Name">Restaurant Name</label>
                <div class="col-md-8">
                    <input class="form-control required" type="text" name="rest_Name" id="rest_Name" placeholder="Restaurant Name" <?php echo isset($rest) ? 'value="' . stripslashes($rest->rest_Name) . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Name_Ar">Arabic Name</label>
                <div class="col-md-8">
                    <input class="form-control required" type="text" name="rest_Name_Ar" id="rest_Name_Ar" placeholder="Restaurant Name Arabic" dir="rtl" <?php echo isset($rest) ? 'value="' . stripslashes($rest->rest_Name_Ar) . '"' : ""; ?> />
                </div>
            </div>
            <?php
            if (isset($rest)) {
            ?>
                <div class="form-group col-md-6 row">
               
                    <label class="col-md-4 control-label" for="is_change">is URL change?</label>
                    <div class="col-md-8">
 
                    <div class="form-check1">
                        <input class="form-check-input1" id="is_change" type="checkbox" name="is_change" value="1" />

                    </div>
                </div>
                </div>
            <?php
            }
            ?>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="opening">Year of Opening</label>
                <div class="col-md-8">
                    <select name="opening" id="openning" class="form-control ">
                        <?php
                        for ($i = date('Y') + 1; $i > 1950; $i--)
                            echo "<option value='$i'>$i</option>";
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_style">Restaurant Style</label>
                <div class="col-md-8">
                    <select class="form-control" name="rest_style" id="rest_style">
                        <option value=""> Select Restaurant Style</option>
                        <?php
                        if (count($reststyle) > 0) {
                            foreach ($reststyle as $style) {
                        ?>
                                <option value="<?php echo $style->id; ?>" <?php
                                                                            if (isset($rest)) {
                                                                                echo $rest->rest_style == $style->id ? 'selected="selected"' : "";
                                                                            }
                                                                            ?>>
                                    <?php echo stripslashes($style->name) . ' - ' . stripslashes($style->nameAr); ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php if (count($resttype) > 0) { ?>
                <div class="form-group col-md-6 row">
                    <label class="col-md-4 control-label" for="rest_type">Business Type</label>
                    <div class="col-md-8">
                        <select multiple class=" required form-control" name="rest_type[]" id="rest_type" data-placeholder="Select Business Type">

                            <?php
                            $restTypeArr = array();
                            if (isset($rest)) {
                                $restTypeArr = explode(",", $rest->rest_type);
                            }
                            foreach ($resttype as $type) {
                            ?>
                                <option value="<?php echo $type->id; ?>" <?php
                                                                            if (in_array($type->id, $restTypeArr)) {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?>>
                                    <?php echo stripslashes($type->name) . ' - ' . stripslashes($type->nameAr); ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

            <?php } ?>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="class_category">Dining Services</label>
                <div class="col-md-8">
                    <select class="form-control required" name="class_category" id="class_category">
                        <?php
                        $DiningServices = Config::get('commondata.DiningServices');
                        if (is_array($DiningServices)) {
                            foreach ($DiningServices as $key => $value) {
                                $selected = "";
                                if (isset($rest) && $rest->class_category == $key) {
                                    $selected = 'selected';
                                }
                        ?>
                                <option value="{{ $key }}" {{ $selected }}>
                                    {{ $value }}
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="price_range">Price Range</label>
                <div class="col-md-8">
                    <select class="form-control required" name="price_range" id="price_range">
                        <?php
                        $PriceRange = Config::get('commondata.PriceRange');
                        if (is_array($PriceRange)) {
                            foreach ($PriceRange as $key => $value) {
                                $selected = "";
                                if (isset($rest) && $rest->price_range == $key) {
                                    $selected = 'selected';
                                }
                        ?>
                                <option value="{{ $key }}" {{ $selected }}>
                                    {{ $value }}
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?php
            $mastercuisineList = array();
            $cuisineList = array();
            if (isset($rest)) {
                $bestList = array();
                if (is_array($restcuisines)) {
                    foreach ($restcuisines as $val) {
                        $cuisineList[] = $val->cuisine_ID;
                        if (!in_array($val->master_id, $mastercuisineList)) {
                            $mastercuisineList[] = $val->master_id;
                        }
                    }
                }
                if (is_array($restbestfors)) {
                    foreach ($restbestfors as $val) {
                        $bestList[] = $val->bestfor_ID;
                    }
                }
            }

            $maxcuisine = 6;
            $maxbest = 1;
            $msgcuisine = "Maximum 2 Cuisines can be selected";
            $msgbest = "Maximum 1 Known for can be selected";
            if (isset($rest)) {
                switch ($rest->rest_Subscription) {
                    case 1:
                        $maxcuisine = 6;
                        $maxbest = 1;
                        $msgcuisine = "Maximum 3 Cuisines can be selected";
                        $msgbest = "Maximum 1 Known for can be selected";
                        break;
                    case 2:
                        $maxcuisine = 6;
                        $maxbest = 2;
                        $msgcuisine = "Maximum 4 Cuisines can be selected";
                        $msgbest = "Maximum 2 Known for can be selected";
                        break;
                    case 3:
                        $maxcuisine = 6;
                        $maxbest = 4;
                        $msgcuisine = "Maximum 6 Cuisines can be selected";
                        $msgbest = "Maximum 4 Known for can be selected";
                        break;
                }
            }
            ?>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="mastercuisine">Main Cuisine</label>
                <div class="col-md-8">
                    <select data-maxpersons="3" data-ajax="1" multiple class="form-control  required" data-placeholder="Select Master Cuisines" name="mastercuisine[]" id="mastercuisine">
                        <?php
                        if (isset($rest)) {
                            foreach ($mastercuisines as $mastercuisine) {
                        ?>
                                <option value="<?php echo $mastercuisine->id; ?>" <?php if (in_array($mastercuisine->id, $mastercuisineList)) echo 'selected="selected"'; ?>>
                                    <?php echo stripslashes($mastercuisine->name); ?>
                                </option>
                                <?php
                            }
                        } else {
                            if (count($mastercuisines) > 0) {
                                foreach ($mastercuisines as $mastercuisine) {
                                ?>
                                    <option value="<?php echo $mastercuisine->id; ?>" <?php if (in_array($mastercuisine->id, $mastercuisineList)) echo 'selected="selected"'; ?>>
                                        <?php echo stripslashes($mastercuisine->name); ?>
                                    </option>
                        <?php
                                }
                            }
                        }
                        ?>
                        <option value="-1" <?php if (in_array(0, $mastercuisineList)) echo 'selected="selected"'; ?>>Other Categories</option>
                    </select>
                </div>
            </div>
            <?php
            if (count($mastercuisines) > 0) {
                // dd($mastercuisines);
                foreach ($mastercuisines as $mastercuisine) {
                    $class_hidden = "hidden";
                    if (in_array($mastercuisine->id, $mastercuisineList)) {
                        $class_hidden = "";
                    }
            ?>
                    <div class="form-group col-md-6 row subcuisine-list <?php echo $class_hidden; ?>" id="cuisine-list-<?php echo $mastercuisine->id; ?>">
                        <label class="col-md-4 control-label" for="cuisine">Food/Cuisine for <?php echo $mastercuisine->name; ?> Cuisines</label>
                        <div class="col-md-8">
                            <select multiple class="form-control   subcuisine" data-maxpersons="<?php echo $maxcuisine; ?>" tabindex="7" data-placeholder="Select Cuisines" name="cuisine[]" id="cuisine-<?php echo $mastercuisine->id; ?>">
                                <?php
                                if (isset($rest)) {
                                    foreach ($cuisines as $cuisine) {
                                        if ($cuisine->master_id != $mastercuisine->id) {
                                            continue;
                                        }
                                ?>
                                        <option value="<?php echo $cuisine->cuisine_ID; ?>" <?php if (in_array($cuisine->cuisine_ID, $cuisineList)) echo 'selected="selected"'; ?> master="<?php echo $cuisine->master_id; ?>">
                                            <?php echo stripslashes($cuisine->cuisine_Name); ?>
                                        </option>
                                    <?php
                                    }
                                } else {
                                    foreach ($cuisines as $cuisine) {
                                        if ($cuisine->master_id != $mastercuisine->id) {
                                            continue;
                                        }
                                    ?>
                                        <option value="<?php echo $cuisine->cuisine_ID; ?>">
                                            <?php echo stripslashes($cuisine->cuisine_Name); ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                            <p class="help-block"><?php echo $msgcuisine; ?></p>
                        </div>
                    </div>
            <?php
                }
            }
            $class_hidden = "hidden";
            if (in_array(0, $mastercuisineList)) {
                $class_hidden = "";
            }
            ?>
            <div class="form-group col-md-6 row subcuisine-list <?php echo $class_hidden; ?>" id="cuisine-list--1">
                <label class="col-md-4 control-label" for="cuisine">Food / Dishes</label>
                <div class="col-md-8">
                    <select multiple class="form-control  required subcuisine" data-maxpersons="<?php echo $maxcuisine; ?>" tabindex="7" data-placeholder="Select Cuisines" name="cuisine[]" id="cuisine--1">
                        <?php
                        if (isset($rest)) {
                            foreach ($cuisines as $cuisine) {
                                if ($cuisine->master_id > 0) {
                                    continue;
                                }
                        ?>
                                <option value="<?php echo $cuisine->cuisine_ID; ?>" <?php if (in_array($cuisine->cuisine_ID, $cuisineList)) echo 'selected="selected"'; ?>>
                                    <?php echo stripslashes($cuisine->cuisine_Name); ?>
                                </option>
                            <?php
                            }
                        } else {
                            foreach ($cuisines as $cuisine) {
                                if ($cuisine->master_id > 0) {
                                    continue;
                                }
                            ?>
                                <option value="<?php echo $cuisine->cuisine_ID; ?>" master="<?php echo $cuisine->master_id; ?>">
                                    <?php echo stripslashes($cuisine->cuisine_Name); ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>

                    <p class="help-block"><?php echo $msgcuisine; ?></p>
                </div>
            </div>


            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="bestfor">Known For</label>
                <div class="col-md-8">
                    <select multiple class="form-control " data-maxpersons="<?php echo $maxbest; ?>" tabindex="7" data-placeholder="Select Known for" name="bestfor[]" id="bestfor">
                        <?php
                        if (isset($rest)) {
                            foreach ($bestfor as $best) {
                        ?>
                                <option value="<?php echo $best->bestfor_ID; ?>" <?php if (in_array($best->bestfor_ID, $bestList)) echo 'selected="selected"'; ?>>
                                    <?php echo stripslashes($best->bestfor_Name); ?>
                                </option>
                                <?php
                            }
                        } else {
                            if (count($bestfor) > 0) {
                                foreach ($bestfor as $best) {
                                ?>
                                    <option value="<?php echo $best->bestfor_ID; ?>">
                                        <?php echo stripslashes($best->bestfor_Name); ?>
                                    </option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <p class="help-block"><?php echo $msgbest; ?></p>
                </div>
            </div>

            <br />
            <legend>Business / Restaurant Contact Info</legend>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Telephone">Reserve Phone</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_Telephone" id="rest_Telephone" placeholder="Restaurant Reservation Phone" <?php echo isset($rest) ? 'value="' . $rest->rest_Telephone . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Mobile">Delivery Number</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_Mobile" id="rest_Mobile" placeholder="Delivery Number" <?php echo isset($rest) ? 'value="' . $rest->rest_Mobile . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_TollFree">Free Number</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_TollFree" id="rest_TollFree" placeholder="Toll Free Number" <?php echo isset($rest) ? 'value="' . $rest->rest_TollFree . '"' : ""; ?> />
                </div>
            </div>


            <br />
            <legend>Address</legend>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Email">Restaurant Email</label>
                <div class="col-md-8" id="memberemails">
                    <?php
                    if (isset($rest)) {
                        $rest_Emails = explode(',', $rest->rest_Email);
                        $count_members_details = count($rest_Emails);
                        echo "<script type='text/javascript'> var counter='" . $count_members_details . "' </script> ";
                        for ($i = 0; $i < count($rest_Emails); $i++) {
                    ?>
                            <div id="input-<?php echo $i; ?>" class="input-<?php echo $i; ?>">
                                <input class="form-control" type="text" name="rest_Email[]" placeholder="Contact Email" <?php echo isset($rest_Emails) ? 'value="' . $rest_Emails[$i] . '"' : ""; ?> />
                                <a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                            </div>
                        <?php
                        }
                    } else {
                        echo "<script type='text/javascript'> var counter='1' </script> ";
                        ?>
                        <div id="input-0">
                            <input class="form-control" type="text" name="rest_Email[]" placeholder="Contact Email" />
                        </div>
                    <?php } ?>
                </div>
            </div>

            {{-- <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-8">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="addmore();"><i class="icon-plus-sign icon-white"></i> Add another email</a>
                </div>
            </div> --}}
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_WebSite"> Website</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_WebSite" id="rest_WebSite" placeholder="Restaurant Website" <?php echo isset($rest) ? 'value="' . $rest->rest_WebSite . '"' : ""; ?> />
                </div>
            </div>

            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="facebook_fan"> Facebook URL</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="facebook_fan" id="facebook_fan" placeholder="Facebook Page" <?php echo isset($rest) ? 'value="' . $rest->facebook_fan . '"' : ""; ?> />
                </div>
            </div>

            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_pbox">P.O: Box</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_pbox" id="rest_pbox" placeholder="P.O.Box" <?php echo isset($rest) ? 'value="' . $rest->rest_pbox . '"' : ""; ?> />
                </div>
            </div>

            <br />
            <legend>
                Open Hours &amp; Days
            </legend>
            <div class="form-group row">
                <label class="col-md-2 control-label text" for="week_days_start">Serving</label>
                <div class="col-md-6 input-spacer">
                    <input type="checkbox" <?php if (isset($rest->breakfast) and $rest->breakfast == 1) echo 'checked="checked"'; ?> name="breakfast" value="1" /> Breakfast &nbsp;
                    <input type="checkbox" <?php if (isset($rest->brunch) and $rest->brunch == 1) echo 'checked="checked"'; ?> name="brunch" value="1" /> Brunch
                    <input type="checkbox" <?php if (isset($rest->lunch) and $rest->lunch == 1) echo 'checked="checked"'; ?> name="lunch" value="1" /> Lunch
                    <input type="checkbox" <?php if (isset($rest->dinner) and $rest->dinner == 1) echo 'checked="checked"'; ?> name="dinner" value="1" /> Dinner
                    <input type="checkbox" <?php if (isset($rest->latenight) and $rest->latenight == 1) echo 'checked="checked"'; ?> name="latenight" value="1" /> Late Night &nbsp;
                    <input type="checkbox" <?php if (isset($rest->iftar) and $rest->iftar == 1) echo 'checked="checked"'; ?> name="iftar" value="1" /> Iftar &nbsp; &nbsp;
                    <input type="checkbox" <?php if (isset($rest->suhur) and $rest->suhur == 1) echo 'checked="checked"'; ?> name="suhur" value="1" /> Suhur
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="week_days_start">Week Days</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control  " name="week_days_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->week_days_start) and $openHours->week_days_start == $act_time) {
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
                            <select class="form-control " name="week_days_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->week_days_close) and $openHours->week_days_close == $act_time) {
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
                            $weekdays = $weekends = $brunch = $breakfast = $lunch = $dinner = "";
                            if (!empty($restdays->weekdays)) {
                                $weekdays = explode(',', $restdays->weekdays);
                            }
                            if (!empty($restdays->weekends)) {
                                $weekends = explode(',', $restdays->weekends);
                            }
                            if (!empty($restdays->breakfast)) {
                                $breakfast = explode(',', $restdays->breakfast);
                            }
                            if (!empty($restdays->brunch)) {
                                $brunch = explode(',', $restdays->brunch);
                            }
                            if (!empty($restdays->lunch)) {
                                $lunch = explode(',', $restdays->lunch);
                            }
                            if (!empty($restdays->dinner)) {
                                $dinner = explode(',', $restdays->dinner);
                            }
                        }
                        ?>
                        <div class="col-md-6">
                            <select name="weekdays[]" class="form-control  sufrati-select " data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
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
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="week_ends_start">Week Ends</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="week_ends_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->week_ends_start) and $openHours->week_ends_start == $act_time) {
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
                            <select class="form-control auto-width" name="week_ends_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->week_ends_close) and $openHours->week_ends_close == $act_time) {
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
                            <select name="weekends[]" class="form-control  sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
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

            <div class="form-group row">
                <label class="col-md-2 control-label" for="breakfast">Breakfast</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">

                            <select class="form-control auto-width" name="breakfast_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->breakfast_start) and $openHours->breakfast_start == $act_time) {
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
                            <select class="form-control auto-width" name="breakfast_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->breakfast_close) and $openHours->breakfast_close == $act_time) {
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
                            <select name="breakfast[]" class="form-control  sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
                                </option>
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
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="brunch">Brunch</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="brunch_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->brunch_start) and $openHours->brunch_start == $act_time) {
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
                            <select class="form-control auto-width" name="brunch_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->brunch_close) and $openHours->brunch_close == $act_time) {
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
                            <select name="brunch[]" class="form-control  sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
                                </option>
                                <option value="1" <?php if (isset($brunch) and !empty($brunch) and in_array(1, $brunch)) echo 'selected="selected"'; ?>>Sunday</option>
                                <option value="2" <?php if (isset($brunch) and !empty($brunch) and in_array(2, $brunch)) echo 'selected="selected"'; ?>>Monday</option>
                                <option value="3" <?php if (isset($brunch) and !empty($brunch) and in_array(3, $brunch)) echo 'selected="selected"'; ?>>Tuesday</option>
                                <option value="4" <?php if (isset($brunch) and !empty($brunch) and in_array(4, $brunch)) echo 'selected="selected"'; ?>>Wednesday</option>
                                <option value="5" <?php if (isset($brunch) and !empty($brunch) and in_array(5, $brunch)) echo 'selected="selected"'; ?>>Thursday</option>
                                <option value="6" <?php if (isset($brunch) and !empty($brunch) and in_array(6, $brunch)) echo 'selected="selected"'; ?>>Friday</option>
                                <option value="7" <?php if (isset($brunch) and !empty($brunch) and in_array(7, $brunch)) echo 'selected="selected"'; ?>>Saturday</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="lunch">Lunch</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="lunch_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->lunch_start) and $openHours->lunch_start == $act_time) {
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
                            <select class="form-control auto-width" name="lunch_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->lunch_close) and $openHours->lunch_close == $act_time) {
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
                            <select name="lunch[]" class="form-control  sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
                                </option>
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
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="dinner">Dinner</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="dinner_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->dinner_start) and $openHours->dinner_start == $act_time) {
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
                            <select class="form-control auto-width" name="dinner_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->dinner_close) and $openHours->dinner_close == $act_time) {
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
                            <select name="dinner[]" class="form-control  sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                                <option value="">
                                    Select Days
                                </option>
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

            <div class="form-group row">
                <label class="col-md-2 control-label" for="iftar">Iftar</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="iftar_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->iftar_start) and $openHours->iftar_start == $act_time) {
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
                            <select class="form-control auto-width" name="iftar_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->iftar_close) and $openHours->iftar_close == $act_time) {
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
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 control-label" for="suhur_start">Suhur</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control auto-width" name="suhur_start">
                                <option value="">Opening Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->suhur_start) and $openHours->suhur_start == $act_time) {
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
                            <select class="form-control auto-width" name="suhur_close">
                                <option value="">Closing Time</option>
                                <?php
                                for ($i = 0; $i <= 24; $i++) {
                                    if ($i <= 9)
                                        $i = "0" . $i;
                                    for ($j = 0; $j <= 1; $j++) {
                                        if ($j == 0)
                                            $min = '00';
                                        else
                                            $min = 30;
                                        $tim = $i . ":" . $min;
                                        if ($tim == "00:00")
                                            continue;
                                        if ($tim != "24:30") {
                                            if ($i >= 12 and $i != 24)
                                                $mer = " pm";
                                            else
                                                $mer = " am";
                                            $act_time = $tim;
                                            if (isset($openHours->suhur_close) and $openHours->suhur_close == $act_time) {
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
                    </div>
                </div>
            </div>

            <legend>About the Restaurant</legend>
            <div class="form-group col-md-8 row">
                <label class="col-md-3 control-label" for="rest_Logo">Logo</label>
                <div class="col-md-8">
                    <input type="file" name="rest_Logo" id="rest_Logo" />
                    <?php
                    if (isset($rest) && ($rest->rest_Logo != "")) {
                    ?>
                        <img width="100" src="<?php echo Config::get('settings.uploadurl'); ?>/logos/<?php echo $rest->rest_Logo; ?>" />
                        <input type="hidden" name="rest_Logo_old" value="<?php echo $rest->rest_Logo; ?>" />
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group col-md-8 row">
                <label class="col-md-3 control-label" for="rest_tags">Restaruant Tags</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_tags" id="rest_tags" placeholder="Restaruant Tags" <?php echo isset($rest) ? 'value="' . stripslashes(htmlspecialchars($rest->rest_tags)) . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-8 row">
                <label class="col-md-3 control-label" for="rest_tags_ar">Arabic Tags</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="rest_tags_ar" id="rest_tags_ar" placeholder="Restaruant Tags Arabic" <?php echo isset($rest) ? 'value="' . stripslashes(htmlspecialchars($rest->rest_tags_ar)) . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-8 row">
                <label class="col-md-3 control-label" for="rest_Description">
                    Description
                </label>
                <div class="col-md-8">
                    <textarea class="form-control" name="rest_Description" id="restDescription" rows="5" placeholder="Restaurant Description"><?php if (isset($rest) && ($rest->rest_Description != "")) echo stripcslashes(html_entity_decode(str_replace('<br>', '\n', $rest->rest_Description))); ?></textarea>
                    <span class="small-font">200 characters allowed</span>
                </div>
            </div>
            <div class="form-group col-md-8 row">
                <label class="col-md-3 control-label" for="rest_Description_Ar">
                    Arabic Description
                </label>
                <div class="col-md-8">
                    <textarea class="form-control" name="rest_Description_Ar" id="rest_Description_Ar" rows="5" dir="rtl" placeholder="Restaurant Description Arabic"><?php if (isset($rest) && ($rest->rest_Description != "")) echo stripcslashes(preg_replace("(\r\n|\n|\r)", "<br />", $rest->rest_Description_Ar)); ?></textarea>
                    <span class="small-font">200 characters allowed</span>
                </div>
            </div>


            <legend>Contact person Info</legend>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="your_Name">Name</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="your_Name" id="your_Name" placeholder="Contact Person" <?php echo isset($rest) ? 'value="' . $rest->your_Name . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="your_Email">Email</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="your_Email" id="your_Email" placeholder="Contact Email" value="<?php
                                                                                                                                    if (isset($rest)) {
                                                                                                                                        if (!empty($rest->your_Email)) {
                                                                                                                                            echo $rest->your_Email;
                                                                                                                                        } else {
                                                                                                                                            echo $rest->rest_Email;
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    ?>" />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="your_Contact">Contact Number</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="your_Contact" id="your_Contact" placeholder="Contact Number" <?php echo isset($rest) ? 'value="' . $rest->your_Contact . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="head_office">Office Number</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="head_office" id="head_office" placeholder="Head office Number" <?php echo isset($rest) ? 'value="' . $rest->head_office . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="your_Position">Person's Position</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" name="your_Position" id="your_Position" placeholder="Persons Position" <?php echo isset($rest) ? 'value="' . $rest->your_Position . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group col-md-6 row">
                <label class="col-md-4 control-label" for="rest_Status">Publish</label>
                <div class="col-md-8">
                    <input type="checkbox" <?php if (isset($rest->rest_Status) and $rest->rest_Status == 1) echo 'checked="checked"'; ?> name="rest_Status" value="1" />
                    <?php
                    if (isset($rest)) {
                    ?>
                        <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>" />
                    <?php
                    }
                    ?>

                </div>
            </div>

            <div class=" form-group col-md-6 row">
                <div class="col-md-6 offset-md-4 ">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($rest)) {
                    ?>
                        <input type="hidden" name="rest_ID" value="{{ isset($rest) ? $rest->rest_ID : 0 }}" id="rest_ID">
                        <input type="hidden" name="oldname" value="<?php echo (($rest->rest_Name)); ?>" />

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
// 
?>
<script type="text/javascript">
    $(document).ready(function(){

        // jQuery Validator - Validation Settings for AddNav form
        $("#restMainForm").validate({
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });
</script>
<script>
    function enableCuisine(master_id) {
        $('#cuisine-list-' + master_id).removeClass('hidden');
    }

    function disableCuisine(master_id) {
        $('#cuisine-list-' + master_id).addClass('hidden');
    }


    function addmore() {
        var element = '<div id="input-' + counter + '" class="input-' + counter + '" ><input type="text" name="rest_Email[]"  placeholder="Contact Email" class="form-control"  /><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-' + counter + '">&times;</a></div>';
        $("#memberemails").append(element);
        counter++;
    }

    $(document).on("click", ".sufrati-close", function(event) {
        var dismiss = $(this).attr('data-dismiss');
        $(this).parent().remove();
    });

    function selectgroup() {
        var type = $("#restbusiness_type").val();
        if (type == "2") {
            $("#group_value").removeClass('invisible');
        } else {
            $("#group_value").addClass('invisible');
        }
    }
</script>

@endsection