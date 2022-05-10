@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    {{-- <li><a href="<?= route($action); ?>">  --}}
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
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestaurants/polloptionsave/',$poll->id); }}" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo $pagetitle; ?></legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="field">Option</label>
                    <div class="col-md-6">
                        <input class="form-control required" type="text" name="field" id="field" placeholder="Option" <?php echo isset($option) ? 'value="' . $option->field . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="field_ar">Option Arabic</label>
                    <div class="col-md-6">
                        <input class="form-control required" dir="rtl" type="text" name="field_ar" id="field_ar" placeholder="Option Arabic" <?php echo isset($option) ? 'value="' . $option->field_ar . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($poll->status) || $poll->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-md-2 control-label" for="status"></label>

                    <div class="col-md-6">
                        <?php if (isset($option)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $option->id; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>"/>
                        <input type="hidden" name="rest_ID" value="<?php echo isset($rest) ? $rest->rest_ID : 0; ?>"/>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        
                        <a href="<?php
                        if (isset($_SERVER['HTTP_REFERER']))
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