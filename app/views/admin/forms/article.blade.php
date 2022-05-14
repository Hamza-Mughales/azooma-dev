@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminarticles'); ?>">Categories</a></li>  
    <?php if (isset($cat)) { ?>
        <li><a href="<?= route('adminarticles/articles/', $cat->id); ?>">{{ $cat->name; }}</a></li>
    <?php } ?>
    <li class="active">{{ $title }}</li>
</ol>



<div class="well-white container">
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminarticles/articlesave'); }}" method="post" enctype="multipart/form-data">
            <?php if (!isset($page)) {
                ?>
                <div class="form-group row">
                    <label for="articleType" class="col-md-2 control-label">Article Type</label>
                    <div class="col-md-6">

                        <i class="glyphicon glyphicon-align-left"></i>&nbsp;&nbsp;
                        <input <?php if (!isset($page->articleType) || $page->articleType == '0') echo 'checked="checked"'; ?> type="radio" name="articleType" value="0" style="margin: 0px">
                        &nbsp;&nbsp;Normal 
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;
                        <input type="radio" name="articleType" onclick="goSlideForm();" <?php if (isset($page->articleType) && $page->articleType == '1') echo 'checked="checked"'; ?> value="1" style="margin: 0px" >
                        &nbsp;&nbsp;Slide 

                    </div>
                </div>
            <?php } ?>
            <legend>{{ $title }}</legend>
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="nameAr" class="form-control required"  value="{{ isset($page) ? $page->nameAr : Input::old('nameAr') }}" id="nameAr" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            <br />
            <legend>Author Information</legend>

            <div class="form-group row">
                <label for="author" class="col-md-2 control-label">Author English</label>
                <div class="col-md-6">
                    <input type="input" name="author" class="form-control" value="{{ isset($page) ? $page->author : Input::old('author') }}" id="author" placeholder="Author English">
                </div>
            </div>
            <div class="form-group row">
                <label for="authorAr" class="col-md-2 control-label">Author Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="authorAr" class="form-control"  value="{{ isset($page) ? $page->authorAr : Input::old('authorAr') }}" id="authorAr" placeholder="Author Arabic" dir="rtl">
                </div>
            </div>

            <br />
            <legend>About The Article</legend>

            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">
                    Article Image
                    <span class="small-text">(640 * any)</span>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl') ?>/images/blog/thumb/<?php echo $page->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="rest_ID" class="col-md-2 control-label">Restaurant</label>
                <div class="col-md-6">

                    <select name="rest_ID[]" id="rest_ID" class="form-control chzn-select" multiple="" placeholder="Please select Restaurant">                        
                        <?php
                        $selected_ids = array();
                        if (isset($page) && $page->rest_ID != "") {
                            $arest_IDs = $page->rest_ID;
                            $selected_ids = explode(",", $arest_IDs);
                        }
                        if (is_object($restaurants)) {
                            foreach ($restaurants as $restaurant) {
                                $selected = "";
                                if (in_array($restaurant->rest_ID, $selected_ids)) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $restaurant->rest_ID; ?>" <?php echo $selected; ?>><?php echo $restaurant->rest_Name; ?></option>
                                <?php
                            }
                        }
                        ?>                
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">City</label>
                <div class="col-md-6">
                    <select class="form-control required chzn-select" multiple="" data-placeholder="Select City" name="locations[]" id="locations"> 
                        <option value="0">All Cities</option>
                        <?php
                        if (isset($page) && $page->country != 0) {
                            $country = $page->country;
                        } else {
                            $country = Session::get('admincountry');
                            if (empty($country)) {
                                $country = 1;
                            }
                        }
                        $cities = MGeneral::getAllCities($country);
                        if (is_array($cities)) {
                            foreach ($cities as $value) {
                                $selected = "";
                                if (isset($page) && !empty($page->locations)) {
                                    $selected_arr = explode(",", $page->locations);
                                    if (in_array($value->city_ID, $selected_arr)) {
                                        $selected = 'selected';
                                    }
                                }
                                ?>
                                <option value="{{ $value->city_ID }}" {{ $selected }} >
                                    {{ $value->city_Name }}
                                </option>
                                <?php
                            }
                        }
                        ?>                        
                    </select> 
                </div>
            </div>

            <div class="form-group row">
                <label for="imageDescription" class="col-md-2 control-label">Image Description/Copyright</label>
                <div class="col-md-6">
                    <input type="input" name="imageDescription" class="form-control"  value="{{ isset($page) ? $page->imageDescription : Input::old('imageDescription') }}" id="imageDescription" placeholder="Author Arabic" >
                </div>
            </div>
            <div class="form-group row">
                <label for="broughtby" class="col-md-2 control-label">Brought By</label>
                <div class="col-md-6">
                    <input type="input" name="broughtby" class="form-control"  value="{{ isset($page) ? $page->broughtby : Input::old('broughtby') }}" id="broughtby" placeholder="Brought By">
                </div>
            </div>
            <div class="form-group row">
                <label for="broughtbyAr" class="col-md-2 control-label">Brought By Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="broughtbyAr" class="form-control"  value="{{ isset($page) ? $page->broughtbyAr : Input::old('broughtbyAr') }}" id="broughtbyAr" placeholder="Brought By Arabic" dir="rtl">
                </div>
            </div>
            <div class="form-group row">
                <label for="broughtbyurl" class="col-md-2 control-label">Brought By URL</label>
                <div class="col-md-6">
                    <input type="input" name="broughtbyurl" class="form-control"  value="{{ isset($page) ? $page->broughtbyurl : Input::old('broughtbyurl') }}" id="broughtbyurl" placeholder="Brought By URL">
                </div>
            </div>
            <div class="form-group row">
                <label for="authorAr" class="col-md-2 control-label">Brought By Image<br /><span class="small-font">(200 * 60)</span></label>
                <div class="col-md-6">
                    <input type="file" name="broughtbyImage" id="broughtbyImage" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="broughtbyImage_old" value="<?php echo $page->broughtbyImage; ?>"/>
                        <?php if ($page->broughtbyImage != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/blog/<?php echo $page->broughtbyImage; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="shortdescription" class="col-md-2 control-label">Short Description English<br /><span class="small-font">900 characters allowed</span></label>
                <div class="col-md-6">
                    <textarea name="shortdescription" id="shortdescription" class="form-control" rows="5">{{ isset($page) ? stripslashes($page->shortdescription) : Input::old('shortdescription') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="shortdescriptionAr" class="col-md-2 control-label">Short Description Arabic<br /><span class="small-font">900 characters allowed</span></label>
                <div class="col-md-6">
                    <textarea name="shortdescriptionAr" id="shortdescriptionAr" class="form-control" rows="5">{{ isset($page) ? $page->shortdescriptionAr : Input::old('shortdescriptionAr') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea name="description" id="description" class="form-control" rows="5">{{ isset($page) ? stripslashes($page->description) : Input::old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="descriptionAr" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-6">
                    <textarea name="descriptionAr" id="descriptionAr" class="form-control" rows="5">{{ isset($page) ? $page->descriptionAr : Input::old('descriptionAr') }}</textarea>
                </div>
            </div>

            <br />
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
                        <input type="hidden" name="id" id="articleID" value="<?php echo $page->id; ?>"/>
                        <input type="hidden" name="oldname" value="<?php echo (($page->name)); ?>"/>
                        <input type="hidden" name="url" value="<?php echo $page->url; ?>"/>
                        <?php
                    }
                    ?>
                    <input type="hidden" name="category" id="categoryID" value="<?php echo $cat->id; ?>"/>
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
    
    var editor_details = CKEDITOR.replace('description');
    CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
    var editor_details_ar = CKEDITOR.replace('descriptionAr');
    CKFinder.setupCKEditor(editor_details_ar, base + '/js/ckfinder/');
    
    
    $(document).ready(function() {
        $("#shortdescription").charCount({
            allowed: 900,
            warning: 20,
            counterText: 'Characters left: '
        });
        $("#shortdescriptionAr").charCount({
            allowed: 900,
            warning: 20,
            counterText: 'Characters left: '
        });
    });

    function goSlideForm() {
        var url = base + 'admin/adminarticles/slideform/?1=1';
<?php if (isset($page)) { ?>
            url = url + '&article=' + $('#articleID').val();
<?php } ?>
        url = url + '&category=' + $('#categoryID').val();
        window.location = url;

    }
</script>

@endsection