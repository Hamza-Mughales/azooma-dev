<style>
    .invisible {
        display: none;
    }
    .form-check-input[type="checkbox"] {
    border-radius: .25em;
    margin-right: 5px;
    margin-left: 5px;
}
.checkbox-content,.check-title{font-size: 16px;}
</style>
<link rel="stylesheet" type="text/css" href="<?=base_url(css_path())?>mapsjs-ui.css">
<div class="p-2">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span> </li>
        <li class="breadcrumb-item"> <a href="<?php echo base_url('branches'); ?>"><?= lang('branches_locations') ?></a> <span class="divider">/</span> </li>
        <li class="active"><?php echo $title; ?> </li>
    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>

<section class="card">
    <div class="card-body">
        <div class="text-end">
            <h5 class="pull-start h5"> <?=lang('update_branch_title')?> </h5>
            <?php if (isset($branch)) { ?>
                <a class="btn btn-sm btn-primary" href="<?= base_url('branches/photofrom') ?>" title="<?=lang('add_branch_photo')?>"><?=lang('add_branch_photo')?></a>
            <?php } ?>
        </div>
       

        
            <?php
            if ((isset($branch)) && ($branch['br_number'] != "")) {
                list($cityCode, $phone) = explode('-', $branch['br_number']);
            }
            $cityoptions = $citycodes = $cityCode = "";
            foreach ($cities as $city) {
                $cityoptions .= '<option value="' . $city['city_ID'] . '"';
                $citycodes .= '<option data-city="' . $city['city_ID'] . '" value="' . $city['city_Code'] . '"';
                if (isset($branch)) {
                    if ($branch['city_ID'] == $city['city_ID']) {
                        $cityoptions .= ' selected="selected"';
                    }
                }
                if ((isset($branch)) && ($cityCode != "") && ($cityCode == $city['city_Code'])) {
                    $citycodes .= ' selected="selected"';
                }
                $cityoptions .= '>' . ($city['city_Name']) . '</option>';
                $citycodes .= '>' . $city['city_Code'] . '</option>';
            }
            ?>
<div class="clearfix"></div>

            <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('branches/save'); ?>">
<div class="row">
<div class="col-md-12">
                        <div class="h6 my-3"><?=lang('branch_loc_info')?></div>
                    </div>
    <div class="col-md-6">
                <div class="form-group row">
                  
                    <label class="col-md-12 control-label" for="city_ID"><?=lang('select_city')?></label>
                    <div class="col-md-12">
                        <select class="form-control" name="city_ID" id="city_ID" onchange="selectcity();" required>
                            <option value=""> <?=lang('select_city')?></option>
                            <?php echo $cityoptions; ?>
                        </select>
                    </div>
                </div>
                </div>
                <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-md-12 control-label" for="city_ID"><?=lang('select_district')?></label>
                    <div class="col-md-12">
                        <?php
                        $i = 0;
                        foreach ($cities as $city) {
                            $i++;
                            $districts = $this->MGeneral->getCityDistricts($city['city_ID']);
                            if (count($districts) > 0) {
                        ?>
                                <select <?php if ((!isset($branch)) || ($branch['latitude'] == "")) { ?> onchange="getDistrictMap('district_<?php echo $city['city_ID']; ?>');" <?php } ?> name="district_<?php echo $city['city_ID']; ?>" id="district_<?php echo $city['city_ID']; ?>" class="form-control m-0 district <?php
                                                                                                                                                                                                                                                                                                                            if (isset($branch)) {
                                                                                                                                                                                                                                                                                                                                if ($branch['city_ID'] != $city['city_ID'])
                                                                                                                                                                                                                                                                                                                                    echo 'invisible';
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                if ($i != 1)
                                                                                                                                                                                                                                                                                                                                    echo 'invisible';
                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                            ?>">
                                    <?php
                                    foreach ($districts as $district) {
                                    ?>
                                        <option <?php
                                                if (isset($branch)) {
                                                    echo $branch['district_ID'] == $district['district_ID'] ? 'selected="selected"' : "";
                                                }
                                                ?> value="<?php echo $district['district_ID']; ?>"> <?php echo ($district['district_Name']); ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                </div>
                <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-md-12 control-label" for="br_loc"><?=lang('branch_location')?></label>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="br_loc" id="br_loc" placeholder="<?=lang('branch_location')?>" <?php echo isset($branch) ? 'value="' . ($branch['br_loc']) . '"' : ''; ?> required />
                    </div>
                </div>
                </div>
                <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-md-12 control-label" for="br_loc_ar"><?=lang('branch_location_ar')?></label>
                    <div class="col-md-12">
                        <input class="form-control" type="text" name="br_loc_ar" id="br_loc_ar" placeholder="<?=lang('branch_location_ar')?>" <?php echo isset($branch) ? 'value="' . ($branch['br_loc_ar']) . '"' : ''; ?> required />
                    </div>
                </div>
                </div>
                <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-md-12 control-label" for="cityCode"><?=lang('branch_tel_no')?></label>
                    <div class="col-3">
                        <select class="form-control" name="cityCode" id="cityCode">
                            <?php echo $citycodes; ?>
                        </select>
                    </div>
                    <div class="col-9">
                        <input class="form-control" name="br_number" id="br_number" <?php if ((isset($branch)) && ($branch['br_number'] != "") && ($phone != "")) echo 'value="' . trim($phone) . '"'; ?> placeholder="<?=lang('branch_phone_no')?>" />

                    </div>
                </div>
                </div>
                <div class="col-md-6">

                <div class="form-group row">
                    <label class="col-md-12 control-label" for="br_mobile"><?=lang('branch_mobile')?></label>
                    <div class="col-md-12">
                        <input class="form-control" name="br_mobile" id="br_mobile" <?php if ((isset($branch)) && ($branch['br_mobile'] != "")) echo 'value="' . $branch['br_mobile'] . '"'; ?> placeholder="<?=lang('branch_mobile')?>" />
                    </div>
                </div>
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="br_mobile"><?=lang('map')?> <a href="javascript:void(0)" onClick="showMarker()" id="addMap" title="Click to Add Google Map Location for your Branch" style="display:none;"> <b> Click to Add Map Location</b> </a> <a href="javascript:void(0)" onClick="hideMarker()" id="removeMap" title="Click to Remove Google Map"> <b></b> </a> </label>
                    <div class="col-md-12">
                       
                        <input type="hidden" name="latitude" id="latitude" value="<?php
                                                                                    if (isset($branch)) {
                                                                                        echo $branch['latitude'];
                                                                                    }
                                                                                    ?>" />
                        <input type="hidden" name="longitude" id="longitude" value="<?php
                                                                                    if (isset($branch)) {
                                                                                        echo $branch['longitude'];
                                                                                    }
                                                                                    ?>" />
                        <input type="hidden" name="zoom" id="zoom" value="14" />
             
                        <div id="map" style="width: 100%; height: 350px"></div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="branch_type"><?=lang('branchtype')?></label>
                    <div class="col-md-12">
                        <select class="form-control" name="branch_type" id="branch_type" onchange="selecthotel();">
                            <option value=""><?=lang('branchtype')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Classic Restaurant" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Classic Restaurant"><?=lang('classic_restaurant')?> </option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Hotel Restaurant" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Hotel Restaurant"><?=lang('hotel_restaurant')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Food Court" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Food Court"><?=lang('food_court')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Home Made" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Home Made"><?=lang('home_made')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Delivery Service" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Delivery Service"><?=lang('delivery_service')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Catering Service" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Catering Service"><?=lang('catering_service')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Quick Service" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Quick Service"><?=lang('quick_service')?></option>
                            <option <?php
                                    if (isset($branch)) {
                                        echo $branch['branch_type'] == "Stall" ? 'selected="selected"' : "";
                                    }
                                    ?> value="Stall"><?=lang('stall')?></option>
                        </select>
                        <div class="col-md-12 mt-3">
                        <select name='hotel_value' id='hotel_value' <?php if (!isset($branch) || ($branch['branch_type'] != "Hotel Restaurant")) echo 'class="form-control"'; ?>>
                            <?php
                            if (count($hotels) > 0) {
                                $hotel_list = "";
                                foreach ($hotels as $hotel) {
                                    if (isset($branch)) {
                                        $hotel_id = $hotel['id'];
                                        $query2 = "SELECT * FROM hotel_rest WHERE hotel_id=$hotel_id AND rest_id={$branch['br_id']}";
                                        $hotel_rest_q = $this->db->query($query2)->result_array();
                                        if (count($hotel_rest_q) > 0) {
                                            $hotel_rest = $hotel_rest_q[0];
                                            if ($hotel_rest['hotel_id'] == $hotel['id'])
                                                $hotel_list .= "<option value='" . $hotel['id'] . "' selected='selected'> " . $hotel['hotel_name'] . "</option>";
                                        } else
                                            $hotel_list .= "<option value='" . $hotel['id'] . "'> " . $hotel['hotel_name'] . "</option>";
                                    } else
                                        $hotel_list .= "<option value='" . $hotel['id'] . "'>" . $hotel['hotel_name'] . "</option>";
                                }
                                echo $hotel_list;
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-12 control-label" for="tot_seats"><?=lang('total_seats_t')?></label>
                    <div class="col-md-12">
                        <input class="form-control" name="tot_seats" id="tot_seats" <?php if ((isset($branch)) && ($branch['tot_seats'] != "")) echo 'value="' . $branch['tot_seats'] . '"'; ?> placeholder="<?=lang('total_seats')?>" />
                    </div>
                </div>
                </div>
                </div>
                    <h6><?=lang('features_services')?></h6>
                    <div class="form-group row label-heading">
                        <label class="col-md-12 control-label check-title" for="seatings"><?=lang('seatings_rooms')?></label>
                        <div class="col-sm-2">
                            <select class="form-control form-control-sm" name="seatings" id="seatings">
                                <option value=""> <?=lang('capacity')?> </option>
                                <option value="Seating capacity:Small(5-8)" <?php
                                                                            if (isset($branch)) {
                                                                                echo $branch['seatings'] == "Seating capacity:Small(5-8)" ? 'selected="selected"' : "";
                                                                            }
                                                                            ?>><?=lang('small5_8')?></option>
                                <option value="Seating capacity:Medium(10-50)" <?php
                                                                                if (isset($branch)) {
                                                                                    echo $branch['seatings'] == "Seating capacity:Medium(10-50)" ? 'selected="selected"' : "";
                                                                                }
                                                                                ?>><?=lang('medium10_50')?></option>
                                <option value="Seating capacity:Large(60-200)" <?php
                                                                                if (isset($branch)) {
                                                                                    echo $branch['seatings'] == "Seating capacity:Large(60-200)" ? 'selected="selected"' : "";
                                                                                }
                                                                                ?>><?=lang('large60_200')?></option>
                                <option value="Seating capacity:Banquet(200+)" <?php
                                                                                if (isset($branch)) {
                                                                                    echo $branch['seatings'] == "Seating capacity:Banquet(200+)" ? 'selected="selected"' : "";
                                                                                }
                                                                                ?>><?=lang('banquet')?></option>
                            </select>
                        </div>
                        <div class="col-sm-10">

                            <div class="checkbox-content mt-1">
                                <?php
                                if (isset($branch)) {
                                    $seatingrooms = explode(',', $branch['seating_rooms']);
                                }
                                ?>
                                <input  name="seating_rooms[]" type="checkbox" class="form-check-input" value="Indoor" <?php
                                                                                                if (isset($branch)) {
                                                                                                    if (in_array("Indoor", $seatingrooms)) {
                                                                                                ?>checked="checked" <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                        ?> />
                                <?=lang('indoor')?>
                                <input name="seating_rooms[]" type="checkbox" class="form-check-input" value="Outdoor" <?php
                                                                                                if (isset($branch)) {
                                                                                                    if (in_array("Outdoor", $seatingrooms)) {
                                                                                                ?>checked="checked" <?php
                                                                                                                    }
                                                                                                                }
                                                                                                                        ?> />
                                 <?=lang('outdoor')?>
                                <input name="seating_rooms[]" type="checkbox" class="form-check-input" value="Child Friendly" <?php
                                                                                                        if (isset($branch)) {
                                                                                                            if (in_array("Child Friendly", $seatingrooms)) {
                                                                                                        ?>checked="checked" <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?> />
                                
                                <?=lang('child_friendly')?>
                                <input name="seating_rooms[]" type="checkbox" class="form-check-input" value="Single Section" <?php
                                                                                                        if (isset($branch)) {
                                                                                                            if (in_array("Single Section", $seatingrooms)) {
                                                                                                        ?>checked="checked" <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?> />
                               <?=lang('single_section')?>
                                <input name="seating_rooms[]" type="checkbox" class="form-check-input" value="Family Section" <?php
                                                                                                        if (isset($branch)) {
                                                                                                            if (in_array("Family Section", $seatingrooms)) {
                                                                                                        ?>checked="checked" <?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?> />
                                <?=lang('family_section')?>
                                <input name="seating_rooms[]" type="checkbox" class="form-check-input" value="Private room" <?php
                                                                                                    if (isset($branch)) {
                                                                                                        if (in_array("Private room", $seatingrooms)) {
                                                                                                    ?>checked="checked" <?php
                                                                                                                        }
                                                                                                                    }
                                                                                                                            ?> />
                                     <?=lang('private_room')?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row label-heading">
                        <label class="col-md-12 control-label check-title" for="features_services"> <?=lang('b_features_services')?></label>
                        <div class="col-md-12 input-spacer"></div>
                    </div>
                    <div class="form-group row">
                        <div class="input-spacer">
                            <?php
                            if (isset($branch)) {
                                $feat_ser = explode(',', $branch['features_services']);
                            }
                            ?>
                            <div class="checkbox-content">
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Wifi", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Wifi" />
                                <?=lang('wifi')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("TV Screens", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="TV Screens" />
                                <?=lang('tv_screens')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Sheesha", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Sheesha" />
                                <?=lang('Sheesha')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Wheel Chair Accessibility", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Wheel Chair Accessibility" />
                                <?=lang('wheel_accessibility')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Smoking", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Smoking" />
                                  <?=lang('Smoking')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Non Smoking", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Non Smoking" />
                                <?=lang('non_smoking')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Valet Parking", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Valet Parking" />
                                  <?=lang('valet_parking')?><br>
                            </div>
                            <div class="top checkbox-content">
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Drive Through", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Drive Through" />
                                 <?=lang('drive_through')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Buffet", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Buffet" />
                                <?=lang('Buffet')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Takeaway", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Takeaway" />
                                <?=lang('takeaway')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Delivery", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Delivery" />
                                <?=lang('delivery')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Business Facilities", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Business Facilities" />
                                 <?=lang('business_facilities')?>
                                <input name="features_services[]" type="checkbox" class="form-check-input" <?php
                                                                                    if (isset($branch)) {
                                                                                        if (in_array("Catering services", $feat_ser)) {
                                                                                    ?> checked="checked" <?php
                                                                                                            }
                                                                                                        }
                                                                                                                ?> value="Catering services" />
                                 <?=lang('catering_services')?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row label-heading">
                        <label class="col-md-12 control-label check-title" for="features_services"> <?=lang('moods_atmosphere')?></label>
                        <div class="col-md-12 input-spacer"></div>
                    </div>
                    <div class="form-group row">
                        <div class="input-spacer checkbox-content">
                            <?php
                            if (isset($branch)) {
                                $mood = explode(',', $branch['mood_atmosphere']);
                            }
                            ?>
                            <input name="mood_atmosphere[]" type="checkbox" class="form-check-input" <?php
                                                                            if (isset($branch)) {
                                                                                if (in_array("Busy", $mood)) {
                                                                            ?> checked="checked" <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?>value="Busy" />
                            <?=lang('Busy')?>
                            <input name="mood_atmosphere[]" type="checkbox" class="form-check-input" <?php
                                                                            if (isset($branch)) {
                                                                                if (in_array("Quiet", $mood)) {
                                                                            ?> checked="checked" <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?> value="Quiet" />
                              <?=lang('Quiet')?>
                            <input name="mood_atmosphere[]" type="checkbox" class="form-check-input" <?php
                                                                            if (isset($branch)) {
                                                                                if (in_array("Romantic", $mood)) {
                                                                            ?> checked="checked" <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?> value="Romantic" />
                            <?=lang('Romantic')?>
                            <input name="mood_atmosphere[]" type="checkbox" class="form-check-input" <?php
                                                                            if (isset($branch)) {
                                                                                if (in_array("Young Crowd", $mood)) {
                                                                            ?> checked="checked" <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?> value="Young Crowd" />
                            <?=lang('young_crowd')?>
                            <input name="mood_atmosphere[]" type="checkbox" class="form-check-input" <?php
                                                                            if (isset($branch)) {
                                                                                if (in_array("Trendy", $mood)) {
                                                                            ?> checked="checked" <?php
                                                                                                    }
                                                                                                }
                                                                                                        ?> value="Trendy" />
                            <?=lang('Trendy')?>
                            <?php
                            if (isset($branch)) {
                            ?>
                                <input type="hidden" name="br_id" id="br_id" value="<?php echo $branch['br_id']; ?>">
                            <?php } ?>
                            <input type="hidden" name="rest_fk_id" id="rest_fk_id" value="<?php echo $rest['rest_ID']; ?>">
                            <input type="hidden" name="rest_Name" id="rest_Name" value="<?php echo $rest['rest_Name']; ?>">
                        </div>
                    </div>

                    <div class="form-group row text-end">
                        <div class="col-md-12 input-spacer">
                        <a href="<?php
                                            if (isset($_SERVER['HTTP_REFERER']))
                                                echo $_SERVER['HTTP_REFERER'];
                                            else
                                                echo base_url();
                                            ?>" class="btn btn-light" title="Cancel Changes"><?=lang('cancel')?></a>
                                <button type="submit" class="btn btn-danger" ><?=lang('save')?></button>
                               
                            
                        </div>
                    </div>
        
            </form>
           
        </div>
  

</section>
<script>
    var geocoder;
    var map;
    var marker;
    var lat = <?= (!empty($branch['latitude'])) ? $branch['latitude'] : '0.0'; ?>;
    var lng = <?= (!empty($branch['longitude'])) ? $branch['longitude'] : '0.0'; ?>;
    var zoom = <?= (!empty($branch['zoom'])) ? $branch['zoom']: '7'; ?>;
    var init = {lat: lat, lng: lng};
    function initMap() {
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById("map"), {center: init, zoom: zoom, mapTypeId: google.maps.MapTypeId.ROADMAP});
        marker = new google.maps.Marker({position: init, map: map, animation: google.maps.Animation.DROP, });
        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);
        });
        google.maps.event.addListener(map, 'zoom_changed', function (event) {
            document.getElementById("zoom").value = map.zoom
        });

        function placeMarker(latLng) {
            document.getElementById('latitude').value = latLng.lat();
            document.getElementById('longitude').value = latLng.lng();
            if (marker) {
                marker.setPosition(latLng);
            } else {
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    animation: google.maps.Animation.DROP,
                });
            }
            map.panTo(latLng);
        }

    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq3C6MH2XjShVLm07FYuisLUV59LHyzNU&signed_in=true&language=<?= (sys_lang() == 'english') ? 'en' : 'ar'; ?>&callback=initMap"></script>

<script>
function getDistrictMap(id) {
    var geocoder = new google.maps.Geocoder();
               var district = $('#' + id + ' option:selected').text();
               var city = $("#city_ID option:selected").text();
               var address = city + " " + district;
               geocoder.geocode({
                   'address': address
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       latt = results[0].geometry.location.lat().toString().substr(0, 12);
                       lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                       loadmap(latt, lngg)
                   } else {
                    console.log('error: ' + status);
                   }
               });
           }

           function selectcity() {
            var geocoder = new google.maps.Geocoder();

               var city = $("#city_ID").val();
               $(".district").addClass('invisible');
               $("#district_" + city).removeClass('invisible');
               $("#cityCode option[data-city='" + city + "']").attr('selected', true);
               var cityname = $("#city_ID option:selected").text();

               geocoder.geocode({
                   'address': cityname
               }, function(results, status) {
                   if (status == google.maps.GeocoderStatus.OK) {
                       latt = results[0].geometry.location.lat().toString().substr(0, 12);
                       lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                       loadmap(latt, lngg)
                   } else {
                       console.log('error: ' + status);
                   }
               });
           }
           function selecthotel(){
               var val=$("#branch_type").val();
               if(val!=''){
                   $("#hotel_value").show();
               }
               else{
                $("#hotel_value").hide();

               }
           }
           selecthotel();
</script>