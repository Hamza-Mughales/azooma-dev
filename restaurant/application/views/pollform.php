<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
<a href="<?php echo site_url('offers');?>">Offers</a> <span class="divider">/</span>
</li>
<li class="active">offer </li>
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
          
    
        <form id="pollForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('polls/save');?>" enctype="multipart/form-data">
    <fieldset>
        
        <div class="control-group">
            <label class="control-label" for="question">Poll Question</label>
            <div class="controls">
                <input class="required" type="text" name="question" id="question" placeholder="Poll Question" <?php echo isset($poll)?'value="'.stripslashes($poll['question']).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="question_ar">Poll Question Arabic</label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="question_ar" id="question_ar" placeholder="Poll Question Arabic" <?php echo isset($poll)?'value="'.stripslashes($poll['question_ar']).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">Poll Description</label>
            <div class="controls">
                <textarea rows="6" name="description" id="description" placeholder="Poll Description" ><?php echo isset($poll)?stripslashes($poll['description']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="descriptionAr">Poll Description Arabic</label>
            <div class="controls">
                <textarea dir="rtl" rows="6"  name="descriptionAr" id="descriptionAr" placeholder="Poll Description Arabic" ><?php echo isset($poll)?stripslashes($poll['descriptionAr']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="image">Poll Image
            <br />
            <span class="small-font">Size: (200*200)</span>
            </label>
            <div class="controls">
                <input type="file" name="image" id="image" />
                <?php if(isset($poll)){
                    ?>
                <input type="hidden" name="imageOld" id="imageOld" value="<?php echo $poll['image'];?>"/>
                <?php if($poll['image']!=""){
                        ?>
                <image src="<?php echo $this->config->item('sa_url');?>images/poll/thumb/<?php echo $poll['image'];?>" />
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </fieldset>
            <fieldset>
                <legend>
                    Poll Options
                </legend>
                <div id="poll-options-container" class="padding-top">
       <?php
       if(isset($poll)){
       if(count($options)>0){
           $j=0;
           foreach($options as $option){
           $j++;    ?>
                    <div id="parent-<?php echo $option['id'];?>">
        <div class="control-group  azooma-backend-input-seperator">
            <label class="control-label" for="field-<?php echo $option['id'];?>">Poll Option <?php echo $j;?></label>
            <div class="controls">
                <input class="required" type="text" name="field-<?php echo $option['id'];?>" id="field-<?php echo $option['id'];?>" placeholder="Poll Option <?php echo $j;?>" value="<?php echo $option['field'];?>"/>
                <a class="close azooma-close" href="javascript:void(0);" data-dismiss="input-<?php echo $j;?>">&times;</a>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="field_ar-<?php echo $option['id'];?>">Poll Option Arabic <?php echo $j;?></label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="field_ar-<?php echo $option['id'];?>" id="field_ar-<?php echo $option['id'];?>" placeholder="Poll Option Arabic <?php echo $j;?>" value="<?php echo $option['field_ar'];?>"/>
            </div>
        </div>
                    </div>
        <?php
           }
       }}else{
           ?>
        <div class="control-group">
            <label class="control-label" for="option-1">Poll Option 1</label>
            <div class="controls">
                <input class="required" type="text" name="option[]" id="option-1" placeholder="Poll Option 1">
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label" for="option_ar-1">Poll Option Arabic 1</label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="option_ar[]" id="option_ar-1" placeholder="Poll Option Arabic 1">
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="option-2">Poll Option 2</label>
            <div class="controls">
                <input class="required" type="text" name="option[]" id="option-2" placeholder="Poll Option 2">
            </div>
        </div>   
        <div class="control-group">
            <label class="control-label" for="option_ar-2">Poll Option Arabic 2</label>
            <div class="controls">
                <input class="required" dir="rtl" type="text" name="option_ar[]" id="option_ar-2" placeholder="Poll Option Arabic 2">
            </div>
        </div>  
                    <?php
       }
       ?>
                </div>
       <div class="control-group">
           <label class="control-label" for="status"></label>
           <div class="controls">
               <a href="javascript:void(0);" onclick="addmore();" class="btn btn-large"><i class="icon icon-plus-sign"></i> Add another</a>
           </div>
        </div>
        <div class="control-group">
                <label class="control-label" for="status">Publish</label>
                <div class="controls">
                    <input type="checkbox" <?php if(!isset($poll['status'])||$poll['status']==1 ) echo 'checked="checked"'; ?> name="status" value="1"/>
                </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php if(isset($poll)){
                  ?>
                <input type="hidden" name="id" value="<?php echo $poll['id'];?>"/>
                <?php
                }
                ?>
                <input type="hidden" name="rest_ID" value="<?php echo isset($rest)?$rest['rest_ID']:0;?>"/>
                <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('hungryn137/poll');?>" class="btn" title="Cancel Changes">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>
    

          </div>
    </article>

  </div>
</section>

<script type="text/javascript">
    <?php
    if(isset($poll)){
        ?>
            counter=<?php echo count($options)+1;?>;
            <?php
    }else{
        ?>
            counter=3;
            <?php
    }
    ?>
    $("#pollForm").validate();
</script>