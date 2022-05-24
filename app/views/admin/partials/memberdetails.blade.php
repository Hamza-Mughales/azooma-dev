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
<link rel="stylesheet" type="text/css" href="<?php echo asset(css_path()); ?>/date-picker.css">

<div class="well-white">
    <article>
        <form name="memberForm" id="memberForm" class="form-horizontal" role="form" action="{{ route('adminmembers/savedetails'); }}" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="row" >
                <div class="col-md-6" >
                    <div class="form-group row">
                    
                        <label class="control-label col-md-4" for="rest_Subscription"> Account Type</label>
                        <div class="col-md-7 Azooma-backend-input-seperator">
                            <select class="form-control" name="rest_Subscription" id="rest_Subscription" class="required" onchange="selectPermissions();">
                                <option value="0">Select Membership Type</option>
                                <option value="0" <?php
                                if (isset($rest)) {
                                    if ($rest->rest_Subscription == 0) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>Free</option>
                                <option value="2" <?php
                                if (isset($rest)) {
                                    if ($rest->rest_Subscription == 2) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>Silver</option>
                                <option value="3" <?php
                                if (isset($rest)) {
                                    if ($rest->rest_Subscription == 3) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>Gold</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="member_duration"> Member Duration</label>
                        <div class="col-md-7 Azooma-backend-input-seperator">
                            <select class="form-control" name="member_duration" id="member_duration" class="required">
                                <option>Select Membership Duration</option>
                                <option value="0" <?php
                                if (isset($rest)) {
                                    if ($rest->member_duration == 0) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>Unlimited - Free Member</option>
                                <!-- <option value="3" <?php
                                if (isset($rest)) {
                                    if ($rest->member_duration == 3) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>3 Months</option>
                                <option value="6" <?php
                                if (isset($rest)) {
                                    if ($rest->member_duration == 6) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>6 Months</option> -->
                                <option value="12" <?php
                                if (isset($rest)) {
                                    if ($rest->member_duration == 12) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>1 Year</option>
                                <!--  <option value="24" <?php
                                if (isset($rest)) {
                                    if ($rest->member_duration == 24) {
                                        echo 'selected="selected"';
                                    }
                                }
                                ?>>2 Year</option> -->
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6" >
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="price"> Membership Price</label>
                        <div class="col-md-7 Azooma-backend-input-seperator">
                            <input class="form-control auto-width" type="text" name="price" id="price" placeholder="Membership Price" <?php echo isset($member) ? 'value="' . $member->price . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="member_date"> Account Start Date</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input class="form-control auto-width" type="text" name="member_date" id="member_date" placeholder="Account Start Date" <?php echo isset($rest) ? 'value="' . $rest->member_date . '"' : ""; ?> />
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6" >
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="member_date"> Account Update Date</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <?php
                            if (isset($member)) {
                                if (!empty($member->date_upd)) {
                                    echo $member->date_upd;
                                } else {
                                    echo date("d/m/Y", strtotime($member->date_add));
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="preferredlang"> Preferred Language</label>
                        <div class="col-md-7 Azooma-backend-input-seperator">
                            <select class="form-control" name="preferredlang" id="preferredlang">
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
                                ?>>English</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4" for="member_date"> Messages</label>
                        <div class="col-md-6 Azooma-backend-input-seperator">
                            <input class="form-control" type="text" name="allowed_messages" id="allowed_messages" placeholder="Allowed Messages 10" <?php echo isset($member) ? 'value="' . $member->allowed_messages . '"' : ""; ?> />
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12" >
                    <div id="permissions">
                        <?php echo $permission; ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <?php if (isset($member)) {
                                ?>
                                <input type="hidden" name="rest_ID" value="<?php echo $member->rest_id; ?>"/>
                                <input type="hidden" name="id" value="<?php echo $member->sub_id; ?>"/>
                                <input type="hidden" name="id_user" value="<?php echo $member->id_user; ?>"/>
                                <?php
                            }
                            ?>
                            <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER']))
                                echo $_SERVER['HTTP_REFERER'];
                            else
                                echo route('adminmembers');
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                        </div>
                    </div>
                    </div>
                    </div>
                <div class=" col-md-6">
                    <?php
                    $logs = $MGeneral->getMemberDeatilsLog($member->rest_id);
                    if (count($logs) > 0) {
                        ?>
                        <legend>Membership Log</legend>
                        <table class="table table-bordered table-striped Azooma-backend-table" > 
                            <thead> 
                                <tr>                                    
                                    <th style="width:65px;"> Reference No </th> 
                                    <th style="width:65px;"> Price </th> 
                                    <th style="width:65px;"> Date </th> 
                                </tr>
                            </thead> 
                            <tbody>
                                <?php
                                if (is_array($logs)) {
                                    foreach ($logs as $value) {
                                        ?>
                                        <tr> 
                                            <td> <?php echo $value->referenceNo; ?> </td>                                     
                                            <td> <?php echo $value->price; ?> </td>                                     
                                            <td> <?php echo date("d/m/Y", strtotime($value->date_add)); ?> </td> 
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="3">no recored!</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                </div>
               
            </fieldset>
        </form>
    </article>
</div>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.en.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.custom.js"></script>
<script>
    $(document).ready(function() {
        $('#member_date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd'
        });
 

    });
</script>

<style>
    .Azooma-backend-input-seperator input, .Azooma-backend-input-seperator select {
        width: 315px;
    }
</style>

@endsection