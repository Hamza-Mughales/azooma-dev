@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>      
    <li><a href="<?= route('admingallery', array('type' => $type)); ?>">Gallery</a></li>
    <li class="active">{{ $title }}</li>
</ol>



<div class="well-white container">    
    <article>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admingallery/save'); }}" method="post" enctype="multipart/form-data">
            <legend>{{ $title }}</legend>
            <?php
            if (isset($page) && !empty($page->rest_ID)) {
                ?>            
                <div class="form-group row">
                    <label for="rest_ID" class="col-md-2 control-label">Restaurant</label>
                    <div class="col-md-6">

                        <select name="rest_ID" id="rest_ID" class="form-control chzn-select" placeholder="Please select Restaurant">
                            <?php
                            $selected_ids = array();
                            if (isset($page) && $page->rest_ID != "") {
                                $arest_IDs = $page->rest_ID;
                                $selected_ids = explode(",", $arest_IDs);
                            }
                            if (is_array($restaurants)) {
                                foreach ($restaurants as $restaurant) {
                                    $selected = "";
                                    if (in_array($restaurant->rest_ID, $selected_ids)) {
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option value="<?php echo $restaurant->rest_ID; ?>" <?php echo $selected; ?>><?php echo $restaurant->rest_Name; ?></option>
                                    <?php
                                }
                            }
                            ?>                
                        </select>
                    </div>
                </div>
                <?php
            } elseif (isset($page)) {
                ?>
            <input type="hidden" name="rest_ID"  value="{{ isset($page) ? $page->rest_ID : 0 }}" id="rest_ID" >
                <?php
            }
            ?>
            <div class="form-group row">
                <label for="title" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="title" class="form-control required" value="{{ isset($page) ? $page->title : Input::old('title') }}" id="title" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="title_ar" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-6">
                    <input type="input" name="title_ar" class="form-control required"  value="{{ isset($page) ? $page->title_ar : Input::old('title_ar') }}" id="title_ar" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="image_full" class="col-md-2 control-label">Image</label>
                <div class="col-md-6">
                    <input type="file" name="image_full" id="image_full" <?= isset($page) && $page->image_full ? "":"required"; ?>  />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_full_old" value="<?php echo $page->image_full; ?>"/>
                        <?php if ($page->image_full != "") { ?>
                            <img src="<?php echo Config::get('settings.uploadurl'); ?>/Gallery/thumb/<?php echo $page->image_full; ?>" width="100"/>
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
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary-gradien">Save & Upload</button>
                    <input type="hidden" name="type"  value="{{ $type }}" id="type" >
                    <input type="hidden" name="country"  value="{{ $country }}" id="country" >
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_ID"  value="{{ isset($page) ? $page->image_ID : 0 }}" id="image_ID" >
                        <input type="hidden" name="ratio_old"  value="{{ isset($page) ? $page->ratio : 0 }}" id="ratio_old" >
                        <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </article>
</div>


@endsection