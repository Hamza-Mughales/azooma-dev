@extends('admin.index')
@section('content')
    
<div class="overflow">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
</div>


<?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <article>
        <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestaurants/savemember/', $rest->rest_ID); ?>" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo $pagetitle; ?></legend>
                <p>
                    Restaurant Name
                    <b><?php echo isset($rest) ? stripslashes($rest->rest_Name) : ""; ?></b>
</p>
                <div class="row">
                <div class="col-lg-6 left">
                    <legend>Account Details</legend>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="rest_Subscription"> Account Type</label>
                        <div class="col-lg-5">Free</div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="member_duration"> Member Duration</label>
                        <div class="col-lg-5">2 Months</div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="price"> Membership Price</label>
                        <div class="col-lg-5 Azooma-backend-input-seperator">Free</div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="member_date"> Account Start Date</label>
                        <div class="col-lg-5 Azooma-backend-input-seperator">
                            <input class="form-control" type="text" name="member_date" id="member_date" placeholder="Account Start Date" value="<?php
                            if (isset($rest) && !empty($rest->member_date) && $memberFlag) {
                                echo $rest->member_date;
                            } else {
                                echo date('Y-m-d');
                            }
                            ?>" />
                        </div>
                    </div>
                    <legend>Contact Person Info/Administrator</legend>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="full_name"> Contact Person</label>
                        <div class="col-lg-7">
                            <input class="form-control" type="text" name="full_name" id="full_name" placeholder="Contact Person Name" <?php echo isset($rest) ? 'value="' . $rest->your_Name . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="phone"> Contact Number</label>
                        <div class="col-lg-7">
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="Contact Number" <?php echo isset($rest) ? 'value="' . $rest->your_Contact . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="email"> Contact Emails</label>
                        <div class="col-lg-7 Azooma-backend-input-seperator" id="memberemails">
                            <?php
                            if (isset($member)) {
                                $memberemails = explode(',', $member->email);
                                for ($i = 0; $i < count($memberemails); $i++) {
                                    ?>
                                    <div id="input-<?php echo $i; ?>">
                                        <input class="form-control" type="text" name="emails[]"  placeholder="Contact Email" <?php echo isset($memberemails) ? 'value="' . $memberemails[$i] . '"' : ""; ?> />
                                        <a class="close Azooma-close" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div id="input-0">
                                    <input class="form-control" type="text" <?php echo isset($rest) ? 'value="' . $rest->your_Email . '"' : ""; ?> name="emails[]"  placeholder="Contact Email" />
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row ">
                    <div class=" col-lg-5" for="phone"></div>

                        <div class="col-md-6">
                            <a href="javascript:void(0)" class="btn btn-primary" onclick="addmoreEmails();"><i class="icon-plus-sign icon-white"></i> Add another email</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-5" for="preferredlang"> Preferred Language</label>
                        <div class="col-lg-7">
                            <select name="preferredlang" id="preferredlang" class="form-control">
                                <option value="0" <?php
                                if (isset($member)) {
                                    if ($member->preferredlang == 0)
                                        echo 'selected="selected"';
                                }
                                ?>>English</option>
                                <option value="1" <?php
                                if (isset($member)) {
                                    if ($member->preferredlang == 1)
                                        echo 'selected="selected"';
                                }
                                ?>>Arabic</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row text-center mt-4">
                  

                        <div class="col-md-12">
                            <input type="hidden" name="rest_Subscription" value="0"/>
                            <?php
                            if (isset($rest)) {
                                ?>
                                <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                                <input type="hidden" name="rest_Name" value="<?php echo stripslashes($rest->rest_Name); ?>"/>
                                <?php
                            }
                            ?>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER']))
                                echo $_SERVER['HTTP_REFERER'];
                            else
                                echo route('adminrestaurants');
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a> </div>
                    </div>
                </div>
                <div id="permissions" class="right col-lg-6 ">
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> <strong>Features</strong></label>
                        <div class="col-md-6 Azooma-backend-input-seperator"> <strong>Select Features</strong> </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Profile Page</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" checked="checked" disabled="disabled"   name="editfeatures[]"  value="1" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Branch Management</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" checked="checked" disabled="disabled" name="editfeatures[]"  value="2" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Sample Menu</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="3" checked="checked" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Full Menu + PDF</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="4" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Photo Gallery (3 Photos)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox"   name="editfeatures[]"  value="6" checked="checked" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Photo Gallery (6 Photos)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox"  name="editfeatures[]"  value="7" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Photo Gallery (12 Photos)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox"  name="editfeatures[]"  value="8" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Photo Gallery (20 Photos)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="9" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> News Feed</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="16" disabled="disabled" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Special Offer (1 Offer)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="10" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Special Offer (3 Offers)</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="11" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Fan Club</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="17" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Comments Response</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="14" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Video Gallery</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="15" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Polls</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="13" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-6" for=""> Booking</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input type="checkbox" name="editfeatures[]"  value="12" disabled="disabled"/>
                        </div>
                    </div>
                </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>

<script type="text/javascript">
<?php
if (isset($member)) {
    if ($member['email'] != "") {
        ?>
            counter =<?php echo count($memberemails); ?>;
        <?php
    } else {
        ?>
            counter = 2;
        <?php
    }
} else {
    ?>
        counter = 2;
    <?php
}
?>
    $("#memberForm").validate({
        rules: {
            "emails[]": {required: true, email: true},
            full_name: "required",
            phone: "required"
        }
    });

    $(document).ready(function() {
        $("#member_date").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<style>
    .form-control {
width: auto;
}
</style>

@endsection
