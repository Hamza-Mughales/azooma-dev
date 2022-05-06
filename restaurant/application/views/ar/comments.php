
<section id="top-banner">
  
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
  <li class="active">التعليقات </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#usercomments"> <a class="accordion-toggle" href="javascript:void(0);">آخر أحدث التعليقات   <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="usercomments" class="collapse in accordion-inner">
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
            echo  $this->pagination->create_links();
                   }
                   ?> 
        <table class="table table-bordered table-striped">
                  <thead>
            <tr>
            <th>معرف</th>
              <th>اسم المستخدم</th>
              <th>تعليق</th>
              <th>تاريخ التعليق </th>
              <th width="105px">الإجراءات</th>
                                                  </thead>
                 <tbody>
                  <?php if(isset($latestcomments) and !empty($latestcomments)){ 

                                                  $i=0;
                                                  foreach ( $latestcomments as $p ) { $i++; 
                                                  ?>
                                                  <tr  <?php if(isset($p['is_read'])) if($p['is_read']==0){ ?> class="new-row" onclick="readcomment('<?php echo $p['review_ID'] ?>')" <?php }  ?> data-row="<?php echo $p['review_ID'] ?>" >
                                                          <td <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic($i);?></td>
                          <td <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?>><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                                          <td <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?> width="350px"><?php echo substr($p['review_Msg'],0,50).'...';?></td>
                                                          <td <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic(date("Y-m-d",strtotime($p['review_Date']))); ?></td>
                                                          <td>
                                                              <a href="<?php echo site_url();?>ar/home/response/<?php echo $p['user_ID'];?>/<?php echo $p['review_ID'].'?ref=1&limit='.$limit.'&per_page='.$per_page;?>"><i class="icon icon-pencil"></i>   إرسال استجابة </a>
                                                              <br />
                                                              <a href="<?php echo site_url('ar/home/usercommentstatus?id='.$p['review_ID'].'&ref=1&limit='.$limit.'&per_page='.$per_page);?>"  rel="tooltip" data-original-title="<?php echo $p['review_Status']==0 ? 'أعلن': 'لا تعلن هذا التعليق';?>">
                                                                  <i <?php  echo $p['review_Status']==0 ? 'class="icon-ok"':'class="icon icon-ban-circle"' ;?>> </i> <?php echo $p['review_Status']==0 ? 'أعلن': 'لا تعلن هذا التعليق';?>
                                                              </a>
                                                          </td>                                        

                                                  </tr>

                       <?php } ?>
                       <?php }else{ ?>
                        <tr><td colspan="8">
                       &nbsp;&nbsp;لا يوجد تعليقات
                       </td></tr>       
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
