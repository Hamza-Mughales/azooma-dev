@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminrestaurants'); ?>">All Restaurants</a></li>  
    <li class="active">{{ $title }}</li>
</ol>




<?php
include(app_path() . '/views/admin/common/restaurant.blade.php');
?>

<div class="well-white">
    <article>
        <form name="restMainForm" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestaurants/branches/imagesave'); }}" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Branch Location Information</legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="title">Branch Name</label>
                    <div class="col-md-6">
                        <p><?php echo $rest->rest_Name . ' - ' . $branch->br_loc; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="title">Image Title</label>
                    <div class="col-md-8">
                        <input class="form-control required" type="text" name="title" id="title" placeholder="Image Title" value="<?php echo isset($branchimage) ? stripslashes(($branchimage->title))  : old('title') ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="title_ar">Image Title Arabic</label>
                    <div class="col-md-8">
                        <input class="form-control required" type="text" name="title_ar" id="title_ar" placeholder="Image Title Arabic" value="<?php echo isset($branchimage) ? stripslashes(($branchimage->title_ar)) : old("title_ar") ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="branch_image">
                        Branch Image
                        <br>
                        <span class="small-font">Size: (800*500)</span>
                    </label>
                    <div class="col-md-6">
                        <input type="file" id="branch_image" name="branch_image" class="<?=isset($branchimage->image_full) ? "":"required"?> file">
                        <?php
                        if (isset($branchimage)) {
                            ?>
                            <input type="hidden" name="branch_image_old" value="<?php echo $branchimage->image_full; ?>"/>
                            <?php if ($branchimage->image_full != "") { ?>
                                <img src="<?php echo Config::get('settings.uploadurl'); ?>/Gallery/thumb/<?php echo $branchimage->image_full; ?>" width="100"/>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($branchimage->status) || $branchimage->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-2">
                        <?php
                        if (isset($branchimage)) {
                            ?>
                            <input type="hidden" name="image_ID" id="image_ID" value="<?php echo $branchimage->image_ID; ?>">
                        <?php } ?>
                        <input type="hidden" name="rest_fk_id" id="rest_fk_id" value="<?php echo $rest->rest_ID; ?>">
                        <input type="hidden" name="br_id" id="br_id" value="<?php echo $branch->br_id; ?>">
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            echo $_SERVER['HTTP_REFERER'];
                        } else {
                            echo route('adminrestaurants');
                        }
                        ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>



<script type="text/javascript">
    $("#restMainForm").validate();
    
</script>

@endsection