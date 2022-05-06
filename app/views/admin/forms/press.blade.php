@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminpress'); ?>">Press</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white container">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminpress/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="short" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="short" class="form-control required" value="{{ isset($page) ? $page->short : Input::old('short') }}" id="short" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="short_ar" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="short_ar" class="form-control required"  value="{{ isset($page) ? $page->short_ar : Input::old('short_ar') }}" id="short_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            <div class="form-group row">
                <label for="author" class="col-md-2 control-label">Author English</label>
                <div class="col-md-6">
                    <input type="input" name="author" class="form-control" value="{{ isset($page) ? $page->author : Input::old('author') }}" id="keywords" placeholder="Author English">
                </div>
            </div>
            <div class="form-group row">
                <label for="author_ar" class="col-md-2 control-label">Author Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="author_ar" class="form-control"  value="{{ isset($page) ? $page->author_ar : Input::old('keywords_ar') }}" id="author_ar" placeholder="Author Arabic" dir="rtl">
                </div>
            </div>


            <div class="form-group row">
                <label for="author_ar" class="col-md-2 control-label">Press Image</label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/news/<?php echo $page->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="full" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea name="full" id="full" class="form-control" rows="5">{{ isset($page) ? $page->full : Input::old('full') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="full_ar" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-6">
                    <textarea name="full_ar" id="full_ar" class="form-control" rows="5">{{ isset($page) ? $page->full_ar : Input::old('full_ar') }}</textarea>
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
    var editor_details = CKEDITOR.replace('full');
    CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
    var editor_details_ar = CKEDITOR.replace('full_ar');
    CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );
    //]]>
    $(document).ready(function(){
        
    });
</script>

@endsection