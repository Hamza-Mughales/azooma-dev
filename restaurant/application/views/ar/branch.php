
<section id="top-banner">
<ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
<li>
<a href="<?php echo site_url('ar/branches');?>">الفروع</a> <span class="divider">/</span>
</li>
<li class="active">فرع </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin">
            <a class="btn btn-primary" href="<?=base_url('ar/branches/from/'.$rest['rest_ID'])?>" title="اضافة فرع">اضافة فرع</a>
            <a class="btn btn-primary" href="<?=base_url('ar/branches/photofrom')?>" title="إضافة صورة جديدة">إضافة صورة جديدة</a>
            </span>
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
            Total <?php echo ($city); ?> Branches (<?php echo $this->MGeneral->convertToArabic($total);?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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

                                                   <th>حي</th>
                                                          <th>عنوان الفرع</th>
                          <th>عنوان الفرع</th>

                          <th>رقم الهاتف</th>
                          <th>تحديث / تعديل 	رقم الهاتف</th>
                                                  </thead>
                  <tbody>

                  <?php foreach ( $branches as $p ) { ?>
                                                  <tr>


                   <td><a href="<?=base_url()?>ar/branches/from/<?=$p['rest_fk_id']?>/<?=$p['br_id']?>">
                                                          <?php 
                                                          echo ($p['district_Name_ar']);
                                                           ?></a></td>
                                                          <td><a href="<?=base_url()?>ar/branches/from/<?=$p['rest_fk_id']?>/<?=$p['br_id']?>"><?=($p['br_loc'])?></a></td>
                                                          <td><a href="<?=base_url()?>ar/branches/from/<?=$p['rest_fk_id']?>/<?=$p['br_id']?>"><?=($p['br_loc_ar'])?></a></td>
                                                          <td>
                                                          <?php echo $this->MGeneral->convertToArabic($p['br_number']); 
                                                                            ?></td>

                                                          <td>
                          <a class="sufrati-backend-actions" href="<?=base_url()?>ar/branches/from/<?=$p['rest_fk_id']?>/<?=$p['br_id']?>" rel="tooltip" data-original-title="تحرير <?php echo (htmlspecialchars($rest['rest_Name'])); ?>">
                  <i class="icon icon-edit"></i> تحرير
              </a>
                              <br>


                          <a class="sufrati-backend-actions" target="_blank" href="<? echo $this->config->item('sa_url').'rest/'.$rest['seo_url'].'/'.$p['br_id']; ?>" rel="tooltip" data-original-title="     معاينة  ">
                  <i class="icon icon-info-sign"></i>
                  معاينة  </a>
 <br>


                          <a class="sufrati-backend-actions" href="<?=base_url()?>ar/branches/photos/<?=$p['br_id']?>/<?=$p['rest_fk_id']?>" rel="tooltip" data-original-title=" معاينة صور">
                  <i class="icon icon-info-sign"></i>
                   معاينة صور </a>




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
