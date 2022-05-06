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

<div class="well-white container">
    <article>
        <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="<?php echo route('adminrestmenu/savepdf'); ?>" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo stripslashes(($pagetitle)); ?></legend>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="menu">PDF Menu English</label>
                    <div class="col-md-9">
                        <input type="file" name="menu" id="menu" <?=(isset($menupdf) && !empty($menupdf->menu)) ? "" :"required"?> />
                        <?php
                        if (isset($menupdf) && !empty($menupdf->menu)) {
                            ?>
                            <input type="hidden" name="menu_old" value="<?php echo $menupdf->menu; ?>"/>
                            <a target="_blank" href="<?php echo upload_url('menu/menu_pdf/'. $menupdf->menu); ?>" title="Download">View Menu</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="menu_ar">PDF Menu Arabic</label>
                    <div class="col-md-9">
                        <input type="file" name="menu_ar" id="menu_ar" <?=(isset($menupdf) && !empty($menupdf->menu_ar)) ? "" :"required"?>/>
                        <?php
                        if (isset($menupdf) && !empty($menupdf->menu_ar)) {
                            ?>
                            <input type="hidden" name="menu_ar_old" value="<?php echo $menupdf->menu_ar; ?>"/>
                            <a target="_blank" href="<?php echo upload_url('menu/menu_pdf/'. $menupdf->menu_ar); ?>" title="Download">View Menu</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="title">Title</label>
                    <div class="col-md-6">
                        <input type="text" name="title" class="required form-control" id="title" placeholder="Title" <?php echo isset($menupdf) ? 'value="' . $menupdf->title . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="title_ar">Arabic Title </label>
                    <div class="col-md-6">
                        <input type="text" class="required form-control" name="title_ar" id="title_ar" placeholder="Arabic Title " <?php echo isset($menupdf) ? 'value="' . $menupdf->title_ar . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label" for="rest_Status">Publish</label>
                    <div class="col-md-6">
                        <input type="checkbox" <?php if (!isset($menupdf->status) || $menupdf->status == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-3">
                        <input type="hidden" name="rest_ID" value="<?php echo $rest->rest_ID; ?>"/>
                        <input type="hidden" name="rest_Name" value="<?php echo $rest->rest_Name; ?>"/>
                        <?php if (isset($menupdf)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $menupdf->id; ?>"/>
                            <input type="hidden" name="pagenumber" value="<?php echo $menupdf->pagenumber; ?>"/>
                            <input type="hidden" name="pagenumberAr" value="<?php echo $menupdf->pagenumberAr; ?>"/>
                            <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                        <a href="<?php
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            echo $_SERVER['HTTP_REFERER'];
                        } else {
                            echo route('adminrestaurants/');
                        }
                        ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>



@endsection