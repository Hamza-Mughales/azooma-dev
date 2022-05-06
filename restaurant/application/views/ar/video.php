<section id="top-banner">
  
<ul class="breadcrumb">
<li>
<a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li class="active">     كليبات الفيديو </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
        <a href="<?php echo site_url('ar/video/form?rest='.$rest['rest_ID']);?>" title="إضافة  فيديو" class="btn btn-primary ">إضافة  فيديو</a>
        <a target="_blank" href="<? echo $this->config->item('sa_url').'rest/'.$rest['seo_url'].'/gallery#profile-nav'; ?>" title="معاينة صفحة" class="btn btn-inverse">معاينة صفحة</a>
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
            <?php echo $pagetitle; ?> <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
    if(count($videos)>0){
        ?>
             
                    <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
            <thead>
            <th class="span4">
               اسم الفيديو 
            </th>
            <th class="span3">
                الوصف 
            </th>
            <th class="span3">
                صورة مصغرة
            </th>
            <th>
                تحديث / تعديل
            </th>
            </thead>
            <tbody>
                <?php 
                $i=0;
                if(!isset($rest)){
                        $i=1;
                    }
                foreach($videos as $video){
                    if($i==1){
                        $rest=$this->MRestaurant->getRest($video['rest_ID']);
                    }
                    ?>
                <tr> 
                    <td <?php if(isset($video['status'])) if($video['status']==0) echo 'class="strike"';  ?>>
                       <?php echo $video['name_en'].' - '.$video['name_ar'];?>
                    </td>
                    <td <?php if(isset($video['status'])) if($video['status']==0) echo 'class="strike"';  ?>>
                         <?php echo stripcslashes(substr($video['video_description'], 0,50 )).'...';?>
                    </td>
                    <td>
                        <?php
                        $youtube="";
                        parse_str( parse_url( $video['youtube_en'], PHP_URL_QUERY ), $var );
                        if(isset($var['v'])){
                        $youtube=$var['v'];
                        }
                        ?>
                        <img src="http://i.ytimg.com/vi/<?php echo $youtube;?>/default.jpg" alt="<?php echo $video['name_en'];?>" width="120" height="90"/>
                    </td>
                    <td>
                       
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/video/form/'.$video['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="تحرير">
                        <i class="icon icon-edit"></i> تحرير
                    </a><br/>
                     <a class="sufrati-backend-actions" href="<?php echo site_url('ar/video/status/'.$video['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="<?php echo $video['status']==1? " إلغاء التنشيط ":" تنشيط ";?> Video">
                        <?php
                        if($video['status']==1){
                            ?>
                        <i class="icon icon-ban-circle"></i> إلغاء تفعيل
                        <?php
                        }else{
                        ?>
                        <i class="icon icon-ok"></i>  تنشيط
                        <?php }?>
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
    <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
</section>