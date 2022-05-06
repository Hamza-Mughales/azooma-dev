<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('adminarticles'); ?>">Categories</a></li>  
    <?php if (isset($cat)) { ?>
        <li><a href="<?= route('adminarticles/articles/', $cat->id); ?>">{{ $cat->name; }}</a></li>
    <?php } ?>
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminarticles/saveslide'); }}" method="post" enctype="multipart/form-data">
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
            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">
                    Article Image
                    <span class="small-text">( 640 * any )</span>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/blog/thumb/<?php echo $page->image; ?>" width="100"/>
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
                <label for="authorAr" class="col-md-2 control-label">Brought By Image<br /><span class="small-font">(200 * 60)</span></label></label>
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
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  



            <div class="overflow" id="main-slide">                    
                <?php
                $i = 0;
                if (isset($slideArticles)) {
                    foreach ($slideArticles as $slide) {
                        $rest_IDs = explode(',', $slide->rest_ID);
                        $restoptions = "";
                        foreach ($restaurants as $rest) {
                            $restoptions.='<option value="' . $rest->rest_ID . '"';
                            if (in_array($rest->rest_ID, $rest_IDs)) {
                                $restoptions.=' selected="selected"';
                            }
                            $restoptions.='>' . (($rest->rest_Name)) . '</option>';
                        }
                        ?>
                        <legend>
                            Slide <?php echo ($i + 1); ?>
                            <a onclick="return confirm('Do You Want to Delete?')" class="close sufrati-close-slide" href="javascript:void(0);" data-dismiss-id="<?php echo $slide['id']; ?>" data-dismiss="slide-<?php echo $i; ?>">×</a>
                        </legend>
                        <div id="slide-<?php echo $i; ?>">
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="slidename-<?php echo $i; ?>">Slide Title</label>
                                <div class="col-md-6">
                                    <input class="required form-control" type="text" name="slidename-<?php echo $i; ?>" id="slidename-<?php echo $i; ?>" placeholder="Slide Title" value="<?php echo stripslashes($slide->name); ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="slideNameAr-<?php echo $i; ?>">Slide Title Arabic</label>
                                <div class="col-md-6">
                                    <input class="required form-control" dir="rtl" type="text" name="slideNameAr-<?php echo $i; ?>" id="slideNameAr-<?php echo $i; ?>" placeholder="Slide Title Arabic" value="<?php echo $slide->nameAr; ?>" />
                                </div>
                            </div>                                
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="logo-<?php echo $i; ?>">
                                    Slide Logo
                                    <br /><span class="small-font">(100 * 100)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="file" name="logo-<?php echo $i; ?>" id="logo-<?php echo $i; ?>" />
                                    <?php
                                    if (isset($slide) && !empty($slide->logo)) {
                                        ?>
                                        <input type="hidden" name="logo_old-<?php echo $i; ?>" value="<?php echo $slide->logo; ?>"/>
                                        <?php if ($slide->image != "") { ?>
                                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/blog/thumb/<?php echo $slide->logo; ?>" width="100"/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>         
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="image-<?php echo $i; ?>">
                                    Slide Image
                                    <br /><span class="small-font">(490 * 250)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="file" name="image-<?php echo $i; ?>" id="image-<?php echo $i; ?>" />
                                    <?php
                                    if (isset($slide) && !empty($slide->image)) {
                                        ?>
                                        <input type="hidden" name="image_old-<?php echo $i; ?>" value="<?php echo $slide->image; ?>"/>
                                        <?php if ($slide->image != "") { ?>
                                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/blog/thumb/<?php echo $slide->image; ?>" width="100"/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>         
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="rest-<?php echo $i; ?>">Tag a Restaurant</label>
                                <div class="col-md-6">
                                    <select multiple class="chzn-select form-control" tabindex="6" style="width: 350px;" data-placeholder="Tag a Restaurant" name="tagRest-<?php echo $i; ?>[]" id="tagRest-<?php echo $i; ?>">
                                        <?php echo $restoptions; ?>
                                    </select>                          
                                </div>
                            </div>                                
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="description-<?php echo $i; ?>">Slide Content</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description-<?php echo $i; ?>" id="description-<?php echo $i; ?>" rows="5" placeholder="Article Content"><?php echo $slide['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="descriptionAr-<?php echo $i; ?>">Slide Content Arabic</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" dir="rtl" name="descriptionAr-<?php echo $i; ?>" id="descriptionAr-<?php echo $i; ?>" rows="5" placeholder="Article Content Arabic"><?php echo $slide['descriptionAr']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="Status-<?php echo $i; ?>">Publish</label>
                                <div class="col-md-6">
                                    <input type="checkbox" <?php if ($slide['status'] == 1) echo 'checked="checked"'; ?> name="status-<?php echo $i; ?>" value="1"/>
                                </div>
                            </div>
                            <input type="hidden" name="id-<?php echo $i; ?>" value="<?php echo $slide['id']; ?>"/>
                        </div>
                        <?php
                        $i++;
                    }
                }else {
                    $restoptions = "";
                    foreach ($restaurants as $rest) {
                        $restoptions.='<option value="' . $rest->rest_ID . '"';
                        $restoptions.='>' . stripslashes(($rest->rest_Name)) . '</option>';
                    }
                    ?>
                    <legend>Slide 1</legend>
                    <div id="slide-<?php echo $i; ?>">
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="slidename-<?php echo $i; ?>">Slide Title</label>
                            <div class="col-md-6">
                                <input class="required form-control" type="text" name="slidename-<?php echo $i; ?>" id="slidename-<?php echo $i; ?>" placeholder="Slide Title" value="" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="slideNameAr-<?php echo $i; ?>">Slide Title Arabic</label>
                            <div class="col-md-6">
                                <input class="required form-control" dir="rtl" type="text" name="slideNameAr-<?php echo $i; ?>" id="slideNameAr-<?php echo $i; ?>" placeholder="Slide Title Arabic" value="" />
                            </div>
                        </div>                            
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="logo-<?php echo $i; ?>">
                                Slide Logo Image
                                <br /><span class="small-font">(100 * 100)</span>
                            </label>
                            <div class="col-md-6">
                                <input type="file" name="logo-<?php echo $i; ?>" id="logo-<?php echo $i; ?>" />
                            </div>
                        </div>         
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="image-<?php echo $i; ?>">
                                Slide Image
                                <br /><span class="small-font">(490 * 250)</span>
                            </label>
                            <div class="col-md-6">
                                <input type="file" name="image-<?php echo $i; ?>" id="image-<?php echo $i; ?>" />
                            </div>
                        </div>         
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="rest-<?php echo $i; ?>">Tag a Restaurant</label>
                            <div class="col-md-6">
                                <select multiple class="chzn-select form-control" tabindex="6" style="width: 350px;" data-placeholder="Tag a Restaurant" name="tagRest-<?php echo $i; ?>[]" id="tagRest-<?php echo $i; ?>">
                                    <?php echo $restoptions; ?>
                                </select>                          
                            </div>
                        </div>                            
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="description-<?php echo $i; ?>">Slide Content</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description-<?php echo $i; ?>" id="description-<?php echo $i; ?>" rows="5" placeholder="Article Content"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="descriptionAr-<?php echo $i; ?>">Slide Content Arabic</label>
                            <div class="col-md-6">
                                <textarea class="form-control" dir="rtl" name="descriptionAr-<?php echo $i; ?>" id="descriptionAr-<?php echo $i; ?>" rows="5" placeholder="Article Content Arabic"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="Status-<?php echo $i; ?>">Publish</label>
                            <div class="col-md-6">
                                <input type="checkbox" checked="checked" name="status-<?php echo $i; ?>" value="1"/>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="form-group row">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-6">
                    <a href="javascript:void(0)" class="btn btn-light" onclick="addmore();"><i class="icon-plus-sign icon-white"></i> Add Another Slide</a>
                </div>
            </div>





            <div class="form-group row">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <input type="hidden" id="counter" name="counter" value="<?php
                    if ($i == 0) {
                        echo $i;
                    } else {
                        echo $i - 1;
                    }
                    ?>"/>
                           <?php
                           if (isset($page)) {
                               ?>
                        <input type="hidden" name="id"  value="{{ isset($page) ? $page->id : 0 }}" id="id" >
                        <input type="hidden" name="articleID" id="articleID" value="<?php echo $page->id; ?>"/>
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

    function addmore() {
        var counter = $('#counter').val();
        counter = parseInt(counter) + 1;
        $('#counter').val(counter);
        $.ajax({
            url: base + 'hungryn137/adminarticles/slideformtab?counter=' + $('#counter').val(),
            cache: false,
            success: function(data) {
                if (typeof (data) != "undefined") {
                    $("#main-slide").append(data);
                     
                //    var config = {
                //        '.chzn-select': {},
                //        '.chzn-select-deselect': {allow_single_deselect: true},
                //        '.chzn-select-no-single': {disable_search_threshold: 10},
                //        '.chzn-select-no-results': {no_results_text: 'Oops, nothing found!'}
                //    }
                //    for (var selector in config) {
                //        $(selector).chosen(config[selector]);
                //    }
                }
            }
        });
    }

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
        console.log('aaa');
        var url = base + 'hungryn137/adminarticles/slideform/?1=1';
<?php if (isset($page)) { ?>
            url = url + '&article=' + $('#articleID').val();
<?php } ?>
        url = url + '&category=' + $('#categoryID').val();
        window.location = url;

    }


    $(document).ready(function() {
        $(document).on("click", ".sufrati-close-slide", function(event) {
            var dismiss = $(this).attr('data-dismiss');
            var dismissid = $(this).attr('data-dismiss-id');
            console.log('#' + dismiss);
            var t = $(this);
            if (dismissid != 0) {
                $.ajax({
                    url: base + 'hungryn137/adminarticles/slidedelete/' + dismissid,
                    cache: false,
                    success: function(data) {
                        if (typeof (data['html']) != "undefined") {
                            if (data['html'] == "yes") {
                                t.parent().remove();
                                $('#' + dismiss).remove();
                            } else {
                                alert("Can't Remove, Probally you don't have Rights");
                            }
                        } else {
                            alert("Can't Remove, Probally you don't have Rights");
                        }
                    }
                });
            } else {
                t.parent().remove();
                $('#' + dismiss).remove();
            }

        });
    });

<?php
if ($i == 0) {
    $cc = $i;
} else {
    $cc = $i - 1;
}
for ($j = 0; $j <= $cc; $j++) {
    ?>
        //<![CDATA[
        CKFinder.setupCKEditor(CKEDITOR.replace('description-<?php echo $j; ?>'), base + '/js/ckfinder/');
        CKFinder.setupCKEditor(CKEDITOR.replace('descriptionAr-<?php echo $j; ?>'), base + '/js/ckfinder/');
        //]]>                                                                
<?php } ?>
</script>
