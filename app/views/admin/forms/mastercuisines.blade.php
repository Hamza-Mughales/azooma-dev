@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('admincuisine'); ?>">Master Cuisnies</a></li>  
  <li class="active">{{ $title }}</li>
</ol>
<?php
$message = Session::get('message');

?>

<div class="well-white">
  <article>    
    <fieldset>
      <legend>{{ $pagetitle }}</legend>        
    </fieldset>
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincuisine/save'); }}" method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="name" class="col-md-2 control-label">Title English</label>
        <div class="col-md-6">
          <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
        </div>
      </div>
      <div class="form-group row">
        <label for="name_ar" class="col-md-2 control-label">Title Arabic</label>
        <div class="col-md-6">
          <input type="input" name="name_ar" class="form-control required"  value="{{ isset($page) ? $page->name_ar : Input::old('name_ar') }}" id="name_ar" placeholder="Title Arabic" dir="rtl">
        </div>
      </div>

      <div class="form-group row">
        <label for="author" class="col-md-2 control-label">Food/Cuisine Tag</label>
        <div class="col-md-6">
          <select multiple name="tags[]" id="tags[]" class="form-control chzn-select" data-placeholder="Select Cuisines">            
            <?php
            $cuisineList= array();
            if(isset($page)){
              $cuisineList=explode(",",$page->tags);
            }
            foreach ($cuisines as $cuisine) {
              ?>
              <option value="<?php echo $cuisine->cuisine_ID; ?>" <?php if (!empty($cuisineList) && in_array($cuisine->cuisine_ID, $cuisineList)) echo 'selected="selected"'; ?> >
                <?php echo stripslashes($cuisine->cuisine_Name); ?>
              </option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>      
      <div class="form-group row">
        <label for="author_ar" class="col-md-2 control-label">Image</label>
        <div class="col-md-6">
          <input type="file" name="image" id="image" />
          <?php
          if(isset($page)){
            ?>
            <input type="hidden" name="image_old" value="<?php echo $page->image;?>"/>
            <?php if($page->image!=""){ ?>
            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/cuisine/<?php echo $page->image; ?>" width="100"/>
            <?php
          }
        }
        ?>
      </div>
    </div>

    <div class="form-group row">
      <label for="description" class="col-md-2 control-label">Description English</label>
      <div class="col-md-6">
        <textarea name="description" id="description" class="form-control" rows="5">{{ isset($page) ? $page->description : Input::old('description') }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="description_ar" class="col-md-2 control-label">Description Arabic</label>
      <div class="col-md-6">
        <textarea name="description_ar" id="description_ar" class="form-control" rows="5">{{ isset($page) ? $page->description_ar : Input::old('description_ar') }}</textarea>
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
        if(isset($page)){
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
@endsection