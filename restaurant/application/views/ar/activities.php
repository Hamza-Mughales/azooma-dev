
<section id="top-banner">
  
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
  <li class="active">تحديثات </li>
</ul>
     <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
    
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#activities"> <a class="accordion-toggle" href="javascript:void(0);">  آخر الأنشطة الخاصة بك <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="activities" class="collapse in accordion-inner">
       
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
               <th>تاريخ</th>
              <th>الأنشطة</th>
              <th>تاريخ</th>
          </thead>
          <tbody>
            <?php $i=1;	foreach ( $activities as $p ) { ?>
            <tr>
              <td><?php echo $this->MGeneral->convertToArabic($i); ?></td>
              <td><?php echo $p['activity'];?></td>
              <td><?php echo $this->MGeneral->convertToArabic($p['date_add']);?></td>
            </tr>
            <?php $i++; } ?>
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
