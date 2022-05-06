@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminrestaurantsgroup'); ?>">Group of Restaurants</a></li>  
    <?php if (isset($cat)) { ?>
        <li><a href="<?= route('adminarticles/articles/', $cat->id); ?>">{{ $cat->name; }}</a></li>
    <?php } ?>
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>
        <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestaurantsgroup/save'); ?>" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="name">Name</label>
                    <div class="col-md-6">
                        <input class="required form-control" type="text" name="name" id="name" placeholder="Name" <?php echo isset($restgroup) ? 'value="' . stripslashes(($restgroup->name)) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="name_ar">Name Arabic</label>
                    <div class="col-md-6">
                        <input class="required form-control" dir="rtl" type="text" name="name_ar" id="name_ar" placeholder="Name Arabic" <?php echo isset($restgroup) ? 'value="' . stripslashes(($restgroup->name_ar)) . '"' : ""; ?> />
                    </div>
                </div>                            
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="logo">Logo</label>
                    <div class="col-md-6">
                        <input type="file" name="logo" id="logo" />
                        <?php
                        if (isset($restgroup) && ($restgroup->logo != "")) {
                            ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/logos/<?php echo $restgroup->logo; ?>"/>
                            <input type="hidden" name="logo_old" value="<?php echo $restgroup->logo; ?>"/>
                            <a href="<?php echo route('adminrestaurantsgroup/deleteImage/' , $restgroup->id ). '?type=logo'; ?>"> Delete Logo </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="image">Image</label>
                    <div class="col-md-6">
                        <input type="file" name="image" id="image" />
                        <?php
                        if (isset($restgroup) && ($restgroup->image != "")) {
                            ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/hotel/thumb//<?php echo $restgroup->image; ?>"/>
                            <input type="hidden" name="image_old" value="<?php echo $restgroup->image; ?>"/>
                            <a href="<?php echo route('adminrestaurantsgroup/deleteImage/' , $restgroup->id ). '?type=image'; ?>"> Delete Image </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($restgroup->status) || $restgroup->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-2">
                        <?php if (isset($restgroup)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $restgroup->id; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                        else echo adminrestaurantsgroup('adminrestaurantsgroup'); ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>


@endsection