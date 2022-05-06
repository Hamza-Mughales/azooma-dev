@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminpages'); ?>">Pages</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminpages/save'); }}" method="post" >
            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="title" class="form-control" value="{{ isset($page) ? $page->title : Input::old('title') }}" id="title" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="titlear" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="titlear" class="form-control"  value="{{ isset($page) ? $page->title_ar : Input::old('titlear') }}" id="titlear" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>

            
            <div class="form-group row">
                <label for="keywords" class="col-md-2 control-label">Keywords English</label>
                <div class="col-md-6">
                    <input type="input" name="keywords" class="form-control" value="{{ isset($page) ? $page->keywords : Input::old('keywords') }}" id="keywords" placeholder="Keywords English">
                </div>
            </div>
            <div class="form-group row">
                <label for="keywords_ar" class="col-md-2 control-label">Keywords Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="keywords_ar" class="form-control"  value="{{ isset($page) ? $page->keywords_ar : Input::old('keywords_ar') }}" id="keywords_ar" placeholder="Keywords Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="details" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea name="details" id="details" class="form-control" rows="5">{{ isset($page) ? $page->details : Input::old('details') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="details_ar" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-6">
                    <textarea name="details_ar" id="details_ar" class="form-control" rows="5">{{ isset($page) ? $page->details_ar : Input::old('details_ar') }}</textarea>
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
    var editor_details = CKEDITOR.replace('details');
    CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
    var editor_details_ar = CKEDITOR.replace('details_ar');
    CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );
    //]]>
</script>

@endsection