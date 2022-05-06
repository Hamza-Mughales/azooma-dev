<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
<a href="<?php echo site_url('polls');?>">Polls</a> <span class="divider">/</span>
</li>
<li>
<a href="<?php echo site_url('polls/options/'.$poll_id);?>"><?php echo $poll['question']; ?></a> <span class="divider">/</span>
</li>
<li class="active"><?php if(isset($option['field'])){ echo $option['field']; }else{ echo "New Poll Option"; } ?> </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
        </span>
            
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
           <?php echo $pagetitle;?>  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
          

<form id="pollForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('polls/optionform');?>" enctype="multipart/form-data">
    <fieldset>

        <div class="control-group">
            <label class="control-label" for="field">Option</label>
            <div class="controls">
                <input class="required" type="text" name="field" id="field" placeholder="Option" <?php echo isset($option)?'value="'.(htmlspecialchars($option['field'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="field_ar">Option Arabic</label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="field_ar" id="field_ar" placeholder="Option Arabic" <?php echo isset($option)?'value="'.(htmlspecialchars($option['field_ar'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
                <label class="control-label" for="status">Publish</label>
                <div class="controls">
                    <input type="checkbox" <?php if(!isset($option['status'])||$option['status']==1 ) echo 'checked="checked"'; ?> name="status" value="1"/>
                </div>
            </div>
        <div class="control-group">
            <div class="controls">
                <?php if(isset($option)){
                  ?>
                <input type="hidden" name="id" value="<?php echo $option['id'];?>"/>
                <?php
                }
                ?>
                <input type="hidden" name="poll_id" value="<?php echo $poll['id'];?>"/>
                <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('hungryn137/poll');?>" class="btn" title="Cancel Changes">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
    $("#pollForm").validate();
</script>



</div>
    </article>

  </div>
</section>