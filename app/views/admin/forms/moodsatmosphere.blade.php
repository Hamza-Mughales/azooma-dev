@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('adminmoodsatmosphere'); ?>">Restaurant Features & Services</a></li>  
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
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminmoodsatmosphere/save'); }}" method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="name" class="col-md-2 control-label">Title English</label>
        <div class="col-md-6">
          <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Name English">
        </div>
      </div>
      <div class="form-group row">
        <label for="nameAr" class="col-md-2 control-label">Title Arabic</label>
        <div class="col-md-6">
          <input type="input" name="nameAr" class="form-control required"  value="{{ isset($page) ? $page->nameAr : Input::old('nameAr') }}" id="nameAr" placeholder="Title Arabic" dir="rtl">
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