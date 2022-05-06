<div class="breadcrumb-div">
<ul class="breadcrumb">
<li  class="breadcrumb-item">
<a href="<?php echo base_url();?>"><?=lang('Dashboard')?></a> <span class="divider">/</span>
</li>
<li  class="breadcrumb-item">
<a href="<?php echo base_url('branches');?>"><?=lang('branches_locations')?></a> <span class="divider">/</span>
</li>
<li class="active"><?php echo (htmlspecialchars($title)); ?> </li>
</ul>
</div>


<?php
        echo message_box('error');
        echo message_box('success');
        ?>
        <section class="card">

      <div  class="card-body">


<?php 
if((isset($branch))&&($branch['br_number']!="")){
     list($cityCode,$phone) = explode('-',$branch['br_number']);
}
$cityoptions=$citycodes=$cityCode="";
foreach($cities as $city){
    $cityoptions.='<option value="'.$city['city_ID'].'"';
    $citycodes.='<option data-city="'.$city['city_ID'].'" value="'.$city['city_Code'].'"';
    if(isset($branch)){ if($branch['city_ID']==$city['city_ID']) {
        $cityoptions.=' selected="selected"';
    }}
    if((isset($branch))&&($cityCode!="")&&($cityCode==$city['city_Code'])){
        $citycodes.=' selected="selected"';
    }
    $cityoptions.='>'.$city['city_Name'].'</option>';
    $citycodes.='>'.$city['city_Code'].'</option>';
}
?>
<form id="restsavebranchimageForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('branches/savebranchimage');?>"  enctype="multipart/form-data">
    <fieldset>
        <div class="form-group row">
            <label class="col-md-12 control-label" for="title"><?=lang('branch_name')?></label>
            <div class="col-md-12">
                <select class="form-control" name="br_id" id="br_id" required >
                    <option value=""> <?=lang('select_branch')?></option>
                    <?php
                    foreach($branches as $branch){
                    ?>
                        <option value="<?php echo $branch['br_id']; ?>" <?php if(isset($_GET['br_id']) && $_GET['br_id']==$branch['br_id'] ){ echo 'selected'; } ?> ><?php echo (htmlspecialchars($branch['br_loc'])).' - '.(htmlspecialchars($branch['br_loc_ar'])); ?></option>
                    <?php    
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-12 control-label" for="title"><?=lang('photo_title')?></label>
            <div class="col-md-12">
                <input class="form-control" type="text" name="title" id="title" placeholder="<?=lang('photo_title')?>" <?php echo isset($photo)?'value="'.(htmlspecialchars($photo['title'])).'"':''; ?> />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-12 control-label" for="title_ar"><?=lang('photo_title_ar')?></label>
            <div class="col-md-12">
                <input class="form-control" type="text" name="title_ar" id="title_ar" placeholder="<?=lang('photo_title_ar')?>" <?php echo isset($photo)?'value="'.(htmlspecialchars($photo['title_ar'])).'"':''; ?> />
            </div>
        </div>
        <div class="form-group row">
                <label class="col-md-12 control-label" for="br_mobile"><?=lang('branch_photo')?>
            
                </label>
                <div class="col-md-12">
                    <input class="form-control" type="file" id="branch_image" name="branch_image" <?php if(isset($photo) && !empty($photo['image_full'])){ }else{ ?> required <?php } ?> >
                
                    <span class="small-font"><?=lang('img_size')?>: (200*200)</span>
                    <?php if(isset($photo) && !empty($photo['image_full'])){
                        ?>
                        <br>
                            <input type="hidden" name="branch_image_old" id="branch_image_old" value="<?php echo $photo['image_full'];?>">
                            <img src="<?=app_files_url()?>/Gallery/thumb/<?php echo $photo['image_full'];?>" width="100" height="100"/>
                        <?php
                    } ?>
                </div>
        </div>
        <div class="form-group row text-end" >
            <div class="col-md-12">
                <input type="submit" name="submit" value="<?=lang('upload_image')?>" class="btn btn-primary"/>
                
            </div>
        </div>
    </fieldset>
       
       <input type="hidden" name="rest_fk_id" id="rest_fk_id" value="<?php echo $rest['rest_ID'];?>">
       <input type="hidden" name="rest_Name" id="rest_Name" value="<?php echo $rest['rest_Name'];?>">
	   <?php if(isset($photo) && !empty($photo['image_ID'])){ ?>
                <input type="hidden" name="image_ID" id="image_ID" value="<?php echo $photo['image_ID'];?>">
                <?php } ?>
    </form>
    <script>
    $("#restsavebranchimageForm").validate();
    </script>
    
      </div>

</section>
