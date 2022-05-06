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
                    <input class="form-control" type="text" name="full_name" id="full_name" placeholder="Contact Person Name" <?php echo isset($member) ? 'value="' . $member->full_name . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="phone"> Contact Number</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="phone" id="phone" placeholder="Contact Number" <?php echo isset($member) ? 'value="' . $member->phone . '"' : ""; ?> />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for="email"> Contact Emails</label>
                <div class="col-md-6 sufrati-backend-input-seperator" id="memberemails">
                    <?php
                    if (isset($member)) {
                        $memberemails = explode(',', $member['email']);
                        for ($i = 0; $i < count($memberemails); $i++) {
                            ?>
                            <div id="input-<?php echo $i; ?>">
                                <input class="form-control" type="text" name="emails[]"  placeholder="Contact Email" <?php echo isset($memberemails) ? 'value="' . $memberemails[$i] . '"' : ""; ?> />
                                <?php
                                if ($i == 0) {
                                    
                                } else {
                                    ?>
                                    <a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div id="input-0">
                            <input class="form-control" type="text" name="emails[]"  placeholder="Contact Email" />
                        </div>
                        <div id="input-1">
                            <input class="form-control" type="text" name="emails[]"  placeholder="Contact Email" />
                            <a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-1">&times;</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label" for=""> </label>
                <div class="col-md-6">
                    <a href="javascript:void(0)" class="btn btn-info" onclick="addmoreEmails();"><i class="icon-plus-sign icon-white"></i> Add another email</a>
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
                    <input type="checkbox" <?php if (!isset($member->status) || $member->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 offset-md-2">
                    <?php if (isset($member)) {
                        ?>
                        <input type="hidden" name="rest_ID" value="<?php echo $member->rest_id; ?>"/>
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
}
?>
    $("#memberForm").validate({
        rules: {
            "emails[]": {required: true, email: true},
            full_name: "required",
            phone: "required"
        }
    });
</script>
<?php
//echo HTML::script('js/admin/restform.js');
?>

@endsection