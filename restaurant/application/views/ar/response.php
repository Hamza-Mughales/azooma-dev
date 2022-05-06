<section id="top-banner">
  <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?php echo site_url('ar/home/comments');?>">التعليقات </a> <span class="divider">/</span>
  </li>
  <li class="active"> إرسال استجابة</li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);">
              Reply Back To '<?php echo $User_Name; ?>'
              <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

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
          <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/home/sendresponse');?>" enctype="multipart/form-data">
  <fieldset>
      <div class="control-group">
          
          <div class="comment-text activity-comment" itemprop="description">
                  " <?php if(isset($comment['review_Msg'])) echo $comment['review_Msg'];?> "
            </div>
     </div>
      
     <div class="control-group">
            <textarea name="replymsg" id="message" rows="10" style="width:600px" placeholder="Message to <?php echo $User_Name; ?>"></textarea>
     </div> 
  </fieldset>
  
  <div class="control-group">
          
              <input type="submit" name="submit" value="إرسال" class="btn btn-primary"/>
              <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/home/comments');?>" class="btn" title="إلغاء">إلغاء</a>
          
      <?php 
              if(isset($rest)){
                  ?>
              <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
              <input type="hidden" name="user_ID" value="<?php echo $user_info['user_ID'];?>"/>
              <input type="hidden" name="review_ID" value="<?php echo $comment['review_ID'];?>"/>
              <input type="hidden" name="rest_Name" value="<?php echo (htmlspecialchars($rest['rest_Name']));?>"/>
              <?php
              }
              ?>
               <?php
                if(isset($_GET['ref'])){
                    ?>
                    <input type="hidden" name="ref" value="<?php echo $_GET['ref'];?>"/>
                    <input type="hidden" name="per_page" value="<?php echo $_GET['per_page'];?>"/>
                    <input type="hidden" name="limit" value="<?php echo $_GET['limit'];?>"/>
                <?php
                }
                ?>
      </div>
</form>
          
      <script type="text/javascript">
    $("#restMainForm").validate();
</script>
      </div>
    </article>
  </div>
</section>