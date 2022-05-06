@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminartkwork') . '?type=' . $art_work_name; ?>">Artwok</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white container">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminartkwork/save'); }}" method="post" enctype="multipart/form-data">
            <?php
            if ($art_work_name !== "Azooma Logo") {
                ?>
                <div class="form-group row">
                    <label for="title_ar" class="col-md-2 control-label">City</label>
                    <div class="col-md-6">
                        <select class="form-control required chzn-select" multiple="multiple" data-placeholder="Select City" name="city_ID[]" id="city_ID"> 
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
                            $selectArr = array();
                            if (isset($page) && !empty($page->city_ID)) {
                                $selectArr = explode(",", $page->city_ID);
                            }
                            $cities = MGeneral::getAllCities($country);
                            if (is_array($cities)) {
                                foreach ($cities as $value) {
                                    $selected = "";
                                    if (in_array($value->seo_url, $selectArr)) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="{{ $value->seo_url }}" {{ $selected }} >
                                        {{ $value->city_Name }}
                                    </option>
                                    <?php
                                }
                            }
                            ?>                        
                        </select> 
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="title" class="form-control" value="{{ isset($page) ? $page->a_title : Input::old('title') }}" id="title" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="title_ar" class="form-control"  value="{{ isset($page) ? $page->a_title_ar : Input::old('title_ar') }}" id="title_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>
            <div class="form-group row">
                <label for="img_alt" class="col-md-2 control-label">Image Title English</label>
                <div class="col-md-6">
                    <input type="input" name="img_alt" class="form-control" value="{{ isset($page) ? $page->img_alt : Input::old('img_alt') }}" id="img_alt" placeholder="Image Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="img_alt_ar" class="col-md-2 control-label">Image Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="img_alt_ar" class="form-control"  value="{{ isset($page) ? $page->img_alt_ar : Input::old('img_alt_ar') }}" id="img_alt_ar" placeholder="Image Title Arabic" dir="rtl">
                </div>
            </div>
            <?php
            if (strtolower($art_work_name) != strtolower('Azooma Logo')) {
                ?>
                <div class="form-group row">
                    <label for="link" class="col-md-2 control-label">Link</label>
                    <div class="col-md-6">
                        <input type="input" name="link" class="form-control" value="{{ isset($page) ? $page->link : Input::old('link') }}" id="link" placeholder="Link">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="link_ar" class="col-md-2 control-label">Linnk Arabic</label>
                    <div class="col-md-6">
                        <input type="input" name="link_ar" class="form-control"  value="{{ isset($page) ? $page->link_ar : Input::old('jobtitleAr') }}" id="link_ar" placeholder="Link Arabic" dir="rtl">
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="form-group row">
                <label for="image" class="col-md-2 control-label">
                    <?php echo $art_work_name; ?> Artwork English
                    <div id="size-div">
                        <?php
                        if (trim($art_work_name) == "Azooma Logo") {
                            ?>
                            <span class="small-font">Size: 183 x 50 </span>
                            <?php
                        } else {
                            ?>
                            <span class="small-font">Size: 578 x 339</span>
                            <?php
                        }
                        ?>
                    </div>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image">
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php
                        if ($page->image != "") {
                            if (trim($art_work_name) == "Azooma Logo") {
                                ?>
                                <img src="<?php echo Config::get('settings.uploadurl') . '/sufratilogo/' . $page->image; ?>" width="100"/>
                                <?php
                            } else {
                                ?>
                                <img src="<?php echo Config::get('settings.uploadurl') . '/images/' . $page->image; ?>" width="100"/>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="image_ar" class="col-md-2 control-label">
                    <?php echo $art_work_name; ?> Artwork Arabic
                    <div id="size-div">
                        <?php
                        if (trim($art_work_name) == "Azooma Logo") {
                            ?>
                            <span class="small-font">Size: 183 x 50 </span>
                            <?php
                        } else {
                            ?>
                            <span class="small-font">Size: 578 x 339</span>
                            <?php
                        }
                        ?>
                    </div>
                </label>
                <div class="col-md-6">
                    <input type="file" name="image_ar" id="image_ar">
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_ar_old" value="<?php echo $page->image_ar; ?>"/>
                        <?php
                        if ($page->image_ar != "") {
                            if (trim($art_work_name) == "Azooma Logo") {
                                ?>
                                <img src="<?php echo Config::get('settings.uploadurl') . '/sufratilogo/' . $page->image_ar; ?>" width="100"/>
                                <?php
                            } else {
                                ?>
                                <img src="<?php echo Config::get('settings.uploadurl') . '/images/' . $page->image_ar; ?>" width="100"/>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-6">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->active==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save Now</button>
                    <input type="hidden" name="art_work_name"  value="{{ $art_work_name }}" id="art_work_name" >
                    <?php
                    if (isset($page)) {
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