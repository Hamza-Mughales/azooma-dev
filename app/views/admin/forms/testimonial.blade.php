@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admintestimonials'); ?>">Testimonials</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admintestimonials/save'); }}" method="post" >
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Name English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Name Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="nameAr" class="form-control"  value="{{ isset($page) ? $page->nameAr : Input::old('nameAr') }}" id="titlear" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            

            <div class="form-group row">
                <label for="description" class="col-md-2 control-label">Testimonial English</label>
                <div class="col-md-6">
                    <textarea name="description" id="description" class="form-control" rows="5">{{ isset($page) ? $page->description : Input::old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="descriptionAr" class="col-md-2 control-label">Testimonial Arabic</label>
                <div class="col-md-6">
                    <textarea name="descriptionAr" id="descriptionAr" class="form-control" rows="5">{{ isset($page) ? $page->descriptionAr : Input::old('descriptionAr') }}</textarea>
                </div>
            </div>    

            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($page) ? $page->id : 0 }}" id="id" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>


<?php
    echo HTML::script('js/ckeditor/ckeditor.js');
    echo HTML::script('js/ckfinder/ckfinder.js');
?>
<script type="text/javascript">

    //<![CDATA[
    var editor_details = CKEDITOR.replace('description');
    CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
    var editor_details_ar = CKEDITOR.replace('descriptionAr');
    CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );
    //]]>
    
</script>

@endsection