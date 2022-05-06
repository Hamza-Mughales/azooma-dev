<section id="top-banner">
<ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li class="active">
الصور 
</li>

</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('ar/gallery/image?rest='.$rest['rest_ID']);?>" title="" class="btn btn-primary ">اضف صورة</a>
            
            <a target="_blank" href="<? echo $this->config->item('sa_url').'rest/'.$rest['seo_url'].'/gallery#profile-nav'; ?>" title="" class="btn btn-inverse">معاينة صفحة</a>
        </span>    
    </div>
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
          

    <?php 
    if(count($images)>0){
        ?>
             
           <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
            <thead>
            <th class="span4">
                العنوان
            </th>
            <th class="span4">
                 عرض
            </th>
            <th>
                تحديث / تعديل
            </th>
            </thead>
            <tbody>
                <?php 
                foreach($images as $image){
                    ?>
                <tr> 
                    <td>
                       <?php echo $image['title'].' - '.$image['title_ar'];?>
                    </td>
                    <td>
                        <img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $image['image_full'];?>"/>
                    </td>
                    <td>
                       
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/gallery/image/'.$image['image_ID'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="تحرير">
                        <i class="icon icon-edit"></i> تحرير
                    </a><br/>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/gallery/delete/'.$image['image_ID'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="حذف" onclick="return confirm('Do You Want to Delete?')">
                        <i class="icon icon-remove"></i>
                        حذف 
                    </a><br/>
                    <?php if($image['is_featured']==0){ ?>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/gallery/makeFeaturedImage/'.$image['image_ID'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title=" وضع صورة للصفحة الشخصية" >
                        <i class="icon icon-star"></i>
                         وضع صورة للصفحة الشخصية
                    </a>
                    <?php }else{ ?>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/gallery/unsetFeaturedImage/'.$image['image_ID'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title=" صورة الصفحة " onclick="return confirm('Do You Want to Remove Profile Photo?')">
                        <i class="icon icon-star"></i>
                        صورة الصفحة 
                    </a>
                    <?php } ?>
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