<section id="top-banner">
  <ul class="breadcrumb">
      <li>
<a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
<a href="<?php echo site_url('ar/video');?>">الفيديو</a> <span class="divider">/</span>
</li>
<li class="active">الفيديو </li>

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
          
<form id="videoForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/video/save');?><?php if(!isset($rest)){ echo '?type=other'; }?>" enctype="multipart/form-data">
    
<?php
if(isset($_GET['ref'])){
?>
<input type="hidden" name="ref" value="<?php echo $_GET['ref'];?>"/>
<input type="hidden" name="per_page" value="<?php echo $_GET['per_page'];?>"/>
<input type="hidden" name="limit" value="<?php echo $_GET['limit'];?>"/>
<?php
}
?>

    <fieldset>
        <div class="control-group">
            <label class="control-label" for="name_en">اسم الفيديو - اللغة الانجليزية</label>
            <div class="controls">
                <input class="required" type="text" name="name_en" id="name_en" placeholder="اسم الفيديو - اللغة الانجليزية" <?php echo isset($video)?'value="'.(htmlspecialchars($video['name_en'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="name_ar">اسم الفيديو - اللغة العربية</label>
            <div class="controls">
                <input class="required" type="text" name="name_ar" id="name_ar" dir="rtl" placeholder="اسم الفيديو - اللغة العربية" <?php echo isset($video)?'value="'.(htmlspecialchars($video['name_ar'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="youtube_en">رابطة اليوتيوب - اللغة الانجليزية</label>
            <div class="controls">
                <input class="required" type="text" name="youtube_en" id="youtube_en" placeholder="رابطة اليوتيوب - اللغة الانجليزية" <?php echo isset($video)?'value="'.(htmlspecialchars($video['youtube_en'])).'"':""; ?> />
                <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="youtube_ar">رابطة اليوتيوب - اللغة العربية</label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="youtube_ar" id="youtube_ar" placeholder="رابطة اليوتيوب - اللغة العربية" <?php echo isset($video)?'value="'.$video['youtube_ar'].'"':""; ?> />
                <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="video_description"> الوصف - اللغة الانجليزية</label>
            <div class="controls">
                <textarea name="video_description" id="video_description" rows="5" placeholder="الوصف - اللغة الانجليزية"><?php echo isset($video)?stripslashes($video['video_description']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="shortDescAr"> الوصف - اللغة العربية</label>
            <div class="controls">
                <textarea dir="rtl" name="video_description_ar" id="video_description_ar" rows="5" placeholder="الوصف - اللغة العربية"><?php echo isset($video)?stripslashes($video['video_description_ar']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="video_tags">كلمات متعلقة بالفيديو - اللغة الإنجليزية</label>
            <div class="controls">
                <input type="text" name="video_tags" id="video_tags" placeholder="كلمات متعلقة بالفيديو - اللغة الإنجليزية" <?php echo isset($video)?'value="'.$video['video_tags'].'"':""; ?> />
               
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="video_tags_ar">كلمات متعلقة بالفيديو - العربية</label>
            <div class="controls">
                <input type="text" dir="rtl" name="video_tags_ar" id="video_tags_ar" placeholder="كلمات متعلقة بالفيديو - العربية" <?php echo isset($video)?'value="'.$video['video_tags_ar'].'"':""; ?> />
                
            </div>
        </div>
        <div class="control-group">
                <label class="control-label" for="rest_Status">تفعيل العرض</label>
                <div class="controls">
                    <input type="checkbox" <?php if(!isset($video['status'])||$video['status']==1 ) echo 'checked="checked"'; ?> name="status" value="1"/>
                </div>
            </div>
        <div class="control-group">
            <label class="control-label" for=""></label>
            <div class="controls">
                <?php 
                if(isset($rest)){ ?>
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <?php }else{ ?>
                    <input type="hidden" name="rest_ID" value="0"/>
                <?php }?>
                <?php if(isset($video)){
                  ?>
                <input type="hidden" name="id" value="<?php echo $video['id'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/video');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $("#videoForm").validate();
</script>
</div>
    </article>

  </div>
</section>
