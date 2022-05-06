<section id="top-banner">
  <div class="page-header">
    <h1>مرحبا،  <?php echo ucwords((htmlspecialchars($rest['rest_Name_Ar']))); ?></h1>
  </div>
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
  <li class="active">تغيير الشعار </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);">  تغيير الشعار <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

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
          <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/home/savelogo/');?>" enctype="multipart/form-data">
  <fieldset>
      <div class="control-group">
          <label class="control-label" for="rest_Logo">شعار</label>
          <div class="controls">
              <input type="file" name="rest_Logo" id="rest_Logo" />
              <?php 
              if(isset($rest)&&($rest['rest_Logo']!="")){
                  ?>
              <img src="http://uploads.azooma.co/logos/<?php echo $rest['rest_Logo'];?>"/>
              <input type="hidden" name="rest_Logo_old" value="<?php echo $rest['rest_Logo'];?>"/>
              <?php
              }
              ?>
          </div>
      </div>
    
      
  </fieldset>
  
  <div class="control-group">
          <div class="controls">
              <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
              <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar');?>" class="btn" title="إلغاء">إلغاء</a>
          </div>
      <?php 
              if(isset($rest)){
                  ?>
              <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
              <input type="hidden" name="rest_Name" value="<?php echo $rest['rest_Name'];?>"/>
              <?php
              }
              ?>
      </div>
</form>
      </div>
    </article>
  </div>
</section>