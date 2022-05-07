@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminrecipe'); ?>"> Recipes</a></li>
    <li class="active">{{ $title }}</li>
</ol>



<div class="well-white">
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrecipe/save'); }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <legend>{{ $title }}</legend>
            <div class="form-group row col-md-6">
                <label for="name" class="col-md-3 control-label">Name English</label>
                <div class="col-md-9">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Name English">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="nameAr" class="col-md-3 control-label">Name Arabic</label>
                <div class="col-md-9">
                    <input type="input" name="nameAr" class="form-control required"  value="{{ isset($page) ? $page->nameAr : Input::old('nameAr') }}" id="nameAr" placeholder="Name Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="authorName" class="col-md-3 control-label">Author English</label>
                <div class="col-md-9">
                    <input type="input" name="authorName" class="form-control required" value="{{ isset($page) ? $page->authorName : Input::old('authorName') }}" id="authorName" placeholder="Author English">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="authorNameAr" class="col-md-3 control-label">Author Name Arabic</label>
                <div class="col-md-9">
                    <input type="input" name="authorNameAr" class="form-control required"  value="{{ isset($page) ? $page->authorNameAr : Input::old('authorNameAr') }}" id="authorNameAr" placeholder="Author Name Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="prepTime" class="col-md-3 control-label">Preparation Time</label>
                <div class="col-md-9">
                    <input type="input" name="prepTime" class="form-control required"  value="{{ isset($page) ? $page->prepTime : Input::old('prepTime') }}" id="prepTime" placeholder="Preparation Time">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="cookingTime" class="col-md-3 control-label">Cooking Time</label>
                <div class="col-md-9">
                    <input type="input" name="cookingTime" class="form-control required"  value="{{ isset($page) ? $page->cookingTime : Input::old('cookingTime') }}" id="cookingTime" placeholder="Cooking Time">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="serves" class="col-md-3 control-label">Serves</label>
                <div class="col-md-9">
                    <input type="input" name="serves" class="form-control required"  value="{{ isset($page) ? $page->serves : Input::old('serves') }}" id="serves" placeholder="Serves">
                </div>
            </div>

            <div class="form-group row">
                <label for="Ingredients" class="col-md-1 control-label">Ingredients</label>
                <div class="col-md-10 ">
                    <div id="ingredients-box" class="row">
                        <?php
                            if (isset($ingredients) && count($ingredients) > 0) {
                                $j = 0;
                                foreach ($ingredients as $ingredient) {
                                    $j++;
                                    ?>
                                    <div style="" class="clear col-md-6 <?php if ($j != 1) echo 'top'; ?>">
                                        #<?php echo $j; ?> <input class="form-control required auto-width" type="text" name="quantity[]" id="quantity<?php echo $j; ?>" value="<?php echo (($ingredient->quantity)); ?>" placeholder="Quantity (1 tbsp,1Kg, etc...)" />
                                        <input class="form-control required auto-width" type="text" name="ingredient[]" id="ingredient<?php echo $j; ?>" value="<?php echo (($ingredient->ingredient)); ?>" placeholder="Ingredient Name" />
                                        <input class="auto-width form-control" type="text" name="quantityAr[]" id="quantityAr<?php echo $j; ?>" value="<?php echo (($ingredient->quantityAr)); ?>" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" />
                                        <input class="auto-width form-control" type="text" name="ingredientAr[]" id="ingredientAr<?php echo $j; ?>" value="<?php echo (($ingredient->ingredientAr)); ?>" placeholder="Ingredient Name Arabic" />
                                    </div>
                                    <?php
                                }
                            }else {
                        ?>
                            <div class="clear col-md-6">
                                #1 <input class="form-control required auto-width" type="text" name="quantity[]" id="quantity0" placeholder="Quantity (1 tbsp,1Kg, etc...)" />
                                <input class="form-control required auto-width" type="text" name="ingredient[]" id="ingredient0" placeholder="Ingredient Name" />
                                <input class="auto-width form-control " type="text" name="quantityAr[]" id="quantityAr0" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredientAr[]" id="ingredientAr0" placeholder="Ingredient Name Arabic" />
                            </div>
                            <div class="top clear col-md-6">
                                #2 <input class="form-control required auto-width" type="text" name="quantity[]" id="quantity1" placeholder="Quantity (1 tbsp,1Kg, etc...)" />
                                <input class="form-control required auto-width" type="text" name="ingredient[]" id="ingredient1" placeholder="Ingredient Name" />
                                <input class="auto-width form-control " type="text" name="quantityAr[]" id="quantityAr1" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredientAr[]" id="ingredientAr1" placeholder="Ingredient Name Arabic" />
                            </div>
                            <div class="clear col-md-6 top">
                                #3 <input class="auto-width form-control " type="text" name="quantity[]" id="quantity2" placeholder="Quantity (1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredient[]" id="ingredient2" placeholder="Ingredient Name" />
                                <input class="auto-width form-control " type="text" name="quantityAr[]" id="quantityAr2" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredientAr[]" id="ingredientAr2" placeholder="Ingredient Name Arabic" />
                            </div>
                            <div class="clear col-md-6 top">
                                #4 <input class="auto-width form-control " type="text" name="quantity[]" id="quantity3" placeholder="Quantity (1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredient[]" id="ingredient3" placeholder="Ingredient Name" />
                                <input class="auto-width form-control " type="text" name="quantityAr[]" id="quantityAr3" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" />
                                <input class="auto-width form-control " type="text" name="ingredientAr[]" id="ingredientAr3" placeholder="Ingredient Name Arabic" />
                            </div>   
                        <?php } ?>
                    </div>
                    <div class="margin-top clear">
                        <a href="javascript:void(0);" onclick="addmore();" class="btn btn-light" id="addingredients"><i class="icon icon-plus-sign"></i> Add More</a>
                    </div>
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="image" class="col-md-3 control-label">Article Image<br /><span class="small-font">(490 * 250)</span></label>
                <div class="col-md-9">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/recipe/thumb/<?php echo $page->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="imageDesc" class="col-md-3 control-label">Image/Copyright</label>
                <div class="col-md-9">
                    <input type="input" name="imageDesc" class="form-control required"  value="{{ isset($page) ? $page->imageDesc : Input::old('imageDesc') }}" id="imageDesc" placeholder="Image Description/Copyright">
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="short" class="col-md-3 control-label">Recipe Short</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="short" id="short" rows="5" placeholder="Recipe Short">{{ isset($page) ? $page->serves : Input::old('serves') }}</textarea>
                </div>
            </div>

            <div class="form-group row col-md-6">
                <label for="shortAr" class="col-md-3 control-label">Short Arabic</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="shortAr" id="shortAr" rows="5" placeholder="Recipe Short Arabic">{{ isset($page) ? $page->shortAr : Input::old('shortAr') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-2 control-label">Recipe Direction</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Recipe Direction">{{ isset($page) ? $page->description : Input::old('description') }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="descriptionAr" class="col-md-2 control-label">Recipe Direction Arabic</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="descriptionAr" id="descriptionAr" rows="5" placeholder="Recipe Direction Arabic">{{ isset($page) ? $page->descriptionAr : Input::old('descriptionAr') }}</textarea>
                </div>
            </div>            

            <div class="form-group row">
                <label for="video_url" class="col-md-2 control-label">Recipe Video URL</label>
                <div class="col-md-7">
                    <input type="input" name="video_url" class="form-control"  value="{{ isset($page) ? $page->video_url : Input::old('video_url') }}" id="video_url" placeholder="Recipe Video URL">
                </div>
            </div>

            <div class="form-group row ">
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
        </div>
        </form>
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
        
    $(document).ready(function(){
        
    });
        
<?php if (isset($recipe)) { ?>
        var counter=<?php echo count($ingredients); ?>;
        if(counter==0){
            counter=1;
        }
<?php } else { ?>
        var counter=5;
<?php } ?>
    
    function addmore(){
        var element='<div class="top clear col-md-6"> #'+counter+' <input class="auto-width form-control " type="text" name="quantity[]" id="quantity'+counter+'" placeholder="Quantity (1 tbsp,1Kg, etc...)" /><input class="auto-width form-control " type="text" name="ingredient[]" id="ingredient'+counter+'" placeholder="Ingredient Name" /><input class="auto-width form-control " type="text" name="quantityAr[]" id="quantityAr'+counter+'" placeholder="Quantity Arabic(1 tbsp,1Kg, etc...)" /><input class="auto-width form-control " type="text" name="ingredientAr[]" id="ingredientAr'+counter+'" placeholder="Ingredient Name Arabic" /></div>';
        $("#ingredients-box").append(element);
        counter++
    }
</script>

@endsection