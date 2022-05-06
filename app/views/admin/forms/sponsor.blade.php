@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminsponsors'); ?>">Sponsors</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsponsors/save'); }}" method="post"  enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Name English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="name_ar" class="col-md-2 control-label">Name Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="name_ar" class="form-control"  value="{{ isset($page) ? $page->name_ar : Input::old('name_ar') }}" id="name_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="url" class="col-md-2 control-label">Sponsor Website</label>
                <div class="col-md-6">
                    <input type="input" name="url" class="form-control"  value="{{ isset($page) ? $page->url : Input::old('url') }}" id="url" placeholder="Sponsor Website">
                </div>
            </div>


            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">Sponsor Logo <span class="small-text">150*150</span> </label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/sponsor/<?php echo $page->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>          
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">Sponsor Image <span class="small-text">400*266</span> </label>
                <div class="col-md-6">
                    <input type="file" name="image_big" id="image_big" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_big_old" value="<?php echo $page->image_big; ?>"/>
                        <?php if ($page->image_big != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/sponsor/<?php echo $page->image_big; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>          
                </div>
            </div>



            <div class="form-group row">
                <label for="detail" class="col-md-2 control-label"> English Description </label>
                <div class="col-md-6">
                    <textarea name="detail" id="detail" class="form-control" rows="5">{{ isset($page) ? $page->detail : Input::old('detail') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="detail_ar" class="col-md-2 control-label">Arabic Description </label>
                <div class="col-md-6">
                    <textarea name="detail_ar" id="detail_ar" class="form-control" rows="5">{{ isset($page) ? $page->detail_ar : Input::old('detail_ar') }}</textarea>
                </div>
            </div>    


            <div class="form-group row">
                <label for="contact" class="col-md-2 control-label">English Contact </label>
                <div class="col-md-6">
                    <textarea name="contact" id="contact" class="form-control" rows="5">{{ isset($page) ? $page->contact : Input::old('contact') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="contact_ar" class="col-md-2 control-label">Arabic Contact </label>
                <div class="col-md-6">
                    <textarea name="contact_ar" id="contact_ar" class="form-control" rows="5">{{ isset($page) ? $page->contact_ar : Input::old('contact_ar') }}</textarea>
                </div>
            </div>    

            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->active==1) ? 'checked': '' : 'checked' }} >            
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
    var editor_details = CKEDITOR.replace('detail');
    CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
    var editor_details_ar = CKEDITOR.replace('detail_ar');
    CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );

    var editor_conact = CKEDITOR.replace('contact');
    CKFinder.setupCKEditor( editor_conact, base+'/js/ckfinder/' );
    var editor_conact_ar = CKEDITOR.replace('contact_ar');
    CKFinder.setupCKEditor( editor_conact_ar, base+'/js/ckfinder/' );

    //]]>
</script>

@endsection