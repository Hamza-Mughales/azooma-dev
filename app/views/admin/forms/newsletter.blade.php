@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminnewsletter'); ?>">NewsLetters</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<?php
$obj = new MGeneral();




$cityoptions = "";
foreach ($cities as $city) {
    $cityoptions.='<option value="' . $city->city_ID . '"';

    if (isset($page)) {
        if ($page->cities == $city->city_ID) {
            $cityoptions.=' selected="selected"';
        }
    }
    $cityoptions.='>' . $city->city_Name . '</option>';
}
?>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <span class="right">
                    Total Receivers &nbsp;
                    <span id="totreceiver" class="label label-info">
                    <?php 
                    echo $tot = NewsLetter::getReceivers();
                    ?>
                    </span>
                </span>
            </legend>      
        </fieldset>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminnewsletter/save'); }}" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="userType" class="col-md-2 control-label">Users:</label>
                <div class="col-md-6">
                    <select name="receiver" class="form-control required" id="userType" placeholder="users" onchange="checkReceiver();">
                        <option value="" >Select Receiver</option>
                        <?php
                        if (is_array($emailListingReceivers)) {
                            foreach ($emailListingReceivers as $key => $value) {
                                $selected = "";
                                if (isset($page) && $page->recipients == $key) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="{{ $key }}"  {{ $selected }} >{{ $value }}</option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group hidden" id="cityList">
                <label for="subcats" class="col-md-2 control-label">Cities:</label>
                <div class="col-md-6" id="subcat">
                    <select class="form-control required" name="city_ID" id="city_ID" >
                        <option value=""> Select City</option>
                        <?php echo $cityoptions; ?>
                    </select>
                </div>
            </div>

            <div class="form-group hidden" id="cusineList">
                <label for="cuisines" class="col-md-2 control-label">Cuisines</label>
                <div class="col-md-6">

                    <select name="cuisines[]" id="cuisines" class="form-control chzn-select" multiple="">
                        <option value="">Please select Cuisines</option>
                        <?php
                        $selected_cui = array();
                        if (isset($page) && $page->cuisines != "") {
                            $acuisines = $page->cuisines;
                            $selected_cui = explode(",", $acuisines);
                        }
                        if (is_object($cuisines)) {
                            foreach ($cuisines as $cuisine) {
                                $selected = "";
                                if (in_array($cuisine->cuisine_ID, $selected_cui)) {
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $cuisine->cuisine_ID; ?>" <?php echo $selected; ?> ><?php echo $cuisine->cuisine_Name; ?></option>
                                <?php
                            }
                        }
                        ?>                
                    </select>
                </div>
            </div>

            <div class="form-group <?php
            if (isset($page) && $page->receiver == 0) {
                echo '';
            } else {
                echo 'hidden';
            }
            ?>" id="testemails">
                <label class="col-md-2 control-label" for="test">Add Test Recipients</label>
                <div class="col-md-6">
                    <input class="form-control required" <?php echo isset($page) ? 'value="' . $page->recipents_test . '"' : ""; ?> type="text" name="test" id="test" placeholder="Enter multiple emails seperated by Comma" />
                </div>
            </div>


            <div class="form-group row">
                <label for="month" class="col-md-2 control-label">Month</label>
                <div class="col-md-6">
                    <select name="month" class="form-control required" id="month" placeholder="month">
                        <option value="" >Select Month</option>
                        <?php
                        if (isset($page)) {
                            echo $obj->generate_options(1, 12, 'callback_month', 'en', $page->month);
                        } else {
                            echo $obj->generate_options(1, 12, 'callback_month');
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="month" class="col-md-2 control-label">Year</label>
                <div class="col-md-6">
                    <select name="year" id="year" class="form-control required">
                        <option value="">Year</option>
                        <?php
                        if (isset($page)) {
                            echo $obj->generate_options(date('Y'), 2011, false, 'en', $page->year);
                        } else {
                            echo $obj->generate_options(date('Y'), 2011);
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Title English</label>
                <div class="col-md-6">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="image_full" class="col-md-2 control-label">Image</label>
                <div class="col-md-6">
                    <input type="file" name="image" id="image" />
                    <?php
                    if (isset($page)) {
                        ?>
                        <input type="hidden" name="image_old" value="<?php echo $page->image; ?>"/>
                        <?php if ($page->image != "") { ?>
                        <img src="<?php echo Azooma::CDN('images/newsletter/thumb/'.$page->image); ?>" width="100"/>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-2 control-label">Description English</label>
                <div class="col-md-6">
                    <textarea name="description" id="details" class="form-control" rows="5">{{ isset($page) ? $page->message : Input::old('description') }}</textarea>
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
<?php
echo HTML::script('js/ckeditor/ckeditor.js');
echo HTML::script('js/ckfinder/ckfinder.js');
echo HTML::script('js/admin/newsletter.js');
?>
<script type="text/javascript">
    var totalsubs = '<?php echo $tot; ?>';
    $(document).ready(function() {
    
    
    //<![CDATA[
    var editor_details = CKEDITOR.replace('description');
    CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
    //]]>
});
</script>

@endsection