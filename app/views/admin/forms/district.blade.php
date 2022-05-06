@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
  <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
  <li><a href="<?= route('admindistrict'); ?>">District List</a></li>  
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
    <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admindistrict/save'); }}" method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label for="city_Code" class="col-md-2 control-label">City Name</label>
        <div class="col-md-6">
          <select name="city_ID" id="city_ID" class="form-control">
            <option value="">please select</option>
            <?php
            if(isset($cities) ){
              foreach ($cities as $city) {
                ?>
                <option value="{{$city->city_ID}}" <?php if(isset($page) && $page->city_ID==$city->city_ID){ echo "selected"; }  ?> >{{$city->city_Name}}</option>
                <?php                
              }

            }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="district_Name" class="col-md-2 control-label">District Name English</label>
        <div class="col-md-6">
          <input type="input" name="district_Name" class="form-control required" value="{{ isset($page) ? $page->district_Name : Input::old('district_Name') }}" id="district_Name" placeholder="District Name English">
        </div>
      </div>
      <div class="form-group row">
        <label for="district_Name_ar" class="col-md-2 control-label">District Name Arabic</label>
        <div class="col-md-6">
          <input type="input" name="district_Name_ar" class="form-control required"  value="{{ isset($page) ? $page->district_Name_ar : Input::old('district_Name_ar') }}" id="district_Name_ar" placeholder="District Name Arabic" dir="rtl">
        </div>
      </div>
      <div class="form-group row">
        <label for="district_Status" class="col-md-2 control-label">Publish</label>
        <div class="col-md-6">
          <div class="btn-group">
            <input type="checkbox"  name="district_Status" value="1"  {{ isset($page) ? ($page->district_Status==1) ? 'checked': '' : 'checked' }} >            
          </div>
        </div>
      </div>  

      <div class="form-group row">
        <div class="offset-lg-2 col-md-6">
          <button type="submit" class="btn btn-primary-gradien">Save Now</button>
          <?php
          if(isset($page)){
            ?>
            <input type="hidden" name="district_ID"  value="{{ isset($page) ? $page->district_ID : 0 }}" id="district_ID" >
            <?php
          }
          ?>
        </div>
      </div>
    </form>
  </article>
</div>



@endsection