@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admineventcalendar'); ?>">Calendar Events</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<link rel="stylesheet" type="text/css" href="<?php echo asset(css_path()); ?>/date-picker.css">


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
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admineventcalendar/save'); }}" method="post" >
            <div class="form-group row">
                <label for="userType" class="col-md-2 control-label">Users:</label>
                <div class="col-md-7">
                    <select name="recipients" class="form-control required" id="recipients" placeholder="users" onchange="checktotal('recipients');">
                        <option value="" >Select recipients</option>
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
            <div class="form-group row">
                <label for="name" class="col-md-2 control-label">Title English</label>
                <div class="col-md-7">
                    <input type="input" name="name" class="form-control required" value="{{ isset($page) ? $page->name : Input::old('name') }}" id="name" placeholder="Title English">
                </div>
            </div>
            <div class="form-group row">
                <label for="nameAr" class="col-md-2 control-label">Title Arabic</label>
                <div class="col-md-7">
                    <input type="input" name="nameAr" class="form-control required" value="{{ isset($page) ? $page->nameAr : Input::old('nameAr') }}" id="nameAr" placeholder="Title Arabic" dir="rtl">
                </div>
            </div>

            <div class="form-group row">
                <label for="date" class="col-md-2 control-label">Event Date</label>
                <div class="col-md-7">
                    <input type="text" autocomplete="off" name="date" class="form-control required" value="{{ isset($page) ? date('d/m/Y',strtotime($page->date)) : Input::old('date') }}" id="event-date" placeholder="Event Date">                    
                </div>
            </div>

            <div class="form-group row">
                <label for="message" class="col-md-2 control-label">Description English</label>
                <div class="col-md-7">
                    <textarea name="message" id="message" class="form-control" rows="5">{{ isset($page) ? $page->message : Input::old('message') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="messageAr" class="col-md-2 control-label">Description Arabic</label>
                <div class="col-md-7">
                    <textarea name="messageAr" id="messageAr" class="form-control" rows="5">{{ isset($page) ? $page->messageAr : Input::old('messageAr') }}</textarea>
                </div>
            </div>    

            <div class="form-group row">
                <label for="status" class="col-md-2 control-label">Publish</label>
                <div class="col-md-7">
                    <div class="btn-group">
                        <input type="checkbox"  name="status" value="1"  {{ isset($page) ? ($page->status==1) ? 'checked': '' : 'checked' }} >            
                    </div>
                </div>
            </div>  

            <div class="form-group row">
                <div class="offset-lg-2 col-md-7">
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

?>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.en.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.custom.js"></script>
<script>
    $(document).ready(function() {
   
        $('#event-date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
        });

    });
</script>
<script type="text/javascript">
    var totalsubs = '<?php echo $tot; ?>';
</script>
<script type="text/javascript">

    //<![CDATA[
    var editor_details = CKEDITOR.replace('message');
    CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
    var editor_details_ar = CKEDITOR.replace('messageAr');
    CKFinder.setupCKEditor(editor_details_ar, base + '/js/ckfinder/');
    //]]>

</script>
<?php
echo HTML::script('js/admin/newsletter.js');
?>

@endsection 