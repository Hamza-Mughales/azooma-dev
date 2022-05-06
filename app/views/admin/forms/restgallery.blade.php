@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminrestgallery/', $rest_ID); ?>"> <?php echo stripslashes($rest->rest_Name); ?> Gallery </a></li>
    <li class="active">{{ $title }}</li>
</ol>



<div class="well-white">
    <?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
    ?>
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestgallery/save'); }}" method="post" enctype="multipart/form-data">
            <legend>Uploading Image</legend>
            <div class="form-group row">
                <label for="title" class="col-md-3 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="title" class="form-control required" value="{{ isset($image) ? $image->title : Input::old('title') }}" id="title" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="title_ar" class="col-md-3 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="title_ar" class="form-control required"  value="{{ isset($image) ? $image->title_ar : Input::old('title_ar') }}" id="title_ar" dir="rtl">
                </div>
            </div>
            <div class="form-group row">
                <label for="rest_Logo" class="col-md-3 control-label">Image</label>
                <div class="col-md-6">
                    <input type="file" id="image_full" name="image_full">
                    <?php
                    if (isset($image)) {
                        if (!empty($image->image_full)) {
                            ?>
                            <img src="<?php echo Config::get('settings.uploadurl').'Gallery/thumb/' . $image->image_full; ?>">
                            <input type="hidden" value="<?php echo $image->image_full; ?>" name="image_full_old">
                            <input type="hidden" value="<?php echo $image->ratio; ?>" name="ratio_old">
                            <input type="hidden" value="<?php echo $image->width; ?>" name="width_old">
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-md-3 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($image) ? ($image->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($image)) {
                        ?>
                        <input type="hidden" name="image_ID"  value="{{ isset($image) ? $image->image_ID : 0 }}" id="image_ID" >
                        <?php
                    }
                    ?>
                    <input type="hidden" name="rest_ID"  value="{{ isset($rest) ? $rest->rest_ID : 0 }}" id="rest_ID" >
                </div>
            </div>
        </form>
    </article>
</div>

@endsection