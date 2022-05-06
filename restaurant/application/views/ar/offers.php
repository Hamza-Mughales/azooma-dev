<section id="top-banner">
  
<ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li class="active">
 العروض 
</li>

</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('ar/offers/form?rest='.$rest['rest_ID']);?>" title="إضافة عرض جديد" class="btn btn-primary ">إضافة عرض جديد</a>
            <a href="<?php echo site_url('ar/offers/categories?rest='.$rest['rest_ID']);?>" class="btn right-float" title="انواع العروض">انواع العروض</a>&nbsp;&nbsp;
        </span>
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
            مجموع العرض (<?php echo $this->MGeneral->convertToArabic($total);?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
    if(count($offers)>0){
        ?>
             
                    <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
            <thead>
            <th class="span4">
               اسم العرض 
            </th>
            <th class="span3">
                وصف قصير
            </th>
            <th class="span2">
                تاريخ البدء
            </th>
            <th class="span2">
               تاريخ الانتهاء
            </th>
            <th>
                تحديث / تعديل
            </th>
            </thead>
            <tbody>
                <?php 
                foreach($offers as $offer){
                    ?>
                <tr> 
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                       <?php echo $offer['offerName'].' - '.$offer['offerNameAr'];?>
                    </td>
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                         <?php echo substr($offer['shortDesc'], 0,50 ).'...';?>
                    </td>
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                        <?php echo date(" M, jS Y", strtotime($offer["startDate"]));?>
                    </td>
                    
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                        <?php echo date(" M, jS Y", strtotime($offer["endDate"]));?>
                    </td>
                    <td>
                       
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/offers/form/'.$offer['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="تحرير">
                        <i class="icon icon-edit"></i> تحرير
                    </a><br/>
                     <a class="sufrati-backend-actions" href="<?php echo site_url('ar/offers/status/'.$offer['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="<?php echo $offer['status']==1? " إلغاء التنشيط ":" تنشيط ";?> Offer">
                        <?php
                        if($offer['status']==1){
                            ?>
                        <i class="icon icon-ban-circle"></i> إلغاء تفعيل
                        <?php
                        }else{
                        ?>
                        <i class="icon icon-ok"></i> تفعيل
                        <?php }?>
                    </a><br/>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/offers/delete/'.$offer['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="حذف" onclick="return confirm('Do You Want to Delete?')">
                        <i class="icon icon-remove"></i>
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