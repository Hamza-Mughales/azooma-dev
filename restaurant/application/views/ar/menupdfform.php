<section id="top-banner">
<ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
<a href="<?php echo site_url('ar/menus/pdf');?>">القائمة</a> <span class="divider">/</span>
</li>
<li class="active">Pdf القائمة  </li>

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
<form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/menus/savepdf');?>" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="menu">PDF القائمة الإنجليزية<span class="small-text" style="font-size:12px;">(1MB)</span></label>
            <div class="controls">
                <input type="file" name="menu" id="menu" />
                <?php 
                if(isset($menu)){
                    ?>
                <input type="hidden" name="menu_old" value="<?php echo $menu['menu'];?>"/>
                <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu'];?>" title="Download">View Menu</a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="menu_ar">PDF القائمة العربية<span class="small-text" style="font-size:12px;">(1MB)</span></label>
            <div class="controls">
                <input type="file" name="menu_ar" id="menu_ar" />
                <?php 
                if(isset($menu)){
                    ?>
                <input type="hidden" name="menu_ar_old" value="<?php echo (htmlspecialchars($menu['menu_ar']));?>"/>
                <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu_ar'];?>" title="Download">View Menu</a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title">عنوان الإنجليزية</label>
            <div class="controls">
                <input type="text" name="title" dir="ltr" class="required" id="title" placeholder="عنوان الإنجليزية" <?php echo isset($menu)?'value="'.$menu['title'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title_ar">عنوان العربية</label>
            <div class="controls">
                <input type="text" class="required" name="title_ar" id="title_ar" placeholder="عنوان العربية" <?php echo isset($menu)?'value="'.$menu['title_ar'].'"':""; ?> />
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <input type="hidden" name="rest_Name" value="<?php echo $rest['rest_Name'];?>"/>
                <?php if(isset($menu)){
                  ?>
                <input type="hidden" name="id" value="<?php echo $menu['id'];?>"/>
                <input type="hidden" name="pagenumber" value="<?php echo $menu['pagenumber'];?>"/>
                <input type="hidden" name="pagenumberAr" value="<?php echo $menu['pagenumberAr'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $("#menuForm").validate();
</script>

</div>
    </article>

  </div>
</section>