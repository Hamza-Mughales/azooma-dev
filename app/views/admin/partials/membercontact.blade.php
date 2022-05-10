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
        <form name="restMainForm" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminmembers/savecontacts'); }}" method="post" enctype="multipart/form-data">
            <legend>{{$pagetitle}}</legend>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="full_name"> Contact Person</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" required name="full_name" id="full_name" placeholder="Contact Person Name" <?php echo isset($member) ? 'value="' . $member->full_name . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="phone"> Contact Number</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" required name="phone" id="phone" placeholder="Contact Number" <?php echo isset($member) ? 'value="' . $member->phone . '"' : ""; ?> />
                </div>
            </div>
            <div id="memberemails">
               
                        <?php
                        if (isset($member)) {
                            $memberemails = explode(',', $member['email']);
                            for ($i = 0; $i < count($memberemails); $i++) {
                        ?>
                             <div class="row my-2">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                     <input class="form-control" value="<?php echo isset($memberemails) ? $memberemails[$i] : ""; ?>" type="email" name="emails[]" placeholder="Contact Email" required />
                                </div>
                                <div class="col-6">
                                    <a class="btn mt-2 btn-danger email-remove py-0 px-1" href="javascript:void(0);">&times;</a>
                                </div>
                            </div>

                            <?php
                            }
                        } else {
                            ?>
                            <div class="row my-2">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                     <input class="form-control" type="email" name="emails[]" placeholder="Contact Email" required />
                                </div>
                                <div class="col-6">
                                    <a class="btn mt-2 btn-danger email-remove py-0 px-1" href="javascript:void(0);">&times;</a>
                                </div>
                            </div>
                        <?php } ?>
           
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for=""> </label>
                <div class="col-md-6">
                    <a href="javascript:void(0)" class="btn btn-info" onclick="addMoreEmail();"><i class="icon-plus-sign icon-white"></i> Add another email</a>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="preferredlang"> Preferred Language</label>
                <div class="col-md-6">
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
                                            ?>>English</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="status">Publish</label>
                <div class="col-md-6">
                    <input type="checkbox" <?php if (!isset($member->status) || $member->status == 1) echo 'checked="checked"'; ?> name="status" value="1" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 offset-md-2">
                    <?php if (isset($member)) {
                    ?>
                        <input type="hidden" name="rest_ID" value="<?php echo $member->rest_id; ?>" />
                        <input type="hidden" name="id_user" value="<?php echo $member->id_user; ?>" />
                    <?php
                    }
                    ?>
                    <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien" />
                    <a href="<?php
                                if (isset($_SERVER['HTTP_REFERER']))
                                    echo $_SERVER['HTTP_REFERER'];
                                else
                                    echo route('adminmembers');
                                ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                </div>
            </div>
        </form>
    </article>
</div>


<script type="text/javascript">
    <?php
    if (isset($member)) {
        if ($member['email'] != "") {
    ?>
            counter = <?php echo count($memberemails); ?>;
        <?php
        } else {
        ?>
            counter = 2;
    <?php
        }
    }
    ?>


    function addMoreEmail() {
        var html = '   <div class="row my-2" ><div class="col-md-2"></div><div class="col-md-4">' +
            ' <input class="form-control" type="email" name="emails[]" placeholder="Contact Email" required />' +
            ' </div>' +
            '<div class="col-6">' +
            '<a class="btn mt-2 btn-danger email-remove py-0 px-1" href="javascript:void(0);" >&times;</a>' +
            '</div></div>';

        $("#memberemails").append(html);

    }
    $('body').on('click', '.email-remove', function() {

        $(this).parent().parent().remove();
    });
    $('body').on('click', '.e-close', function() {

        $(this).parent().remove();
    });
</script>
@endsection