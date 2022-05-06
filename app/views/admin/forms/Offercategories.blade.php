@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('adminofferscategoires'); ?>">Offer Categories</a></li>  
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
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminofferscategoires/save'); }}" method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="categoryName" class="col-md-2 control-label"> English Name</label>
        <div class="col-md-6">
          <input type="input" name="categoryName" class="form-control required" value="{{ isset($page) ? $page->categoryName : Input::old('categoryName') }}" id="categoryName" placeholder="Category Name English">
        </div>
      </div>
      <div class="form-group row">
        <label for="categorycategoryNameAr" class="col-md-2 control-label"> Arabic Name</label>
        <div class="col-md-6">
          <input type="input" name="categoryNameAr" class="form-control required"  value="{{ isset($page) ? $page->categoryNameAr : Input::old('categoryNameAr') }}" id="categoryNameAr" placeholder="Category Name Arabic" dir="rtl">
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
            <input type="hidden" name="categoryID"  value="{{ isset($page) ? $page->id : 0 }}" id="id" >
            <?php
          }
          ?>
        </div>
      </div>
    </form>
  </article>
</div>


@endsection