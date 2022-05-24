<?php
$restoptions = "";
foreach ($restaurants as $rest) {
    $restoptions.='<option value="' . $rest->rest_ID . '"';
    $restoptions.='>' . stripslashes(($rest->rest_Name)) . '</option>';
}
$i = $counter;
?>
<legend>
    Slide <?php echo ($i + 1); ?>
    <a class="close Azooma-close-slide" href="javascript:void(0);" data-dismiss-id="0" data-dismiss="slide-<?php echo $i; ?>">×</a>
</legend>

<div id="slide-<?php echo $i; ?>">
    <div class="form-group row">
        <label class="col-md-2 control-label" for="slidename-<?php echo $i; ?>">Slide Title</label>
        <div class="col-md-6">
            <input class="required form-control" type="text" name="slidename-<?php echo $i; ?>" id="slidename-<?php echo $i; ?>" placeholder="Slide Title" value="" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label" for="slideNameAr-<?php echo $i; ?>">Slide Title Arabic</label>
        <div class="col-md-6">
            <input class="required form-control" dir="rtl" type="text" name="slideNameAr-<?php echo $i; ?>" id="slideNameAr-<?php echo $i; ?>" placeholder="Slide Title Arabic" value="" />
        </div>
    </div>                            
    <div class="form-group row">
        <label class="col-md-2 control-label" for="logo-<?php echo $i; ?>">
            Slide Logo Image
            <br /><span class="small-font">(100 * 100)</span>
        </label>
        <div class="col-md-6">
            <input type="file" name="logo-<?php echo $i; ?>" id="logo-<?php echo $i; ?>" />
        </div>
    </div>         
    <div class="form-group row">
        <label class="col-md-2 control-label" for="image-<?php echo $i; ?>">
            Slide Image
            <br /><span class="small-font">(490 * 250)</span>
        </label>
        <div class="col-md-6">
            <input type="file" name="image-<?php echo $i; ?>" id="image-<?php echo $i; ?>" />
        </div>
    </div>         
    <div class="form-group row">
        <label class="col-md-2 control-label" for="rest-<?php echo $i; ?>">Tag a Restaurant</label>
        <div class="col-md-6">
            <select multiple class="chzn-select form-control" tabindex="6" style="width: 350px;" data-placeholder="Tag a Restaurant" name="tagRest-<?php echo $i; ?>[]" id="tagRest-<?php echo $i; ?>">
                <?php echo $restoptions; ?>
            </select>                          
        </div>
    </div>                            
    <div class="form-group row">
        <label class="col-md-2 control-label" for="description-<?php echo $i; ?>">Slide Content</label>
        <div class="col-md-6">
            <textarea class="form-control" name="description-<?php echo $i; ?>" id="description-<?php echo $i; ?>" rows="5" placeholder="Article Content"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label" for="descriptionAr-<?php echo $i; ?>">Slide Content Arabic</label>
        <div class="col-md-6">
            <textarea class="form-control" dir="rtl" name="descriptionAr-<?php echo $i; ?>" id="descriptionAr-<?php echo $i; ?>" rows="5" placeholder="Article Content Arabic"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label" for="Status-<?php echo $i; ?>">Publish</label>
        <div class="col-md-6">
            <input type="checkbox" checked="checked" name="status-<?php echo $i; ?>" value="1"/>
        </div>
    </div>
</div>
<script type="text/javascript">    
    //<![CDATA[
    CKFinder.setupCKEditor( CKEDITOR.replace('description-<?php echo $i; ?>'), base+'/js/ckfinder/' );    
    CKFinder.setupCKEditor( CKEDITOR.replace('descriptionAr-<?php echo $i; ?>'), base+'/js/ckfinder/' );
    //]]>
</script>