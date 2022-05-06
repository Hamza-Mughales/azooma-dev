@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincompetitions'); ?>">All Competitions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<?php


$cityoptions = "";
foreach ($cities as $city) {
    $cityoptions.='<option value="' . $city->city_ID . '"';

    if (isset($competition)) {
        if ($competition->city == $city->city_ID) {
            $cityoptions.=' selected="selected"';
        }
    }
    $cityoptions.='>' . $city->city_Name . '</option>';
}
?>
<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form id="jqValidate"class="form-horizontal restaurant-form" method="post" action="{{ route('admincompetitions/save'); }}" enctype="multipart/form-data">
            <fieldset>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="title">Event Title</label>
                    <div class="col-md-6">
                        <input class="required form-control" type="text" name="title" id="title" placeholder="Event Title" <?php echo isset($competition) ? 'value="' . stripslashes(($competition->title)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="titleAr">Event Title Arabic</label>
                    <div class="col-md-6">
                        <input class="required form-control" dir="rtl" type="text" name="titleAr" id="titleAr" placeholder="Event Title Arabic" <?php echo isset($competition) ? 'value="' . stripslashes(($competition->titleAr)) . '"' : ""; ?> />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-2" for="participants">No. of Participants</label>
                    <div class="col-md-6">
                        <input class="required form-control" type="text" name="participants" id="participants" placeholder="No of Participants" <?php echo isset($competition) ? 'value="' . $competition->participants . '"' : ""; ?> />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-2" for="start_date">Event start Date</label>
                    <div class="col-md-6">
                        <input class="required form-control" type="text" name="start_date" id="start_date" placeholder="Event start Date" <?php echo isset($competition) ? 'value="' . $competition->start_date . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="end_date">Event end Date</label>
                    <div class="col-md-6">
                        <input class="required form-control" type="text" name="end_date" id="end_date" placeholder="Event end Date" <?php echo isset($competition) ? 'value="' . $competition->end_date . '"' : ""; ?> />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-2" for="start_time">Time</label>
                    <div class="col-md-6">
                        <select class="form-control auto-width" name="start_time">
                            <option value="">Start Time</option>
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
                                        if (isset($competition->start_time) and $competition->start_time == $act_time) {
                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                        } else {
                                            echo "<option value='$act_time'>$act_time</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                        <select class="form-control auto-width" name="end_time">
                            <option value="">End Time</option>
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
                                        if (isset($competition->end_time) and $competition->end_time == $act_time) {
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


                <div class="form-group row">
                    <label class="control-label col-md-2" for="event_type">Type of Event</label>
                    <div class="col-md-6">
                        <select name="event_type" id="event_type" class="form-control" onchange="select_type(this.value)">
                            <option value="">Select Event Type</option>
                            <option value="1" <?php
                            if (isset($competition) && $competition->event_type == 1) {
                                echo 'selected';
                            }
                            ?>>Children</option>
                            <option value="2" <?php
                            if (isset($competition) && $competition->event_type == 2) {
                                echo 'selected';
                            }
                            ?>>Adult</option>
                            <option value="3" <?php
                            if (isset($competition) && $competition->event_type == 3) {
                                echo 'selected';
                            }
                            ?>>Men</option>
                            <option value="4" <?php
                            if (isset($competition) && $competition->event_type == 4) {
                                echo 'selected';
                            }
                            ?>>Ladies</option>
                        </select>
                    </div>
                </div>  


                <div id="age_type" class="form-group <?php
                if (isset($competition) && $competition->event_type == 1) {
                    echo '';
                } else {
                    echo 'hidden';
                }
                ?>">
                    <label class="control-label col-md-2" for="age_range_from">Age Range</label>
                    <div class="col-md-6">
                        <select name="age_range_from" id="age_range_from" class="form-control auto-width">
                            <?php
                            for ($i = 4; $i <= 16; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                            ?>                            
                        </select>
                        <select name="age_range_to" id="age_range_to" class="form-control auto-width">
                            <?php
                            for ($i = 4; $i <= 16; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                            ?>                            
                        </select>
                    </div>
                </div>  

                <div class="form-group row">
                    <label class="control-label col-md-2" for="image">
                        Artwork
                        <br>
                        <span class="small-font"> 400 * 300  </span>
                    </label>
                    <div class="col-md-6">
                        <input type="file" name="image" id="image" />
                        <?php
                        if (isset($competition) && ($competition->image != "")) {
                            ?>
                            <img src="<?php echo Azooma::CDN('images/competition/thumb/' . $competition->image); ?>"/>
                            <input type="hidden" name="image_old" value="<?php echo $competition->image; ?>"/>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-2" for="city_ID">Select City</label>
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
                            if (count($districts) > 0) {
                                ?>
                                <select name="district_<?php echo $city->city_ID; ?>" id="district_<?php echo $city->city_ID; ?>" class="form-control form-control district <?php
                                if (isset($branch)) {
                                    if ($branch->city_ID != $city->city_ID)
                                        echo 'invisible';
                                }else {
                                    if ($i != 1)
                                        echo 'invisible';
                                }
                                ?>" <?php if ((!isset($branch)) || ($branch->latitude == "")) { ?> onchange="getDistrictMap('district_<?php echo $city->city_ID; ?>');" <?php } ?>>
                                            <?php
                                            if (is_array($districts) && count($districts) > 0) {
                                                foreach ($districts as $district) {
                                                    ?>
                                            <option value="<?php echo $district->district_ID; ?>" <?php
                                            if (isset($branch)) {
                                                echo $branch->district_ID == $district->district_ID ? 'selected="selected"' : "";
                                            }
                                            ?> >
                                                        <?php echo $district->district_Name; ?>
                                            </option>
                                            <?php
                                        }
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
                    <label class="control-label col-md-2" for="logo">
                        Logo
                        <br>
                        <span class="small-font"> 200 * 200  </span>
                    </label>
                    <div class="col-md-6">
                        <input type="file" name="logo" id="logo" />
                        <?php
                        if (isset($competition) && ($competition->logo != "")) {
                            ?>
                            <img src="<?php echo Azooma::CDN('images/competition/300/' . $competition->logo); ?>"/>
                            <input type="hidden" name="logo_old" value="<?php echo $competition->logo; ?>"/>
                            <?php
                        }
                        ?>
                    </div>
                </div>



                <div class="form-group row">
                    <label class="control-label col-md-2" for="br_mobile">Map
                        <a href="javascript:void(0)" onClick="showMarker()" id="addMap" title="Click to Add Google Map Location for your Branch" style="display:none;">
                            <b> Click to  Add Map Location</b>
                        </a>
                        <a href="javascript:void(0)" onClick="hideMarker()" id="removeMap" title="Click to Remove Google Map" >
                            <b>X Hide Map</b>
                        </a>
                    </label>
                    <div class="col-md-6">
                        <input type="hidden" name="latitude" id="latitude" value="<?php
                        if (isset($competition)) {
                            echo $competition->latitude;
                        }
                        ?>"/>
                        <input type="hidden" name="longitude" id="longitude" value="<?php
                        if (isset($competition)) {
                            echo $competition->longitude;
                        }
                        ?>"/>
                        <input type="hidden" name="zoom" id="zoom" value="14"/>
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                        <?php
                        if ((isset($competition)) && ($competition->latitude != "") && ($competition->longitude != "")) {
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
                                var latLng = new google.maps.LatLng('<?php echo $competition->latitude; ?>', '<?php echo $competition->longitude; ?>');
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
                                    var latt = ''; //23.885942
                                    var lngg = ''; //45.079162
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



                            </script>
                        <?php } ?>
                        <div id="map" style="width: 600px; height: 400px"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-2" for="description">Event Message</label>
                    <div class="col-md-6">
                        <textarea name="description" id="description" rows="5" placeholder="Event Message"><?php echo isset($competition) ? $competition->description : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="descriptionAr">Event Message Arabic</label>
                    <div class="col-md-6">
                        <textarea dir="rtl" name="descriptionAr" id="descriptionAr" rows="5" placeholder="Event Message Arabic"><?php echo isset($competition) ? $competition->descriptionAr : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="Status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($competition->status) || $competition->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for=""></label>
                    <div class="col-md-6">
                        <?php if (isset($competition)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $competition->id; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php
                        if (isset($_SERVER['HTTP_REFERER']))
                            echo $_SERVER['HTTP_REFERER'];
                        else
                            echo route('admincompetitions');
                        ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>


<?php
echo HTML::script('js/ckeditor/ckeditor.js');
echo HTML::script('js/ckfinder/ckfinder.js');

?>
<script type="text/javascript">

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
    function select_type(val) {
        if (val == '1') {
            $('#age_type').removeClass('hidden');
        } else {
            $('#age_type').addClass('hidden');
        }
    }

    
    var editor_details = CKEDITOR.replace('description');
    CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
    var editor_details_ar = CKEDITOR.replace('descriptionAr');
    CKFinder.setupCKEditor(editor_details_ar, base + '/js/ckfinder/');
    

    $(document).ready(function() {
        
        if ($("#city_ID").val() != "") {
            selectcity();
        }
        $("#start_date").datepicker({
            format: 'mm/dd/yyyy'
        });
        $("#end_date").datepicker({
            format: 'mm/dd/yyyy'
        });
        google.maps.event.addDomListener(window, 'load', initialize);
    });
</script>

@endsection