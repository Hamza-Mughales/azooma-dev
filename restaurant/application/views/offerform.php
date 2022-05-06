<style>
    .input-form {
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .25rem;
        -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(css_path()); ?>/date-picker.css">

<?php
echo message_box('error');
echo message_box('success');
?>
<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('offers'); ?>"><?=lang('special_offers')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('offer')?> </li>
    </ul>
</div>
<section class="card">



    <div class="card-body">
        <h4>

            <?php echo ($pagetitle); ?>
        </h4>
        <div id="results">


            <form id="offerForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('offers/save'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="offerName"><?=lang('offer_name')?> </label>
                            <div class="col-md-12">
                                <input type="text" name="offerName" class="form-control" required id="offerName" placeholder="<?=lang('offer_name')?>" <?php echo isset($offer) ? 'value="' . (htmlspecialchars($offer['offerName'])) . '"' : ""; ?> />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="offerNameAr"><?=lang('offer_name_ar')?></label>
                            <div class="col-md-12">
                                <input type="text" name="offerNameAr" dir="rtl" class="form-control" required id="offerNameAr" placeholder="<?=lang('offer_name_ar')?>" <?php echo isset($offer) ? 'value="' . (htmlspecialchars($offer['offerNameAr'])) . '"' : ""; ?> />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="offerCategory"><?=lang('offer_cat')?></label>
                            <div class="col-md-12">
                                <select multiple class="form-control select2" required tabindex="7" style="width: 350px;" data-placeholder="Select Offer Category" name="offerCategory[]" id="offerCategory">
                                    <?php
                                    if (isset($restoffercategory))
                                        $cat = array();
                                    foreach ($restoffercategory as $val) {
                                        $cat[] = $val['categoryID'];
                                    }
                                    if (count($offercategories) > 0) {
                                        foreach ($offercategories as $category) {
                                    ?>
                                            <option value="<?php echo $category['id']; ?>" <?php if (isset($cat)) {
                                                                                                if (in_array($category['id'], $cat)) echo "selected='selected'";
                                                                                            }; ?>>
                                                <?php echo ($category['categoryName']); ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="restBranches"><?=lang('rest_barnch')?></label>
                            <div class="col-md-12">
                                <select multiple class="form-control select2" required tabindex="7" style="width: 350px;" data-placeholder="Select Branches" name="restBranches[]" id="restBranches">
                                    <?php
                                    if (isset($restofferbranches)) {
                                        $br = array();
                                        if (count($restofferbranches) > 0) {
                                            foreach ($restofferbranches as $val) {
                                                $br[] = $val['branchID'];
                                            }
                                        }
                                    } else {
                                        $br = 0;
                                    }
                                    ?>
                                    <option value="all" <?php if ((count($br) == 1) && ($br[0] == 0)) echo "selected='selected'"; ?>><?=lang('all_branches')?></option>
                                    <?php
                                    if (count($restbranches) > 0) {
                                        foreach ($restbranches as $branch) {
                                    ?>
                                            <option value="<?php echo $branch['br_id']; ?>" <?php if (isset($restofferbranches)) {
                                                                                                if (in_array($branch['br_id'], $br)) echo "selected='selected'";
                                                                                            } ?>><?php echo ($branch['br_loc']); ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="startDate"><?=lang('date')?></label>
                            <div class="col-md-12">
                                <input class="input-form" required type="text" autocomplete="off" name="startDate" id="startDate" placeholder="<?=lang('starting_date')?>" <?php echo isset($offer) ? 'value="' . $offer['startDate'] . '"' : ""; ?> />
                                <input class="input-form" required type="text" autocomplete="off" name="endDate" id="endDate" placeholder="<?=lang('end_date')?>" <?php echo isset($offer) ? 'value="' . $offer['endDate'] . '"' : ""; ?> />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="startTime"><?=lang('Time')?></label>
                            <div class="col-md-12">

                                <select class="input-form" name="startTime" id="startTime">
                                    <option value=""><?=lang('select_start_time')?></option>
                                    <?php for ($i = 0; $i <= 24; $i++) {
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
                                                if (isset($offer['startTime']) and $offer['startTime'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    } ?>
                                </select>
                                <select name="endTime" class="input-form">
                                    <option value=""><?=lang('select_end_time')?></option>
                                    <?php for ($i = 0; $i <= 24; $i++) {
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
                                                if (isset($offer['endTime']) and $offer['endTime'] == $act_time) {
                                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                                } else {
                                                    echo "<option value='$act_time'>$act_time</option>";
                                                }
                                            }
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="shortDesc"><?=lang('short_description')?></label>
                            <div class="col-md-12">
                                <textarea name="shortDesc" class="form-control" id="shortDesc" rows="5" placeholder="<?=lang('short_description')?>"><?php echo isset($offer) ? ($offer['shortDesc']) : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="shortDescAr"><?=lang('short_description_ar')?></label>
                            <div class="col-md-12">
                                <textarea dir="rtl" class="form-control" name="shortDescAr" id="shortDescAr" rows="5" placeholder="<?=lang('short_description_ar')?>"><?php echo isset($offer) ? ($offer['shortDescAr']) : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="image"><?=lang('image')?>
                                <br />
                                <span class="small-font"><?=lang('img_size')?>: (200*200)</span>
                            </label>
                            <div class="col-md-12">
                                <input class="form-control" type="file" name="image" id="image" />
                                <?php
                                if (isset($offer)) {
                                ?>
                                    <input type="hidden" name="image_old" value="<?php echo $offer['image']; ?>" />
                                    <img style="max-width:400px" src="<?=app_files_url().offer_files_path()?><?php echo $offer['image']; ?>" />
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="control-label col-md-12" for="imageAr"><?=lang('image_ar')?> 
                                <br />
                                <span class="small-font"><?=lang('img_size')?>: (200*200)</span>
                            </label>
                            <div class="col-md-12">
                                <input class="form-control" type="file" name="imageAr" id="imageAr" />
                                <?php
                                if (isset($offer)) {
                                ?>
                                    <input type="hidden" name="imageAr_old" value="<?php echo $offer['imageAr']; ?>" />
                                    <img style="max-width:400px" src="<?=app_files_url().offer_files_path()?><?php echo $offer['imageAr']; ?>" />
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="longDesc"><?=lang('main_desc')?></label>
                            <div class="col-md-12">
                                <textarea class="form-control" name="longDesc" id="longDesc" rows="5" placeholder="<?=lang('main_desc')?>"><?php echo isset($offer) ? $offer['longDesc'] : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="longDescAr"><?=lang('main_desc_ar')?></label>
                            <div class="col-md-12">
                                <textarea dir="rtl" class="form-control" name="longDescAr" id="longDescAr" rows="5" placeholder="<?=lang('main_desc_ar')?>"><?php echo isset($offer) ? $offer['longDescAr'] : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="terms"><?=lang('terms_condition')?></label>
                            <div class="col-md-12">
                                <textarea name="terms" id="terms" class="form-control" rows="5" placeholder="<?=lang('terms_condition')?>"><?php echo isset($offer) ? $offer['terms'] : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="terms"><?=lang('terms_condition_ar')?></label>
                            <div class="col-md-12">
                                <textarea name="termsAr" id="termsAr" class="form-control" rows="5" placeholder="<?=lang('terms_condition')?>"><?php echo isset($offer) ? $offer['termsAr'] : ""; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="contactEmail"><?=lang('contact_email')?></label>
                            <div class="col-md-12">
                                <input type="text" name="contactEmail" class="form-control" id="contactEmail" placeholder="<?=lang('contact_email')?>" <?php echo isset($offer) ? 'value="' . $offer['contactEmail'] . '"' : ""; ?> />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="contactPhone"><?=lang('contact_number')?></label>
                            <div class="col-md-12">
                                <input type="text" name="contactPhone" class="form-control" id="contactPhone" placeholder="<?=lang('contact_number')?>" <?php echo isset($offer) ? 'value="' . $offer['contactPhone'] . '"' : ""; ?> />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-md-2" for="rest_Status"><?=lang('publish')?></label>
                    <div class="col-md-9">
                        <input type="checkbox" name="status" value="1" checked="checked" />
                    </div>
                </div>

                <div class="form-group row text-end">
                    <div class="col-md-12">
                        <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                        <?php
                        if (isset($offer)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $offer['id']; ?>" />
                        <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="<?=lang('save_upload')?>" class="btn btn-danger" />
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                    else echo base_url('hungryn137/menu'); ?>" class="btn btn-light" title="Cancel Changes"><?=lang('cancel')?></a>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
                $(document).ready(function() {
                   

                $("#offerForm").validate();

                CKEDITOR_BASEPATH = '<?php echo base_url(); ?>js/admin/ckeditor/';
                var editor1 = CKEDITOR.replace('longDesc', {
                    toolbar: 'MyToolbar',
                    width: '640px',
                    height: '200px',
                    forcePasteAsPlainText: true,
                    filebrowserBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
                var editor2 = CKEDITOR.replace('longDescAr', {
                    toolbar: 'MyToolbar',
                    width: '640px',
                    height: '200px',
                    forcePasteAsPlainText: true,
                    filebrowserBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
                var editor3 = CKEDITOR.replace('terms', {
                    toolbar: 'MyToolbar',
                    width: '640px',
                    height: '200px',
                    forcePasteAsPlainText: true,
                    filebrowserBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
                var editor3 = CKEDITOR.replace('termsAr', {
                    toolbar: 'MyToolbar',
                    width: '640px',
                    height: '200px',
                    forcePasteAsPlainText: true,
                    filebrowserBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '<?php echo base_url(); ?>js/admin/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '<?php echo base_url(); ?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
            </script>

        </div>

    </div>
</section>
<script>
    $(document).ready(function() {
        $(".select2").select2();
        $('#startDate').datepicker({ language: 'en',dateFormat: 'yyyy-mm-dd'});
        $('#endDate').datepicker({ language: 'en',dateFormat: 'yyyy-mm-dd',});
        
    });
    </script>
 <script src="<?=base_url(js_path())?>date-picker/datepicker.js"></script>
    <script src="<?=base_url(js_path())?>date-picker/datepicker.en.js"></script>
    <script src="<?=base_url(js_path())?>date-picker/datepicker.custom.js"></script>