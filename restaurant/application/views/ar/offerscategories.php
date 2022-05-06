<section id="top-banner">
  
    <ul class="breadcrumb">
        <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
  <a href="<?php echo site_url('ar/offers');?>">العروض</a> <span class="divider">/</span>
</li>
<li class="active">     فئات عرض خاص
 </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('ar/offers/form?rest='.$rest['rest_ID']);?>" title="إضافة عرض جديد" class="btn btn-primary ">إضافة عرض جديد</a>
            </span>
    </div>
    <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
    
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
             مجموع العرض لأصناف (<?php echo $this->MGeneral->convertToArabic($total);?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
               نوع العرض - اللغة الإنجليزية
            </th>
            <th>
                نوع العرض - اللغة العربية
            </th>
            </thead>
            <tbody>
                <?php 
                foreach($offers as $offer){
                    ?>
                <tr> 
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                       <?php echo $offer['categoryName'];?>
                    </td>
                    <td <?php if(isset($offer['status'])) if($offer['status']==0) echo 'class="strike"';  ?>>
                       <?php echo $offer['categoryNameAr'];?>
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
    <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
</section>