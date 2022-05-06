<section id="top-banner">
  <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
<li class="active">الفروع</li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin">
            <a class="btn btn-primary" href="<?=base_url('ar/branches/from/'.$rest['rest_ID'])?>" title="اضافة فرع">اضافة فرع</a>
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
             عدد الفروع (<?php echo $this->MGeneral->convertToArabic($total);?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
                          if(count($total)>0){
                                  ?>
                                  
                          <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
                                          <thead>
                                                  <tr>
                                                          <th>مدينة - الإنجليزية</th>
                                                          <th>مدينة - العربية</th>
                                                          <th> عدد الفروع</th>
                          <th>تحديث / تعديل</th>
                                                  </thead>
                  <tbody>

                  <?php foreach ( $branches as $p ) { ?>
                                                  <tr>
                      <td><a href="<?=base_url()?>ar/branches/branch/<?=$p['city_ID']?>">
                                                          <?php echo ($p['city_Name']); ?></a></td>
                                                          <td><a href="<?=base_url()?>ar/branches/branch/<?=$p['city_ID']?>"><?php echo ($p['city_Name_ar']); ?></a></td>
                                                          <td><?php echo $this->MGeneral->convertToArabic($this->MRestBranch->getTotalBranches($restid,$p['city_ID'])); ?></td>
                                                          <td>
                          <a class="sufrati-backend-actions" href="<?=base_url()?>ar/branches/branch/<?=$p['city_ID']?>" rel="tooltip" data-original-title="تحرير <?php echo (htmlspecialchars($rest['rest_Name_Ar'])); ?>">
                  <i class="icon icon-edit"></i> معاينة
              </a>

                                                          </td>
                                                  </tr>
                       <?php } ?>                         
                                          </tbody>
                                  </table>

                                  
                          <?php
                          }
                          ?>
      </div>
    </article>

  </div>
</section>
