@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('adminfavorites'); ?>">Favorites</a></li>  
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
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminfavorites/save'); }}" method="post" >
      <div class="form-group row">
        <label for="title" class="col-md-2 control-label">Name English</label>
        <div class="col-md-6">
          {{ isset($page) ? $page->rest_Name : '' }}
        </div>
      </div>
      <div class="form-group row">
        <label for="titlear" class="col-md-2 control-label">Name  Arabic</label>
        <div class="col-md-6">
          {{ isset($page) ? $page->rest_Name_Ar : '' }}
        </div>
      </div>

      <div class="form-group row">
        <label for="fav_desc" class="col-md-2 control-label">Description English</label>
        <div class="col-md-6">
          <textarea name="fav_desc" id="fav_desc" class="form-control" rows="5">{{ isset($page) ? stripslashes(html_entity_decode($page->fav_desc)) : Input::old('fav_desc') }}</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="fav_desc_ar" class="col-md-2 control-label">Description Arabic</label>
        <div class="col-md-6">
          <textarea name="fav_desc_ar" id="fav_desc_ar" class="form-control" rows="5">{{ isset($page) ? stripslashes(html_entity_decode($page->fav_desc_ar)) : Input::old('fav_desc_ar') }}</textarea>
        </div>
      </div>    

      <div class="form-group row">
        <div class="offset-lg-2 col-md-6">
          <button type="submit" class="btn btn-primary-gradien">Save Now</button>
          <?php
          if(isset($page)){
            ?>
            <input type="hidden" name="rest_ID"  value="{{ isset($page) ? $page->rest_ID : 0 }}" id="rest_ID" >
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
  var editor_details = CKEDITOR.replace('fav_desc');
  CKFinder.setupCKEditor( editor_details, base+'/js/ckfinder/' );
  var editor_details_ar = CKEDITOR.replace('fav_desc_ar');
  CKFinder.setupCKEditor( editor_details_ar, base+'/js/ckfinder/' );
//]]>
    $(document).ready(function(){
      
    });
  </script>

  @endsection