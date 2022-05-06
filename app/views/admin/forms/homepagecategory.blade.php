@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincategoryartwork'); ?>">All Home Page Categories</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincategoryartwork/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">City</label>
                <div class="col-md-6">
                    <select class="form-control required chzn-select" multiple="" data-placeholder="Select City" name="city_ID[]" id="city_ID"> 
                        <option value="0">All Cities</option>
                        <?php
                        if (isset($banner) && $banner->country != 0) {
                            $country = $banner->country;
                        } else {
                            $country = Session::get('admincountry');
                            if (empty($country)) {
                                $country = 1;
                            }
                        }
                        $cities = MGeneral::getAllCities($country);
                        $bannercities = "";
                        if (isset($banner)) {
                            $bannercities = explode(',', $banner->city_ID);
                        }
                        if (is_array($cities)) {
                            foreach ($cities as $value) {
                                $selected = "";
                                if (isset($banner) && in_array($value->city_ID, $bannercities)) {
                                    $selected = 'selected';
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
                <label for="a_title" class="col-md-2 control-label">Title</label>
                <div class="col-md-6">
                    <input type="input" name="a_title" class="form-control" value="{{ isset($banner) ? $banner->a_title : Input::old('a_title') }}" id="title" placeholder="Title">
                </div>
            </div>

            <div class="form-group row">
                <label for="a_title_ar" class="col-md-2 control-label">Arabic Title</label>
                <div class="col-md-6">
                    <input dir="rtl" type="input" name="a_title_ar" class="form-control" value="{{ isset($banner) ? $banner->a_title_ar : Input::old('a_title_ar') }}" id="title" placeholder="Title Arabic">
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">
                    Artwork English
                    <div id="size-div">
                        <span class="small-font">Size: 200 x 125 </span>
                    </div>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image">
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $banner->image; ?>"/>
                        <?php if ($banner->image != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl') . '/images/' . $banner->image; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="image_ar" class="col-md-2 control-label">
                    Artwork Arabic
                    <div id="size-div-ar">
                        <span class="small-font">Size: 200 x 125 </span>
                    </div>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image_ar" id="image_ar">
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="image_ar_old" value="<?php echo $banner->image_ar; ?>"/>
                        <?php if ($banner->image_ar != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl') . '/images/' . $banner->image_ar; ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($banner) ? ($banner->active==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <input type="hidden" name="art_work_name"  value="{{ isset($banner) ? $banner->art_work_name : 0 }}" id="art_work_name" >
                    <?php
                    if (isset($banner)) {
                        ?>
                        <input type="hidden" name="id"  value="{{ isset($banner) ? $banner->id : 0 }}" id="id" >                       
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>


@endsection