<section id="top-banner">
  
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
  <li class="active">التقييمات </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#userratings"> <a class="accordion-toggle" href="javascript:void(0);">  أحدث التقييمات آخر <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="userratings" class="collapse in accordion-inner">
        <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="actv">معرف</th>
              <th>اسم المستخدم</th>
              <th class="actv">المذاق</th>
              <th class="actv">الخدمة</th>
              <th class="actv">الجو</th>
              <th class="actv">التقديم</th>
              <th class="actv">التنوع</th>
              <th class="actv">القيمة</th>
          </thead>
          <tbody>
            <?php if(isset($getlates) and !empty($getlates)){?>
            <?php $i=0;	foreach ( $getlates as $p ) { $i++; ?>
            <tr <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?>  <?php if(isset($p['is_read'])) if($p['is_read']==0){ ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php }  ?> data-row="<?php echo $p['rating_ID'] ?>" >
              <td align="center"><?php echo $this->MGeneral->convertToArabic($i);?></td>
              <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Food']);?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Service']);?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Atmosphere']);?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Value']);?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Presentation']);?></td>
              <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Variety']);?></td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
              <td colspan="8">&nbsp;&nbsp;لا توجد تقييمات </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
    </article>
  </div>
</section>
