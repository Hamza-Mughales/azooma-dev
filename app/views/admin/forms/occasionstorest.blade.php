<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincompetitions'); ?>">All Competitions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<?php

$error = Session::get('error');
?>
<?php
$restoptions = "";
foreach ($restaurants as $rest) {
    $restoptions.='<option value="' . $rest->rest_ID . '"';
    if (isset($catering) && !empty($catering->reqRest)) {
        $rest_IDs = "";
        $rest_IDs = explode(",", $catering->reqRest);
        if (in_array($rest->rest_ID, $rest_IDs)) {
            $restoptions.=' selected="selected"';
        }
    }
    $restoptions.='>' . stripslashes(($rest->rest_Name)) . '</option>';
}
?>
<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }} - Information</legend>        
        </fieldset>
        <form id="jqValidate"class="form-horizontal restaurant-form" method="post" action="{{ route('adminoccasions/sendtorest') }}" enctype="multipart/form-data">
            <fieldset>
                <div class="overflow">
                    <div class="col-lg-5 left">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Reference Number</label>
                                <div class="col-lg-7">
                                    <b><?php echo 'SUF000' . $catering->id; ?></b>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Event Title</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Event Type</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->type);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Total Guests</label>
                                <div class="col-lg-7">
                                    <span class="label label-info" style="font-weight:bold;font-size: 15px;line-height: 22px;"><?php
                                        echo stripslashes($catering->guests);
                                        ?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Budget</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->budget);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Date</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->date);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Meal Type</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->mealType);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Meal</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->meals);
                                    ?>
                                </div>
                            </div>



                        </fieldset>
                    </div>
                    <div class="col-lg-5 left">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Location</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->location);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Serving Style</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->servingStyle);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Dining Setup</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->diningSetup);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">staff Required</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->staffReq);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Additional Notes</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->notes);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Preferred Cuisine</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo MOccasions::getCuisineNames($catering->cuisines);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Beverage</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->beverage);
                                    ?>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
                <div class="overflow clear span10">
                    <fieldset>
                        <legend>Forward Information</legend>

                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="tagRest">
                                Restaurants
                                <span id="restReq" class="error hidden">(required)</span>
                            </label>
                            <div class="col-md-6">
                                <select multiple class="chzn-select required form-control" tabindex="6" style="width: 450px;" data-placeholder="Tag a Restaurant" name="tagRest[]" id="tagRest">
                                    <?php echo $restoptions; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label">Additional Notes</label>
                            <div class="col-md-6">
                                <textarea name="notes" class="form-control" id="notes" rows="10" cols="30"><?php
                                    if (!empty($catering->restNotes)) {
                                        echo $catering->restNotes;
                                    } else {
                                        echo stripslashes($catering->notes);
                                    }
                                    ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" ></label>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" ></label>
                            <div class="col-md-6">
                                <?php if (isset($catering)) {
                                    ?>
                                    <input type="hidden" name="id" id="id" value="<?php echo $catering->id; ?>"/>
                                    <input type="submit" name="submit" value="Forward" class="btn btn-primary"/>
                                    <input type="hidden" name="view" id="viewID" value="0" class="btn btn-primary"/>
                                    <input type="submit" onclick="return checkView();" class="btn btn-info" value="Preview">
                                    <?php
                                }
                                ?>
                                <a class="btn btn-light" href="<?php echo URL::to('hungryn137/adminoccasions'); ?>">Back</a>    
                            </div>
                        </div>
                    </fieldset>
                </div>
            </fieldset>
        </form>
    </article>
</div>

<?php
echo HTML::script('js/ckeditor/ckeditor.js');
echo HTML::script('js/ckfinder/ckfinder.js');

?>

<script>

    $(document).ready(function() {

        //<![CDATA[
        var editor_details = CKEDITOR.replace('notes');
        CKFinder.setupCKEditor(editor_details, base + '/js/ckfinder/');
        //]]>
        
    });

    function checkView() {
        $('#viewID').val(1);
        $("#restMainForm").submit();
    }

    $.validator.setDefaults({
        submitHandler: function(form) {
            var rrr = "";
            rrr = $('#tagRest').val();
            if (!rrr) {
                $('#restReq').removeClass('hidden');
                $('#restReq').show();
                return false;
            }
            $('#restReq').addClass('hidden');
            $('#restReq').hide();
            $("#restMainForm").submit();

        }
    });

</script>
<style>
    .overflow{
        overflow: hidden;
    }
    label{
        font-weight: bold; 
    }
</style>