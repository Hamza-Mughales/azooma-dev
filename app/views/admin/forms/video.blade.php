@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admingallery/videos'); ?>">Video Gallery</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white container">

    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admingallery/videosave'); }}" method="post" enctype="multipart/form-data">
            <legend>{{ $title }}</legend>
            <div class="form-group row">
                <label for="rest_ID" class="col-md-2 control-label">Restaurant</label>
                <div class="col-md-6">

                    <select name="rest_ID" id="rest_ID" class="form-control chzn-select" placeholder="Please select Restaurant">                        
                        <option value="">Please select</option>
                        <?php
                        $selected_ids = array();
                        if (isset($page) && $page->rest_ID != "") {
                            $arest_IDs = $page->rest_ID;
                            $selected_ids = explode(",", $arest_IDs);
                        }
                        if (is_array($restaurants)) {
                            foreach ($restaurants as $restaurant) {
                                $selected = "";
                                if (in_array($restaurant->rest_ID, $selected_ids)) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $restaurant->rest_ID; ?>" <?php echo $selected; ?> ><?php echo $restaurant->rest_Name; ?></option>
                                <?php
                            }
                        }
                        ?>                
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="name_en" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="name_en" class="form-control required" value="{{ isset($page) ? $page->name_en : Input::old('name_en') }}" id="name_en" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="name_ar" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="name_ar" class="form-control required"  value="{{ isset($page) ? $page->name_ar : Input::old('name_ar') }}" id="name_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            <div class="form-group row">
                <label for="youtube_en" class="col-md-2 control-label">You Tube Link</label>
                <div class="col-md-6">
                    <input type="input" name="youtube_en" class="form-control required" value="{{ isset($page) ? $page->youtube_en : Input::old('youtube_en') }}" id="youtube_en" placeholder="You Tube Link">
                    <?php
                    if (isset($page)) {
                        $youtube = "";
                        parse_str(parse_url($page->youtube_en, PHP_URL_QUERY), $var);
                        if (isset($var['v'])) {
                            $youtube = $var['v'];
                        }
                        ?>
                        <div class="overflow margin-top">
                            <iframe width="575" height="300" src="http://www.youtube.com/embed/<?php echo $youtube; ?>?autoplay=0&loop=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="youtube_ar" class="col-md-2 control-label">You Tube Link Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="youtube_ar" class="form-control required" value="{{ isset($page) ? $page->youtube_ar : Input::old('youtube_ar') }}" id="youtube_ar" placeholder="You Tube Link Arabic">
                    <?php
                    if (isset($page)) {
                        $youtube = "";
                        parse_str(parse_url($page->youtube_ar, PHP_URL_QUERY), $var);
                        if (isset($var['v'])) {
                            $youtube = $var['v'];
                        }
                        ?>
                        <div class="overflow margin-top">
                            <iframe width="575" height="300" src="http://www.youtube.com/embed/<?php echo $youtube; ?>?autoplay=0&loop=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="video_description" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea rows="10" name="video_description" id="video_description" class="form-control">
                    {{ isset($page) ? $page->video_description : Input::old('video_description') }}
                    </textarea> 
                </div>
            </div>
            <div class="form-group row">
                <label for="video_description_ar" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-6">
                    <textarea rows="10" name="video_description_ar" id="video_description_ar" class="form-control">
                    {{ isset($page) ? $page->video_description_ar : Input::old('video_description_ar') }}
                    </textarea> 
                </div>
            </div>

            <div class="form-group row">
                <label for="video_tags" class="col-md-2 control-label">Video Tags English</label>
                <div class="col-md-6">
                    <input type="input" name="video_tags" class="form-control required" value="{{ isset($page) ? $page->video_tags : Input::old('video_tags') }}" id="video_tags" placeholder="Video Tags English">
                </div>
            </div>
            <div class="form-group row">
                <label for="video_tags_ar" class="col-md-2 control-label">Video Tags Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="video_tags_ar" class="form-control required"  value="{{ isset($page) ? $page->video_tags_ar : Input::old('video_tags_ar') }}" id="video_tags_ar" placeholder="Video Tags Arabic" dir="rtl">
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
                <label class="col-md-2 control-label"></label>
                <div class="col-md-6">
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
    var editor_details = CKEDITOR.replace('video_description');
    CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
    var editor_details_ar = CKEDITOR.replace('video_description_ar');
    CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );
    //]]>
    
</script>

@endsection