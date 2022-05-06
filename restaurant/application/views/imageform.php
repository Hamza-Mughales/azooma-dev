<ul class="breadcrumb pt-2">
<li>
<a href="<?php echo base_url('gallery');?>"><?=lang('photo_gallery')?></a> <span class="divider">/</span>
</li>
<li class="active"> <?=lang('restaurant_photos')?></li>

</ul>
<section id="top-banner">

    
  <div class="row-fluid spacer card">
  <div class="card-body">
      <h5 class="text-center">
            <?php echo $pagetitle;?> 
     
      </h5>
      <br>
      <div id="results" class="mt-2 accordion-inner">
      <?php
echo message_box('error');
echo message_box('success');
?>
   
<form id="imageForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('gallery/save');?>" enctype="multipart/form-data">

        <div class="form-group row mb-3">
            <label class="control-label col-md-3 col-md-2" for="image_full"><?=lang('image')?>
              
            </label>
            <div class="col-md-9">
                    <input class="form-control" type="file" name="image_full" id="image_full" />
                    <span class="help-text small-font"><?=lang('img_size')?>: (200*200)</span>
                    
                    <?php 
                    if(isset($image)){
                        ?>
                        <div class="mt-2">
                    <input class="form-control" type="hidden" name="image_full_old" value="<?php echo $image['image_full'];?>"/>
                    <input class="form-control"  type="hidden" name="image_ID" value="<?php echo $image['image_ID'];?>"/>
                    <input  class="form-control" type="hidden" name="ratio_old" value="<?php echo $image['ratio'];?>"/>
                    <img class="" src="<?=app_files_url()?>/Gallery/thumb/<?php echo $image['image_full'];?>"/>
                    </div>
                    <?php
                    }
                    if(isset($_GET['ref'])){
                    ?>
                        <input class="form-control"  type="hidden" name="ref" value="<?php echo $_GET['ref'];?>"/>
                        <input class="form-control"  type="hidden" name="per_page" value="<?php echo $_GET['per_page'];?>"/>
                        <input class="form-control"  type="hidden" name="limit" value="<?php echo $_GET['limit'];?>"/>
                    <?php
                    }
                    ?>
            </div>
       
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="control-label col-sm-2" for="title"><?=lang('title')?></label>
            <div class="col-md-9">
                <input type="text" class="required form-control" name="title" id="title" required placeholder="<?=lang('title')?>" <?php echo isset($image)?'value="'.(htmlspecialchars($image['title'])).'"':""; ?> />
            </div>
        </div>
        
        <div class="form-group mb-3 row">
            <label class="control-label col-md-3 col-md-2" for="title_ar"><?=lang('title_ar')?></label>
            <div class="col-md-9">
                <input type="text" name="title_ar" class="required form-control" required id="title_ar" placeholder="<?=lang('title_ar')?>" <?php echo isset($image)?'value="'.(htmlspecialchars($image['title_ar'])).'"':""; ?> />
            </div>
            
        </div>
        
        <div class="form-group mb-3 row">
                <label class="control-label col-md-3 col-md-2" for="status"><?=lang('publish')?></label>
                <div class="col-md-9">
                <input  type="checkbox" name="status" value="1" checked="checked"/>
                </div>
            </div>
        
        <div class="control-group mb-3 col-12 text-end">
                <input class="btn btn-danger" type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <input class="btn btn-danger" type="submit" name="submit" value="<?=lang('save_upload')?>" />
                <a class="btn btn-light" href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('gallery');?>"  title="Cancel Changes"><?=lang('cancel')?></a>
            
        </div>
</form>
<script type="text/javascript">
    $("#imageForm").validate();
</script>
</div>

  </div>
  </div>
</section>