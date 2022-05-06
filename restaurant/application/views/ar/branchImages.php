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
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);"> جميع صور الفرع <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

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
        if(isset($branchImages)){
            ?>
            <table class="table table-bordered table-striped sufrati-backend-table" id="table-results-table">
                <thead>
                <th>
                
                </th>
                <th>
                 العنوان
                </th>
                <th>
                    عرض 
                </th>
                <th>
                    تحديث / تعديل
                </th>
                </thead>
                <tbody>

            <?php
            foreach($branchImages as $value){
               
            ?>
              <tr>
                  <td>
                      
                  </td>
                  <td>
                      <?php echo (htmlspecialchars($value['title'])).' - '.(htmlspecialchars($value['title_ar'])); ?>
                  </td>
                  <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
                    <img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $value['image_full'];?>" width="100" height="100"/>
                </td>
                <td>
                    <a href="<?php echo site_url('ar/branches/photofrom/'.$value['image_ID'].'?rest='.$value['rest_ID'].'&br_id='.$value['branch_ID']);?>"  rel="tooltip" data-original-title="تحرير" >
                 <i class="icon icon-edit"> </i>
                 تحرير 
                    </a><br/>
            <a href="<?php echo site_url('ar/branches/usergallerystatus?id='.$value['image_ID'].'&rest='.$value['rest_ID'].'&br_id='.$value['branch_ID']);?>"  rel="tooltip" data-original-title="<?php echo $value['status']==0 ? 'تفعيل الصورة': 'إلغاء تفعيل الصورة';?>">
                 
                 <?php
					if($value['status']==1){
						?>
					<i class="icon icon-ban-circle"></i> إلغاء تفعيل
					<?php
					}else{
					?>
					<i class="icon icon-ok"></i> تفعيل
					<?php }?>
             </a><br/>
             <a href="<?php echo site_url('ar/branches/usergallerydelete?id='.$value['image_ID'].'&rest='.$value['rest_ID'].'&br_id='.$value['branch_ID']);?>"  rel="tooltip" data-original-title="<?php echo $value['is_read']==0 ? 'حذف': 'حذف';?>" onclick="return confirm('Do You Want to Delete?')">
                 <i class="icon-remove"> </i>
                 حذف 
             </a>
        </td>
              </tr>
               <?php
            }
            ?>
                         
                </tbody>
        </table>
            <?php
        }
    ?>
          
          
    
      </div>
    </article>
  </div>
</section>
