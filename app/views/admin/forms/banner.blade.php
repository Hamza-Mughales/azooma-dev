@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminbanners'); ?>">All Banners</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<link rel="stylesheet" type="text/css" href="<?php echo asset(css_path()); ?>/date-picker.css">

<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminbanners/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">Banner Type</label>
                <div class="col-md-7">
                    <select onchange="return showsizeimage(this.value);" class="form-control required" data-placeholder="Select Banner Type" name="banner_type" id="banner_type"> 
                        <?php
                        $RestaurantStatus = Config::get('settings.bannertypes');
                        if (is_array($RestaurantStatus)) {
                            foreach ($RestaurantStatus as $key => $value) {
                                $selected = "";
                                if (isset($banner) && $banner->banner_type == $key) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="{{ $key }}" {{ $selected }} >
                                    {{ $value }}
                                </option>
                                <?php
                            }
                        }
                        ?>                        
                    </select> 
                </div>
            </div>

            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">City</label>
                <div class="col-md-7">
                    <select class="form-control required chzn-select" multiple="" data-placeholder="Select City" name="city_ID[]" id="city_ID"> 
                        <option value="0">All Cities</option>
                        <?php
                        if (isset($banner) && $banner->country != 0) {
                            $country = $banner->country;
                        } else {
                            $country = Session::get('admincountry');
                            if (empty($country)) {
                                $country = 1;
                            }
                        }
                        $cities = MGeneral::getAllCities($country);
                        $bannercities = "";
                        if (isset($banner)) {
                            $bannercities = explode(',', $banner->city_ID);
                        }
                        if (is_array($cities)) {
                            foreach ($cities as $value) {
                                $selected = "";
                                if (isset($banner) && in_array($value->city_ID, $bannercities)) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="{{ $value->city_ID }}" {{ $selected }} >
                                    {{ $value->city_Name }}
                                </option>
                                <?php
                            }
                        }
                        ?>                        
                    </select> 
                </div>
            </div>

            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">Cuisine</label>
                <div class="col-md-7">
                    <select class="form-control chzn-select required" multiple="" data-placeholder="Select Cuisine" name="cuisine_ID[]" id="cuisine_ID"> 
                        <option value="0">All Cuisine</option>
                        <?php
                        $cuisines = MGeneral::getAllCuisine(1);
                        $bannercuisines = "";
                        if (isset($banner)) {
                            $bannercuisines = explode(',', $banner->cuisine_ID);
                        }
                        if (is_array($cuisines)) {
                            foreach ($cuisines as $value) {
                                $selected = "";
                                if (isset($banner) && in_array($value->cuisine_ID, $bannercuisines)) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="{{ $value->cuisine_ID }}" {{ $selected }} >
                                    {{ $value->cuisine_Name }}
                                </option>
                                <?php
                            }
                        }
                        ?>                        
                    </select> 
                </div>
            </div>

            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Title</label>
                <div class="col-md-7">
                    <input type="text" name="title" class="form-control" value="{{ isset($banner) ? $banner->title : Input::old('title') }}" id="title" placeholder="title">
                </div>
            </div>

            <div class="form-group row">
                <label for="link" class="col-md-2 control-label">Link</label>
                <div class="col-md-7">
                    <input type="url" name="url" class="form-control" value="{{ isset($banner) ? $banner->url : Input::old('url') }}" id="url" placeholder="URL">
                </div>
            </div>

            <div class="form-group row">
                <label for="link_ar" class="col-md-2 control-label">Linnk Arabic</label>
                <div class="col-md-7">
                    <input type="url" name="url_ar" class="form-control"  value="{{ isset($banner) ? $banner->url_ar : Input::old('url_ar') }}" id="link_ar" placeholder="URL Arabic" >
                </div>
            </div>

            <div class="form-group row">
                <label for="start_date" class="col-md-2 control-label">Start Date</label>
                <div class="col-md-7">
                    <input type="text" autocomplete="off" name="start_date" class="form-control" value="{{ isset($banner) ? $banner->start_date : Input::old('start_date') }}" id="start_date" placeholder="Start Date">
                </div>
            </div>
            <div class="form-group row">
                <label for="end_date" class="col-md-2 control-label">End Date</label>
                <div class="col-md-7">
                    <input type="text" autocomplete="off" name="end_date" class="form-control"  value="{{ isset($banner) ? $banner->end_date : Input::old('end_date') }}" id="end_date" placeholder="End Date" >
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">
                    Artwork English
                    <div id="size-div">
                        <span id="top-banner" class="small-font">Size: 968 x 98 </span>
                        <span id="side-banner" class="hidden small-font">Size: 245 x 146</span>
                        <span id="results-banner" class="hidden small-font">Size: 657 x 50 </span>
                        <span id="side-banner-two" class="hidden small-font">Size:  265 x 146 </span>
                    </div>
                </label>
                <div class="col-md-7">
                    <input type="file" name="image" id="image">
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $banner->image; ?>"/>
                        <?php if ($banner->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl') . '/banner/' . $banner->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="image_ar" class="col-md-2 control-label">
                    Artwork Arabic
                    <div id="size-div-ar">
                        <span id="top-banner-ar" class="small-font">Size: 968 x 98 </span>
                        <span id="side-banner-ar" class="hidden small-font">Size: 245 x 146</span>
                        <span id="results-banner-ar" class="hidden small-font">Size: 657 x 50 </span>
                        <span id="side-banner-two-ar" class="hidden small-font">Size: 265 x 146 </span>
                    </div>
                </label>
                <div class="col-md-7">
                    <input type="file" name="image_ar" id="image_ar">
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="image_ar_old" value="<?php echo $banner->image_ar; ?>"/>
                        <?php if ($banner->image_ar != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl') . '/banner/' . $banner->image_ar; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-7">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($banner) ? ($banner->active==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-7">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($banner) ? $banner->id : 0 }}" id="id" >                       
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.en.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.custom.js"></script>
<script>
    $(document).ready(function() {
   
        $('#start_date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
        });
        $('#end_date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

 
        $("#city_ID").on('change', function() {
            if ($("#city_ID option[value='0']:selected").length > 0) {
                $("#city_ID").val(['0']);
                $("#city_ID").trigger("chosen:updated");
            }
        });
        $("#cuisine_ID").on('change', function() {
            if ($("#cuisine_ID option[value='0']:selected").length > 0) {
                $("#cuisine_ID").val(['0']);
                $("#cuisine_ID").trigger("chosen:updated");
            }
        });
    });

    function showsizeimage(ival) {
        $('#size-div span').removeClass('hidden');
        $('#size-div span').addClass('hidden');
        $('#size-div-ar span').removeClass('hidden');
        $('#size-div-ar span').addClass('hidden');
        if (ival == 1) {
            $('#top-banner').removeClass('hidden');
            $('#top-banner-ar').removeClass('hidden');
        } else if (ival == 2) {
            $('#side-banner').removeClass('hidden');
            $('#side-banner-ar').removeClass('hidden');
        } else if (ival == 3) {
            $('#results-banner').removeClass('hidden');
            $('#results-banner-ar').removeClass('hidden');
        } else if (ival == 4) {
            $('#side-banner-two').removeClass('hidden');
            $('#side-banner-two-ar').removeClass('hidden');
        }
    }
</script>

@endsection