@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminrestaurants'); ?>">All Restaurants</a></li>  
    <?php if (isset($cat)) { ?>
        <li><a href="<?= route('adminarticles/articles/', $cat->id); ?>">{{ $cat->name; }}</a></li>
    <?php } ?>
    <li class="active">{{ $title }}</li>
</ol>




<?php
include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <article>
        <?php
            if ((isset($branch)) && ($branch->br_number != "")) {
                list($cityCode, $phone) = explode('-', $branch->br_number);
            }
            $cityoptions = $citycodes = $cityCode = "";
            foreach ($cities as $city) {
                $cityoptions.='<option value="' . $city->city_ID . '"';
                $citycodes.='<option data-city="' . $city->city_ID . '" value="' . $city->city_Code . '"';
                if (isset($branch)) {
                    if ($branch->city_ID == $city->city_ID) {
                        $cityoptions.=' selected="selected"';
                    }
                }
                if ((isset($branch)) && ($cityCode != "") && ($cityCode == $city->city_Code)) {
                    $citycodes.=' selected="selected"';
                }
                $cityoptions.='>' . $city->city_Name . '</option>';
                $citycodes.='>' . $city->city_Code . '</option>';
            }
        ?>
        <form name="restMainForm" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestaurants/branches/save'); }}" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['ref'])) {
                ?>
                <input type="hidden" name="ref" value="<?php echo $_GET['ref']; ?>"/>
                <input type="hidden" name="per_page" value="<?php echo $_GET['per_page']; ?>"/>
                <input type="hidden" name="limit" value="<?php echo $_GET['limit']; ?>"/>
                <?php
            }
            ?>
            <fieldset>
                <legend>Branch Location Information</legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="branch_type">Branch Type</label>
                    <div class="col-md-6">
                        <select class="form-control" name="branch_type" id="branch_type" onchange="selecthotel();">
                            <?php
                            $branchType = Config::get('commondata.branchType');
                            if (is_array($branchType)) {
                                foreach ($branchType as $key => $value) {
                                    $selected = "";
                                    if (isset($branch) && $branch->branch_type == $key) {
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
                        <select name='hotel_value' id='hotel_value'
                        <?php
                            if (!isset($branch) || ($branch->branch_type != "Hotel Restaurant")) {
                                echo 'class="form-control invisible none-select2 my-2 w-100" ';
                            } else {
                                echo 'class="form-control"';
                            }
                        ?>>
                        <?php
                            if (count($hotels) > 0) {
                                $hotel_list = "";
                                foreach ($hotels as $hotel) {
                                    if (isset($branch)) {
                                        $hotel_id = $hotel->id;
                                        $hotel_restss = $MRestActions->getHotelRest($hotel_id, $branch->br_id);
                                    
                                        if (count($hotel_restss) > 0) {
                                            $hotel_rest = $hotel_restss;
                                            if ($hotel_rest->hotel_id == $hotel->id)
                                                $hotel_list .= "<option value='" . $hotel->id . "' selected='selected'> " . $hotel->hotel_name . "</option>";
                                        } else {
                                            $hotel_list .= "<option value='" . $hotel->id . "'> " . $hotel->hotel_name . "</option>";
                                        }
                                    } else {
                                        $hotel_list .= "<option value='" . $hotel->id . "'>" . $hotel->hotel_name . "</option>";
                                    }
                                }
                                echo $hotel_list;
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="city_ID">Select City</label>
                    <div class="col-md-6">
                        <select class="form-control required" name="city_ID" id="city_ID" onchange="selectcity();">
                            <option value=""> Select City</option>
                            <?php echo $cityoptions; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="city_ID">Select District</label>
                    <div class="col-md-6">
                        <?php
                        $i = 0;
                        foreach ($cities as $city) {
                            $i++;
                            $districts = MGeneral::getCityDistricts($city->city_ID);
                            if (count($districts) > 0 && is_array($districts)) {
                                ?>
                                <select name="district_<?php echo $city->city_ID; ?>" id="district_<?php echo $city->city_ID; ?>" class="form-control district none-select2 <?php
                                if (isset($branch)) {
                                    if ($branch->city_ID != $city->city_ID)
                                        echo 'invisible';
                                }else {
                                    if ($i != 1)
                                        echo 'invisible';
                                }
                                ?>" 
                                <?php if ((!isset($branch)) || ($branch->latitude == "")) { ?> onchange="getDistrictMap('district_<?php echo $city->city_ID; ?>');" <?php } ?>>
                                    <?php
                                        foreach ($districts as $district) {
                                    ?>
                                    <option value="<?php echo $district->district_ID; ?>" 
                                    <?php
                                        if (isset($branch)) {
                                            echo $branch->district_ID == $district->district_ID ? 'selected="selected"' : "";
                                        }
                                    ?> >
                                    <?php echo $district->district_Name; ?>
                                    </option>
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
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="br_loc">Location Description</label>
                    <div class="col-md-6">
                        <input class="form-control required" type="text" name="br_loc" id="br_loc" placeholder="Branch Location" <?php echo isset($branch) ? 'value="' . stripslashes(($branch->br_loc)) . '"' : ''; ?>/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="br_loc_ar">Branch Location Arabic</label>
                    <div class="col-md-6">
                        <input class="form-control required" type="text" name="br_loc_ar" id="br_loc_ar" placeholder="Branch Location Arabic" <?php echo isset($branch) ? 'value="' . stripslashes(($branch->br_loc_ar)) . '"' : ''; ?>/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="cityCode">Branch Tel Number</label>
                    <div class="col-md-2 d-inline">
                        <select class="form-control auto-width" name="cityCode" id="cityCode">
                            <?php echo $citycodes; ?>
                        </select>
                        </div>
                        <div class="col-md-4 d-inline">
                        <input class="form-control auto-width " name="br_number" id="br_number" <?php if ((isset($branch)) && ($branch->br_number != "") && ($phone != "")) echo 'value="' . $phone . '"'; ?> placeholder="Branch Phone Number"/>
                    </div>
                   
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="br_mobile">Branch Mobile</label>
                    <div class="col-md-6">
                        <input name="br_mobile" id="br_mobile" <?php if ((isset($branch)) && ($branch->br_mobile != "")) echo 'value="' . $branch->br_mobile . '"'; ?> placeholder="Mobile Number" class="form-control"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="br_mobile">Map
                        <a href="javascript:void(0)" onClick="showMap()" id="addMap" title="Click to Add Google Map Location for your Branch" style="display:none;">
                            <b> Click to  Add Map Location</b>
                        </a>
                        <a href="javascript:void(0)" onClick="hideMap()" id="removeMap" title="Click to Remove Google Map" >
                            <b>Hide Map</b>
                        </a>
                    </label>
                    <div class="col-md-8">
                        <div class="row">
                            <div class=" col-md-6">
                                Latitude:&nbsp;<input class="form-control auto-width" type="text" name="latitude" id="latitude" value="<?php
                                if (isset($branch)) {
                                    echo $branch->latitude;
                                }
                                ?>"/>
                            </div>
                            <div class=" col-md-6">
                                Longitude:&nbsp;<input class="form-control auto-width " type="text" name="longitude" id="longitude" value="<?php
                                if (isset($branch)) {
                                    echo $branch->longitude;
                                }
                                ?>"/>
                            </div>
                        </div>

                        <br /><br />
                        <input type="hidden" name="zoom" id="zoom" value="14"/>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                        <?php
                        if ((isset($branch)) && ($branch->latitude != "") && ($branch->longitude != "")) {
                            ?>
                            <script type="text/javascript">
                                var geocoder = new google.maps.Geocoder();
                                function geocodePosition(pos) {
                                    geocoder.geocode({
                                        latLng: pos
                                    }, function(responses) {

                                    });
                                }

                                function updateMarkerPosition(latLng) {
                                    document.getElementById("latitude").value = latLng.lat();
                                    document.getElementById("longitude").value = latLng.lng();
                                }

                                function initialize() {
                                    var latLng = new google.maps.LatLng('<?php echo $branch->latitude; ?>', '<?php echo $branch->longitude; ?>');
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 8,
                                        center: latLng,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    });
                                    var marker = new google.maps.Marker({
                                        draggable: true,
                                        position: latLng,
                                        title: 'drag to select postion',
                                        map: map
                                    });

                                    updateMarkerPosition(latLng);
                                    geocodePosition(latLng);

                                    google.maps.event.addListener(marker, 'drag', function() {
                                        updateMarkerPosition(marker.getPosition());
                                    });
                                }
                            </script>
                            <?php
                        } else {
                            ?>
                            <script type="text/javascript">
                                var geocoder = new google.maps.Geocoder();
                                function geocodePosition(pos) {
                                    geocoder.geocode({
                                        latLng: pos
                                    }, function(responses) {

                                    });
                                }

                                function updateMarkerPosition(latLng) {
                                    document.getElementById("latitude").value = latLng.lat();
                                    document.getElementById("longitude").value = latLng.lng();
                                }

                                function initialize() {
                                    var latt = '23.885942'; //23.885942
                                    var lngg = '45.079162'; //45.079162
                                    var address = 'Saudi Arabia';
                                    geocoder.geocode({'address': address}, function(results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                                            loadmap(latt, lngg)
                                        } else {
                                            alert('error: ' + status);
                                        }
                                    });
                                }

                                function loadmap(latt, lngg) {
                                    var latLng = new google.maps.LatLng(latt, lngg);
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 8,
                                        center: latLng,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    });
                                    var marker = new google.maps.Marker({
                                        draggable: true,
                                        position: latLng,
                                        title: 'drag to select postion',
                                        map: map
                                    });

                                    updateMarkerPosition(latLng);
                                    geocodePosition(latLng);

                                    google.maps.event.addListener(marker, 'drag', function() {
                                        updateMarkerPosition(marker.getPosition());
                                    });
                                }

                                function getDistrictMap(id) {
                                    var district = $('#' + id + ' option:selected').text();
                                    var city = $("#city_ID option:selected").text();
                                    var address = city + " " + district;
                                    geocoder.geocode({'address': address}, function(results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                                            loadmap(latt, lngg)
                                        } else {
                                            alert('error: ' + status);
                                        }
                                    });
                                }

                                function selectcity() {
                                    var city = $("#city_ID").val();
                                    $(".district").addClass('invisible');
                                    $("#district_" + city).removeClass('invisible');
                                    $("#cityCode option[data-city='" + city + "']").attr('selected', true);
                                    var cityname = $("#city_ID option:selected").text();

                                    geocoder.geocode({'address': cityname}, function(results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                                            loadmap(latt, lngg)
                                        } else {
                                            console.log('error: ' + status);
                                        }
                                    });
                                }
                            </script>
                        <?php } ?>
                        <div id="map" style="width:100%; height: 400px"></div>
                    </div>
                </div>        
            </fieldset>
            <fieldset>
                <legend>Branch Features & Services</legend>        
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="features_services">Features &amp; Services</label>
                    <div class="col-md-10 input-spacer">
                        <?php
                        if (isset($branch)) {
                            $feat_ser = explode(',', $branch->features_services);
                        }
                        ?>
                        <div>    
                            <?php
                            if (count($featureAndServices) > 0) {
                                foreach ($featureAndServices as $feature) {
                                    ?>
                                    <div class="form-check">
                                    <input class="form-check-input" name="features_services[]" type="checkbox" <?php
                                    if (isset($branch)) {
                                        if (in_array($feature->name, $feat_ser)) {
                                            ?> checked="checked"<?php
                                               }
                                           }
                                           ?>  value="{{$feature->name}}" />
                                           <label class="form-check-label">{{$feature->name}}</label>
                                           </div>
                                           <?php
                                       }
                                   }
                                   ?>
                        </div>
                    </div>
                </div>
                <legend>Branch Moods & Atmosphere</legend>     
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="tot_seats">Moods & Atmosphere</label>
                    <div class="col-md-10 input-spacer top">
                        <?php
                        if (isset($branch)) {
                            $mood = explode(',', $branch->mood_atmosphere);
                        }

                        if (count($moodsAtmosphere) > 0) {
                            foreach ($moodsAtmosphere as $atmosphere) {
                                ?>
                                <input name="mood_atmosphere[]" type="checkbox" <?php
                                if (isset($branch)) {
                                    if (in_array($atmosphere->name, $mood)) {
                                        ?> checked="checked"<?php
                                           }
                                       }
                                       ?>value="{{$atmosphere->name}}" />{{$atmosphere->name}}
                                       <?php
                                   }
                               }
                               ?>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Seatings & Rooms</legend>

                <div class="form-group row">
                    <label class="col-md-2 control-label" for="tot_seats">Total Seats Available</label>
                    <div class="col-md-6">
                        <input class="form-control" name="tot_seats" id="tot_seats" <?php if ((isset($branch)) && ($branch->tot_seats != "")) echo 'value="' . $branch->tot_seats . '"'; ?> placeholder="Total Seats available in the Branch"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="seatings">Seatings & Rooms</label>
                    <div class="col-md-6 input-spacer">
                        <select class="form-control auto-width" name="seatings" id="seatings">
                            <?php
                            $branchSeatings = Config::get('commondata.branchSeatings');
                            if (is_array($branchSeatings)) {
                                foreach ($branchSeatings as $key => $value) {
                                    $selected = "";
                                    if (isset($branch) && $branch->seatings == $key) {
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
                        <?php
                        if (isset($branch)) {
                            $seatingrooms = explode(',', $branch->seating_rooms);
                        }

                        $seating_rooms = Config::get('commondata.seating_rooms');
                        if (is_array($seating_rooms)) {
                            foreach ($seating_rooms as $key => $value) {
                                ?>
                                <input name="seating_rooms[]" type="checkbox" <?php
                                if (isset($branch)) {
                                    if (in_array($key, $seatingrooms)) {
                                        ?> checked="checked"<?php
                                           }
                                       }
                                       ?>value="{{$key}}" />{{$value}}
                                       <?php
                                   }
                               }
                               ?>
                    </div>
                </div>
                <legend></legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="status">Publish</label>
                    <div class="col-md-10">
                        <input type="checkbox" <?php if (!isset($branch->status) || $branch->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 offset-md-2">
                        <?php
                        if (isset($branch)) {
                            ?>
                            <input type="hidden" name="br_id" id="br_id" value="<?php echo $branch->br_id; ?>">
                        <?php } ?>
                        <input type="hidden" name="rest_fk_id" id="rest_fk_id" value="<?php echo $rest->rest_ID; ?>">
                        <input type="hidden" name="rest_Name" id="rest_Name" value="<?php echo $rest->rest_Name; ?>">
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php
                        if (isset($_SERVER['HTTP_REFERER']))
                            echo $_SERVER['HTTP_REFERER'];
                        else
                            echo site_url('hungryn137/branch?rest=' . $rest->rest_ID);
                        ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>



<script type="text/javascript">

    google.maps.event.addDomListener(window, 'load', initialize);
    if ($("#city_ID").val() != "") {
        selectcity();
    }


</script>
<script>
    function hideMap(){
        $("#map").hide();
        $("#removeMap").hide();
        $("#addMap").show();
    }
    function showMap(){
        $("#map").show();
        $("#addMap").hide();
        $("#removeMap").show();
    }
</script>
@endsection
