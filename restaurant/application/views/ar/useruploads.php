
<section id="top-banner">
  
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
  <li class="active">صور المستخدم </li>
</ul>
    <?php
       if(count($total)>0){
            echo  $this->pagination->create_links();
                   }
                   ?> 
    <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#useruploads"> <a class="accordion-toggle" href="javascript:void(0);">  آخر صور المستخدم <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="useruploads" class="collapse in accordion-inner">
          <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
?>
         
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
               <th>معرف</th>
              <th>صورة معاينة</th>
              <th>اسم المستخدم</th>
              <th>تاريخ</th>
              <th width="105px">الإجراءات</th>
          </thead>
          <tbody>
            <?php if(isset($latestUserUpload) and !empty($latestUserUpload)){?>
            <?php $i=0;foreach ( $latestUserUpload as $p ) { $i++; ?>
            <tr  <?php if(isset($p['is_read'])) if($p['is_read']==0){ ?> class="new-row" onclick="readPhoto('<?php echo $p['image_ID'] ?>')" <?php }  ?> data-row="<?php echo $p['image_ID'] ?>" >
              <td <?php if(isset($p['status'])) if($p['status']==0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic($i);?></td>
              <td <?php if(isset($p['status'])) if($p['status']==0) echo 'class="strike"';  ?>><img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $p['image_full'];?>" width="100"/></td>
              <td <?php if(isset($p['status'])) if($p['status']==0) echo 'class="strike"';  ?> width="350px"><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
              <td <?php if(isset($p['status'])) if($p['status']==0) echo 'class="strike"';  ?>> <?php  echo date('jS M Y H:i:s',  strtotime($p['enter_time']));?></td>
              <td>
                  <a href="<?php echo site_url('ar/home/usergallerystatus?id='.$p['image_ID'].'&ref=1&limit='.$limit.'&per_page='.$per_page);?>"  rel="tooltip" data-original-title="<?php echo $p['status']==0 ? 'تفعيل الصورة': 'إلغاء تفعيل الصورة';?>">
                 <i <?php  echo $p['status']==0 ? 'class="icon-ok"':'class="icon icon-ban-circle"' ;?>> </i> <?php echo $p['status']==0 ? 'تفعيل': 'إلغاء تفعيل';?>
             </a>
              </td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
              <td colspan="8">&nbsp;&nbsp;لا توجد صور </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </article>
  </div>
    
    <?php
       if(count($total)>0){
            echo  $this->pagination->create_links();
                   }
                   ?> 

</section>
