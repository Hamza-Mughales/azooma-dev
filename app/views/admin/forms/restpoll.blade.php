@extends('admin.index')
@section('content')

<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>
    <li><a href="<?php echo URL::to('hungryn137/' . $action); ?>">
            <?php
            if (isset($rest)) {
                echo stripslashes($rest->rest_Name);
            }
            ?> Polls </a></li>
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
    ?>
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ URL::to('hungryn137/'.$saveurl); }}" method="post" enctype="multipart/form-data">

            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="question">Poll Question</label>
                    <div class="col-md-7">
                        <input class="form-control required" type="text" name="question" id="question" placeholder="Poll Question" <?php echo isset($poll) ? 'value="' . stripslashes(($poll->question)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="question_ar">Poll Question Arabic</label>
                    <div class="col-md-7">
                        <input class="form-control required" dir="rtl" type="text" name="question_ar" id="question_ar" placeholder="Poll Question Arabic" <?php echo isset($poll) ? 'value="' . stripslashes(($poll->question_ar)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="description">Poll Description</label>
                    <div class="col-md-7">
                        <textarea class="form-control" rows="6" name="description" id="description" placeholder="Poll Description"><?php echo isset($poll) ? stripslashes(($poll->description)) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="descriptionAr">Poll Description Arabic</label>
                    <div class="col-md-7">
                        <textarea class="form-control" dir="rtl" rows="6" name="descriptionAr" id="descriptionAr" placeholder="Poll Description Arabic"><?php echo isset($poll) ? stripslashes(($poll->descriptionAr)) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="image">Poll Image</label>
                    <div class="col-md-7">
                        <input type="file" name="image" id="image" />
                        <?php if (isset($poll)) {
                        ?>
                            <input type="hidden" name="imageOld" id="imageOld" value="<?php echo $poll->image; ?>" />
                            <?php if ($poll->image != "") {
                            ?>
                                <image style="max-height:200px ;" src="<?php echo upload_url('images/poll/thumb/' . $poll->image); ?>" />
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>
                    Poll Options
                </legend>
                <div id="poll-options-container" class="padding-top">
                    <?php
                    if (isset($poll)) {
                        if (count($options) > 0) {
                            $j = 0;
                            foreach ($options as $option) {
                                $j++;
                    ?>
                                <div class="form-group " id="parent-<?php echo $option->id; ?>">
                                    <div class="form-group row Azooma-backend-input-seperator">
                                        <label class="col-md-2 control-label" for="field-<?php echo $option->id; ?>">Poll Option <?php echo $j; ?></label>
                                        <div class="col-md-6">
                                            <input class="form-control required" type="text" name="field-<?php echo $option->id; ?>" id="field-<?php echo $option->id; ?>" placeholder="Poll Option <?php echo $j; ?>" value="<?php echo stripslashes(($option->field)); ?>" />
                                            <a class="btn btn-XS btn-danger p-1 m-1 close Azooma-close" href="javascript:void(0);" data-dismiss="input-<?php echo $j; ?>">&times;</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 control-label" for="field_ar-<?php echo $option->id; ?>">Poll Option Arabic <?php echo $j; ?></label>
                                        <div class="col-md-6">
                                            <input class="form-control required" dir="rtl" type="text" name="field_ar-<?php echo $option->id; ?>" id="field_ar-<?php echo $option->id; ?>" placeholder="Poll Option Arabic <?php echo $j; ?>" value="<?php echo stripslashes(($option->field_ar)); ?>" />
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                    } else {
                        ?>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="option-1">Poll Option 1</label>
                            <div class="col-md-6">
                                <input class="form-control required" type="text" name="option[]" id="option-1" placeholder="Poll Option 1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="option_ar-1">Poll Option Arabic 1</label>
                            <div class="col-md-6">
                                <input class="form-control required" dir="rtl" type="text" name="option_ar[]" id="option_ar-1" placeholder="Poll Option Arabic 1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="option-2">Poll Option 2</label>
                            <div class="col-md-6">
                                <input class="form-control required" type="text" name="option[]" id="option-2" placeholder="Poll Option 2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="option_ar-2">Poll Option Arabic 2</label>
                            <div class="col-md-6">
                                <input class="form-control required" dir="rtl" type="text" name="option_ar[]" id="option_ar-2" placeholder="Poll Option Arabic 2">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="status"></label>
                    <div class="col-md-7">
                        <a href="javascript:void(0);" onclick="addmore();" class="btn btn-large btn-primary"><i class="icon icon-plus-sign"></i> Add another</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="status">Publish</label>
                    <div class="col-md-7">
                        <input type="checkbox" <?php if (!isset($poll->status) || $poll->status == 1) echo 'checked="checked"'; ?> name="status" value="1" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-2">
                        <?php if (isset($poll)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $poll->id; ?>" />
                        <?php
                        }
                        ?>
                        <input type="hidden" name="rest_ID" value="<?php echo isset($rest) ? $rest->rest_ID : 0; ?>" />

                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien" />

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
    <?php
    if (isset($poll)) {
    ?>
        counter = <?php echo count($options) + 1; ?>;
    <?php
    } else {
    ?>
        counter = 3;
    <?php
    }
    ?>
</script>
<style>
    .form-control {
        float: left;
        display: inline-block;
    }
</style>
<script>
    function addmore() {
        var element = '<div class="form-group row"><label class="col-md-2 control-label" for="option-' + counter + '">Poll Option ' + counter + '</label><div class="col-md-6"><input class="form-control required" type="text" name="option[]" id="option-' + counter + '" placeholder="Poll Option ' + counter + '" /></div></div><div class="form-group row"><label class="col-md-2 control-label" for="option_ar-' + counter + '">Poll Option Arabic ' + counter + '</label><div class="col-md-6"><input class="form-control required" dir="rtl" type="text" name="option_ar[]" id="option_ar-' + counter + '" placeholder="Poll Option Arabic ' + counter + '" /></div></div>';
        $("#poll-options-container").append(element);
        counter++;
    }
    $('body').on("click", ".Azooma-close", function(event) {
        var btn = $(this);

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result) {

                var dismiss = btn.attr('data-dismiss');
                btn.parent().parent().parent().remove();
                counter--;
            }
        })
    });
</script>
@endsection