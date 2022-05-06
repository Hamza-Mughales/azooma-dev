@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincity'); ?>">City List</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincity/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="city_Name" class="col-md-2 control-label">City Name English</label>
                <div class="col-md-6">
                    <input type="input" name="city_Name" class="form-control required" value="{{ isset($page) ? $page->city_Name : Input::old('city_Name') }}" id="city_Name" placeholder="City Name English">
                </div>
            </div>
            <div class="form-group row">
                <label for="city_Name_ar" class="col-md-2 control-label">City Name Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="city_Name_ar" class="form-control required"  value="{{ isset($page) ? $page->city_Name_ar : Input::old('city_Name_ar') }}" id="city_Name_ar" placeholder="City Name Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="city_Code" class="col-md-2 control-label">City Code</label>
                <div class="col-md-6">
                    <input type="input" name="city_Code" class="form-control required"  value="{{ isset($page) ? $page->city_Code : Input::old('city_Code') }}" id="city_Code" placeholder="City Code">
                </div>
            </div>

            <div class="form-group row">
                <label for="city_thumbnail" class="col-md-2 control-label">Image</label>
                <div class="col-md-6">
                    <input type="file" name="city_thumbnail" id="city_thumbnail" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="city_thumbnail_old" value="<?php echo $page->city_thumbnail; ?>"/>
                        <?php if ($page->city_thumbnail != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/images/city/<?php echo $page->city_thumbnail; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="city_Description" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea name="city_Description" id="city_Description" class="form-control" rows="5">{{ isset($page) ? $page->city_Description : Input::old('city_Description') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="city_Description_Ar" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-6">
                    <textarea name="city_Description_Ar" id="city_Description_Ar" class="form-control" rows="5">{{ isset($page) ? $page->city_Description_Ar : Input::old('city_Description_Ar') }}</textarea>
                </div>
            </div>    



            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->city_Status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="city_ID"  value="{{ isset($page) ? $page->city_ID : 0 }}" id="city_ID" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>





@endsection