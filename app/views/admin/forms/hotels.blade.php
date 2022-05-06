@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminhotels'); ?>">Hotels</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<?php


$cityoptions = "";
foreach ($cities as $city) {
    $cityoptions.='<option value="' . $city->seo_url . '"';
    if (isset($hotel)) {
        if (strpos($hotel->city_id, $city->seo_url, 0) !== false) {
            $cityoptions.=' selected="selected"';
        }
    }
    $cityoptions.='>' . $city->city_Name . '</option>';
}
?>

<div class="well-white">
    <article>
        <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminhotels/save'); ?>" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="hotel_name">Name</label>
                    <div class="col-md-6">
                        <input class="form-control required" type="text" name="hotel_name" id="hotel_name" placeholder="Hotel Name"  value="<?php echo isset($hotel) ?  stripslashes(($hotel->hotel_name))  : old('hotel_name'); ?>" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="hotel_name_ar">Name Arabic</label>
                    <div class="col-md-6">
                        <input class="form-control required" dir="rtl" type="text" name="hotel_name_ar" id="hotel_name_ar" placeholder="Hotel Name Arabic"  value="<?php echo isset($hotel) ? stripslashes(($hotel->hotel_name_ar))  :old('hotel_name_ar'); ?>" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="hotel_name_ar">Select Hotel Cities</label>
                    <div class="col-md-6">
                        <select multiple class="chzn-select form-control required" tabindex="7" data-placeholder="Select Cities" name="city_id[]" id="city_id">
                            <?php echo $cityoptions; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="star">Hotel Stars</label>
                    <div class="col-md-6">
                        <input class="form-control required" type="number" name="star" id="star" placeholder="Hotel Stars"  value="<?php echo isset($hotel) ? $hotel->star :old('star'); ?>" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="hotel_logo">Logo</label>
                    <div class="col-md-6">
                        <input type="file" name="hotel_logo" id="hotel_logo" />
                        <?php
                        if (isset($hotel) && ($hotel->hotel_logo != "")) {
                            ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>logos/<?php echo $hotel->hotel_logo; ?>"/>
                            <input type="hidden" name="hotel_logo_old" value="<?php echo $hotel->hotel_logo; ?>"/>
                            <a href="<?php echo route('adminhotels/deleteImage/',$hotel->id).'?type=logo'; ?>"> Delete Logo </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="image">Image</label>
                    <div class="col-md-6">
                        <input type="file" name="image" id="image" />
                        <?php
                        if (isset($hotel) && ($hotel->image != "")) {
                            ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/hotel/thumb/<?php echo $hotel->image; ?>"/>
                            <input type="hidden" name="image_old" value="<?php echo $hotel->image; ?>"/>
                            <a href="<?php echo route('adminhotels/deleteImage/',$hotel->id).'?type=image'; ?>"> Delete Image </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-2" for="status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($hotel->status) || $hotel->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-2">
                        <?php if (isset($hotel)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $hotel->id; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo route('adminhotels'); ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>

@endsection
