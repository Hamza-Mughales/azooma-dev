@extends('admin.index')
@section('content')

<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>
    <li><a href="<?= route('adminrestgallery/', $rest_ID); ?>"> <?php echo stripslashes($rest->rest_Name); ?> Gallery </a></li>
    <li class="active">{{ $title }}</li>
</ol>
<link rel="stylesheet" type="text/css" href="<?php echo asset(css_path()); ?>/date-picker.css">



<div class="well-white">
    <?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
    ?>
    <article>
        <form name="offerForm" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestoffer/save'); }}" method="post" enctype="multipart/form-data">

            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="offerName">Offer Name</label>
                    <div class="col-md-8">
                        <input type="text" name="offerName" class="form-control required" id="offerName" placeholder="Offer Name" <?php echo isset($offer) ? 'value="' . stripslashes(($offer->offerName)) . '"' : ""; ?> />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="offerNameAr">Offer Name Arabic</label>
                    <div class="col-md-8">
                        <input type="text" name="offerNameAr" dir="rtl" class="form-control required" id="offerNameAr" <?php echo isset($offer) ? 'value="' . stripslashes(($offer->offerNameAr)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="offerCategory">Offer Category</label>
                    <div class="col-md-8">
                    <?php
                            $cat=[];
                            if (isset($restoffercategory)) {
                                $cat = array();
                                foreach ($restoffercategory as $val) {
                                    $cat[] = $val->categoryID;
                                }
                            }
                    
                            ?>
                        <select class=" form-control required" multiple="multiple" tabindex="7" data-placeholder="Select Offer Category" name="offerCategory[]" id="offerCategory">
                        <?php
                            if (count($offercategories) > 0) {
                                foreach ($offercategories as $category) {
                            ?>
                                    <option value="<?php echo $category->id; ?>" <?php
                                                                                    if (isset($cat)) {
                                                                                        if (in_array($category->id, $cat))
                                                                                            echo "selected";
                                                                                    };
                                                                                    ?>>
                                        <?php echo stripslashes(($category->categoryName)); ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="restBranches">Restaurant Branches</label>
                    <div class="col-md-8">
                        <select multiple class=" form-control required" tabindex="7" data-placeholder="Select Branches" name="restBranches[]" id="restBranches">
                            <?php
                            if (isset($restofferbranches)) {
                                $br = array();
                                if (count($restofferbranches) > 0) {
                                    foreach ($restofferbranches as $val) {
                                        $br[] = $val->branchID;
                                    }
                                }
                            } else {
                                $br = 0;
                            }
                            ?>
                            <option value="all" <?php if ((count($br) == 1) && ($br[0] == 0)) echo "selected='selected'"; ?>>All Branches</option>
                            <?php
                            if (count($restbranches) > 0) {
                                foreach ($restbranches as $branch) {
                            ?>
                                    <option value="<?php echo $branch->br_id; ?>" <?php
                                                                                    if (isset($restofferbranches)) {
                                                                                        if (in_array($branch->br_id, $br))
                                                                                            echo "selected='selected'";
                                                                                    }
                                                                                    ?>><?php echo stripslashes(($branch->br_loc)); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="startDate">Date</label>
                    <div class="col-md-8">
                        <input class="form-control input-form required" autocomplete="off" required type="text" name="startDate" id="start-date1" placeholder="Starting Date" <?php echo isset($offer) ? 'value="' . $offer->startDate . '"' : ""; ?> />
                        <input class="form-control input-form required" autocomplete="off" required type="text" name="endDate" id="end-date1" placeholder="End Date" <?php echo isset($offer) ? 'value="' . $offer->endDate . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="startTime">Time</label>
                    <div class="col-md-8">

                        <select class="form-control " name="startTime" id="startTime">
                            <option value="">Select Start Time</option>
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
                                        if (isset($offer->startTime) and $offer->startTime == $act_time) {
                                            echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                        } else {
                                            echo "<option value='$act_time'>$act_time</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                        <select name="endTime" class="form-control ">
                            <option value="">Select End Time</option>
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
                                        if (isset($offer->endTime) and $offer->endTime == $act_time) {
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
                    <label class="col-md-3 col-lg-2 control-label" for="shortDesc">Short Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="shortDesc" id="shortDesc" rows="5" placeholder="Short Description"><?php echo isset($offer) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $offer->shortDesc) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="shortDescAr">Short Description Arabic</label>
                    <div class="col-md-8">
                        <textarea class="form-control" dir="rtl" name="shortDescAr" id="shortDescAr" rows="5" placeholder="Short Description Arabic"><?php echo isset($offer) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $offer->shortDescAr) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="image">
                        Image
                        <span class="small-text">(640*any)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" />
                        <?php
                        if (isset($offer) && !empty($offer->image)) {
                        ?>
                            <input type="hidden" name="image_old" value="<?php echo $offer->image; ?>" />
                            <img src="<?php echo Config::get('settings.uploadurl') . 'images/offers/thumb/' . $offer->image; ?>" />
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="imageAr">
                        Image Arabic
                        <span class="small-text">(640*any)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="file" name="imageAr" id="imageAr" />
                        <?php
                        if (isset($offer) && !empty($offer->imageAr)) {
                        ?>
                            <input type="hidden" name="imageAr_old" value="<?php echo $offer->imageAr; ?>" />
                            <img src="<?php echo Config::get('settings.uploadurl') . 'images/offers/thumb/' . $offer->imageAr; ?>" />
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="terms">Terms &amp; Conditions</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="terms" id="terms" rows="5" placeholder="Terms &amp; Conditions"><?php echo isset($offer) ? $offer->terms : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="terms">Terms &amp; Conditions Arabic</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="termsAr" id="termsAr" rows="5" placeholder="Terms &amp; Conditions"><?php echo isset($offer) ? $offer->termsAr : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="contactEmail">Contact Email</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="contactEmail" id="contactEmail" placeholder="Contact Email" <?php echo isset($offer) ? 'value="' . $offer->contactEmail . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="contactPhone">Contact Number</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="contactPhone" id="contactPhone" placeholder="Contact Number" <?php echo isset($offer) ? 'value="' . $offer->contactPhone . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="redeemurl">Redeem Link</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="redeemurl" id="redeemurl" placeholder="Redeem Link" <?php echo isset($offer) ? 'value="' . $offer->redeemurl . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 control-label" for="rest_Status">Publish</label>
                    <div class="col-md-8">
                        <input type="checkbox" name="status" value="1" checked="checked" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-3">
                        <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>" />
                        <?php
                        if (isset($offer)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $offer->id; ?>" />
                        <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save &amp; Upload" class="btn btn-primary-gradien" />
                        <a href="<?php
                                    if (isset($_SERVER['HTTP_REFERER'])) {
                                        echo $_SERVER['HTTP_REFERER'];
                                    } else {
                                        echo URL::to('adminrestoffer');
                                    }
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


$(document).ready(function() {
    var editor_details = CKEDITOR.replace('terms');
    CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
    var editor_details_ar = CKEDITOR.replace('termsAr');
    CKFinder.setupCKEditor(editor_details_ar, base + '/js/ckfinder/');
});
</script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.en.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.custom.js"></script>
<script>
    $(document).ready(function() {
        $('#start-date1').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd'
        });
        $('#end-date1').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
        });

    });
</script>

@endsection