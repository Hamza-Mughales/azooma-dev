<section id="top-banner">
  <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
<a href="<?php echo site_url('branches');?>">الفروع</a> <span class="divider">/</span>
</li>
<li class="active"><?php echo (htmlspecialchars($title)); ?> </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);"> حدث معلومات الفرع  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

      </h2>

      <div id="restinfo" class="collapse in accordion-inner">
          <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
?>

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
<form id="restsavebranchimageForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/branches/savebranchimage');?>"  enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="title">عنوان الفرع </label>
            <div class="controls">
                <select class="required" name="br_id" id="br_id" >
                    <option value=""> Select Branch</option>
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
        <div class="control-group">
            <label class="control-label" for="title">عنوان الصورة  في اللغة الإنجليزية</label>
            <div class="controls">
                <input type="text" name="title" id="title" placeholder="عنوان الصورة  في اللغة الإنجليزية" <?php echo isset($photo)?'value="'.(htmlspecialchars($photo['title'])).'"':''; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title_ar">عنوان الصورة</label>
            <div class="controls">
                <input type="text" name="title_ar" id="title_ar" placeholder="عنوان الصورة" <?php echo isset($photo)?'value="'.(htmlspecialchars($photo['title_ar'])).'"':''; ?> />
            </div>
        </div>
        <div class="control-group">
                <label class="control-label" for="br_mobile">صورة الفرع 
                 <br />
            <span class="small-font">حجم الصورة: (200*200)</span>
                </label>
                <div class="controls">
                    <input type="file" id="branch_image" name="branch_image" <?php if(isset($photo) && !empty($photo['image_full'])){ }else{ ?> class="required" <?php } ?>>
                    <?php if(isset($photo) && !empty($photo['image_full'])){
                        ?>
                            <input type="hidden" name="branch_image_old" id="branch_image_old" value="<?php echo $photo['image_full'];?>">
                            <img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $photo['image_full'];?>" width="100" height="100"/>
                        <?php
                    } ?>
                </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <input type="submit" name="submit" value=" تحميل صورة" class="btn btn-primary"/>
                
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
    </article>
  </div>
</section>
