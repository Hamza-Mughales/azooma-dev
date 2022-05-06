<section id="top-banner">
<ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li class="active">
الصور 
</li>

</ul>
    
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
            <?php echo $pagetitle;?> <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
          </a>
      </h2>
      <div id="results" class="collapse in accordion-inner">
          <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
?>
   
<form id="imageForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/gallery/save');?>" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="image_full">اضف الصورة
                <br />
            <span class="small-font">حجم الصورة: (200*200)</span>
            </label>
            
            
            <div class="controls">
                <input type="file" name="image_full" id="image_full" />
                <?php 
                if(isset($image)){
                    ?>
                <input type="hidden" name="image_full_old" value="<?php echo $image['image_full'];?>"/>
                <input type="hidden" name="image_ID" value="<?php echo $image['image_ID'];?>"/>
                <input type="hidden" name="ratio_old" value="<?php echo $image['ratio'];?>"/>
                <img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $image['image_full'];?>"/>
                <?php
                }
                if(isset($_GET['ref'])){
                ?>
                    <input type="hidden" name="ref" value="<?php echo $_GET['ref'];?>"/>
                    <input type="hidden" name="per_page" value="<?php echo $_GET['per_page'];?>"/>
                    <input type="hidden" name="limit" value="<?php echo $_GET['limit'];?>"/>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title">اسم الصورة - اللغة العربية</label>
            <div class="controls">
                <input type="text" class="required" name="title" id="title" placeholder="Title" <?php echo isset($image)?'value="'.(htmlspecialchars($image['title'])).'"':""; ?> />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="title_ar">اسم الصورة - اللغة الانجليزية</label>
            <div class="controls">
                <input type="text" name="title_ar" class="required" id="title_ar" placeholder="Title Arabic" <?php echo isset($image)?'value="'.(htmlspecialchars($image['title_ar'])).'"':""; ?> />
            </div>
        </div>
        
        <div class="control-group">
                <label class="control-label" for="status">Publish</label>
                <div class="controls">
                    <input type="checkbox" name="status" value="1" checked="checked"/>
                </div>
            </div>
        
        <div class="control-group">
            <label class="control-label" for="aaasas"></label>
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <input type="submit" name="submit" value="إضافة آخر" class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('gallery');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $("#imageForm").validate();
</script>
</div>
    </article>

  </div>
</section>