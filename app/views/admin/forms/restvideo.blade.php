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
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestaurants/videosave'); }}" method="post" enctype="multipart/form-data">

            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="name_en">Video Title</label>
                    <div class="col-md-8">
                        <input class="required form-control" type="text" name="name_en" id="name_en" placeholder="Title" <?php echo isset($video) ? 'value="' . stripslashes(($video->name_en)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="name_ar">Video Title Arabic</label>
                    <div class="col-md-8">
                        <input class="required form-control" type="text" name="name_ar" id="name_ar" placeholder="Title Arabic" <?php echo isset($video) ? 'value="' . stripslashes(($video->name_ar)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="youtube_en">Youtube Link</label>
                    <div class="col-md-8">
                        <input class="required form-control" type="text" name="youtube_en" id="youtube_en" placeholder="Youtube Link" <?php echo isset($video) ? 'value="' . $video->youtube_en . '"' : ""; ?> />
                        <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="youtube_ar">Youtube Link Arabic</label>
                    <div class="col-md-8">
                        <input class="required form-control" type="text" name="youtube_ar" id="youtube_ar" placeholder="Youtube Link Arabic" <?php echo isset($video) ? 'value="' . $video->youtube_ar . '"' : ""; ?> />
                        <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="video_description"> Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="video_description" id="video_description" rows="5" placeholder="Video Description"><?php echo isset($video) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $video->video_description) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="shortDescAr"> Description Arabic</label>
                    <div class="col-md-8">
                        <textarea class="form-control" dir="rtl" name="video_description_ar" id="video_description_ar" rows="5" placeholder="Video Description Arabic"><?php echo isset($video) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $video->video_description_ar) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="video_tags">Video Tags</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="video_tags" id="video_tags" placeholder="Video Tags" <?php echo isset($video) ? 'value="' . stripslashes(($video->video_tags)) . '"' : ""; ?> />

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="video_tags_ar">Video Tags Arabic</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="video_tags_ar" id="video_tags_ar" placeholder="Video Tags Arabic" <?php echo isset($video) ? 'value="' . stripslashes(($video->video_tags_ar)) . '"' : ""; ?> />

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3  col-lg-2 control-label" for="rest_Status">Publish</label>
                    <div class="col-md-8">
                        <input type="checkbox" <?php if (!isset($video->status) || $video->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8 offset-md-3">
                        <?php if (isset($rest)) { ?>
                            <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                        <?php } else { ?>
                            <input type="hidden" name="rest_ID" value="0"/>
                        <?php } ?>
                        <?php if (isset($video)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $video->id; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER']))
                            echo $_SERVER['HTTP_REFERER'];
                        else
                            echo route('adminrestaurants');
                        ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>


@endsection