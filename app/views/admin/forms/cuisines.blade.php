@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('admincuisine'); ?>">Master Cuisnies</a></li>  
  <?php
  if(isset($mainID)){
    ?>
    <li><a href="<?= route('admincuisine/subcuisines/',$mainID); ?>">Cuisnies</a></li>
    <?php  
  }
  ?>
  
  <li class="active">{{ $title }}</li>
</ol>
<?php
$message = Session::get('message');

?>

<div class="well-white container">
  <article>    
    <fieldset>
      <legend>{{ $pagetitle }}</legend>        
    </fieldset>
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincuisine/cuisinesave'); }}" method="post" enctype="multipart/form-data">

      <div class="form-group row">
        <label for="author" class="col-md-2 control-label">Master Cuisine</label>
        <div class="col-md-6">
          <select name="master_id" id="master_id" class="form-control">
            <option value="">please Select Cuisine</option>
            <?php            
            foreach ($cuisines as $cuisine) {
              $selected= "";
              if(isset($mainID) && $mainID==$cuisine->id){
                $selected="selected";
              }elseif(isset($_GET['master_id']) && $_GET['master_id'] == $cuisine->id ){
                $selected="selected";
              }
              ?>
              <option <?php echo $selected; ?> value="<?php echo $cuisine->id; ?>">
                <?php echo stripslashes($cuisine->name); ?>
              </option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>  



      <div class="form-group row">
        <label for="cuisine_Name" class="col-md-2 control-label">Title English</label>
        <div class="col-md-6">
          <input type="input" name="cuisine_Name" class="form-control required" value="{{ isset($page) ? $page->cuisine_Name : Input::old('cuisine_Name') }}" id="cuisine_Name" placeholder="Title English">
        </div>
      </div>
      <div class="form-group row">
        <label for="cuisine_Name_ar" class="col-md-2 control-label">Title Arabic</label>
        <div class="col-md-6">
          <input type="input" name="cuisine_Name_ar" class="form-control required"  value="{{ isset($page) ? $page->cuisine_Name_ar : Input::old('cuisine_Name_ar') }}" id="cuisine_Name_ar" placeholder="Title Arabic" dir="rtl">
        </div>
      </div>


      <div class="form-group row">
        <label for="cuisine_tags" class="col-md-2 control-label">Cuisine Tags English</label>
        <div class="col-md-6">
          <input type="input" name="cuisine_tags" class="form-control" value="{{ isset($page) ? $page->cuisine_tags : Input::old('cuisine_tags') }}" id="cuisine_tags" placeholder="Cuisine Tags English">
        </div>
      </div>
      <div class="form-group row">
        <label for="cuisine_tags_ar" class="col-md-2 control-label">Cuisine Tags Arabic</label>
        <div class="col-md-6">
          <input type="input" name="cuisine_tags_ar" class="form-control "  value="{{ isset($page) ? $page->cuisine_tags_ar : Input::old('cuisine_tags_ar') }}" id="cuisine_tags_ar" placeholder="Cuisine Tags Arabic" dir="rtl">
        </div>
      </div>

      

      <div class="form-group row">
        <label for="author_ar" class="col-md-2 control-label">Thumb Image</label>
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
        <label for="author_ar" class="col-md-2 control-label">Banner Image</label>
        <div class="col-md-6">
          <input type="file" name="bannerimage" id="bannerimage" />
          <?php
          if(isset($page)){
            ?>
            <input type="hidden" name="bannerimage_old" value="<?php echo $page->bannerimage;?>"/>
            <?php if($page->bannerimage!=""){ ?>
            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/cuisine/banner/thumb/<?php echo $page->bannerimage; ?>" width="100"/>
            <?php
          }
        }
        ?>
      </div>
    </div>

    <div class="form-group row">
      <label for="cuisine_description" class="col-md-2 control-label">Description English</label>
      <div class="col-md-6">
        <textarea name="cuisine_description" id="cuisine_description" class="form-control" rows="5">{{ isset($page) ? $page->cuisine_description : Input::old('cuisine_description') }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="cuisine_description_ar" class="col-md-2 control-label">Description Arabic</label>
      <div class="col-md-6">
        <textarea name="cuisine_description_ar" id="cuisine_description_ar" class="form-control" rows="5">{{ isset($page) ? $page->cuisine_description_ar : Input::old('cuisine_description_ar') }}</textarea>
      </div>
    </div>    

    <div class="form-group row">
      <label for="cuisine_Status" class="col-md-2 control-label">Publish</label>
      <div class="col-md-6">
        <div class="btn-group">
          <input type="checkbox"  name="cuisine_Status" value="1"  {{ isset($page) ? ($page->cuisine_Status==1) ? 'checked': '' : 'checked' }} >            
        </div>
      </div>
    </div>  

    <div class="form-group row">
      <div class="offset-lg-2 col-md-6">
        <button type="submit" class="btn btn-primary-gradien">Save Now</button>
        <?php
        if(isset($page)){
          ?>
          <input type="hidden" name="id"  value="{{ isset($page) ? $page->cuisine_ID : 0 }}" id="id" >
          <?php
        }
        ?>
      </div>
    </div>
  </form>
</article>
</div>

@endsection